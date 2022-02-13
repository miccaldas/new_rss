<p>Natalie SerrinoGo is a garbage collected language.<br>This makes writing Go simpler, because you can spend less time worrying about managing the lifetime of allocated objects.Memory management is definitely easier in Go than it is in, say, C++.<br>But it’s also not an area we as Go developers can totally ignore, either.<br>Understanding how Go allocates and frees memory allows us to write better, more efficient applications.<br>The garbage collector is a critical piece of that puzzle.In order to better understand how the garbage collector works, I decided to trace its low-level behavior on a live application.<br>In this investigation, I'll instrument the Go garbage collector with eBPF uprobes.<br>The source code for this post lives .Before diving in, let's get some quick context on uprobes, the garbage collector's design, and the demo application we'll be using.<br>are cool because they let us dynamically collect new information without modifying our code.<br>This is useful when you can’t or don’t want to redeploy your app - maybe because it’s in production, or the interesting behavior is hard to reproduce.Function arguments, return values, latency, and timestamps can all be collected via uprobes.<br>In this post, I'll deploy uprobes onto key functions from the Go garbage collector.<br>This will allow me to see how it behaves in practice in my running application.Note: this post uses Go 1.16.<br>I will trace private functions in the Go runtime.<br>However, these functions are subject to change in later releases of Go.Go uses a .<br>For those unfamiliar with the terms, here is a quick summary so you can understand the rest of the post.<br>You can find more detailed information , , , and .Go's garbage collector is called  because it can safely run in parallel with the main program.<br>In other words, it doesn’t need* to halt the execution of your program to do its job.<br>(*more on this later).There are two major phases of garbage collection:: : Here is a simple endpoint that I’ll use in order to trigger the garbage collector.<br>It creates a variably-sized string array.<br>Then it invokes the garbage collector via .Usually, you don't need to call the garbage collector manually, because Go handles that for you.<br>However, this guarantees it kicks in after every API call.Now that we have some context on uprobes and the basics of Go's garbage collector, let's dive in to observing its behavior.First, I decided to add uprobes to following functions in Go's  library.(If you’re interested in seeing how the uprobes were generated, here's the .)After deploying the uprobes, I hit the endpoint and generated an array containing 10 strings that are each 20 bytes.The deployed uprobes observed the following events after that curl call:This makes sense from the  -  is called twice, once as a validation for the prior cycle before starting the next cycle.<br>The mark phase triggers the sweep phase.Next, I took some measurements for  latency after hitting the  endpoint with a variety of inputs.While that was a good high level view, we could use more detail.<br>Next, I probed some helper functions for memory allocation, marking, and sweeping to get the next level of information.These helper functions have arguments or return values that will help us better visualize what is happening (e.g.<br>pages of memory allocated).After hitting the garbage collector with a bit more load, here are the raw results:They’re easier to interpret when plotted as a timeseries:Now we can see what happened:“Stopping the world” refers to the garbage collector temporarily halting everything but itself in order to safely modify the state.<br>We generally prefer to minimize STW phases, because they slow our programs down (usually when it’s most inconvenient…).Some garbage collectors stop the world the entire time garbage collection is running.<br>These are “non concurrent” garbage collectors.<br>While Go’s garbage collector is largely concurrent, we can see from the code that it does technically stop the world in two places.Let's trace the following functions:And trigger garbage collection again:The following events were produced by the new probes:We can see from the  event that garbage collection took 3.1 ms to complete.<br>After I inspected the exact timestamps, it turns out the world was stopped for 300 µs the first time and 365 µs the second time.<br>In other words,  of the garbage collection was performed concurrently.<br>We would expect this ratio to get even better when the garbage collector was invoked “naturally” under real memory pressure.Why does the Go garbage collector need to stop the world?: Set up state and turn on the write barrier.<br>The write barrier ensures that new writes are correctly tracked when GC is running (so that they are not accidentally freed or kept around).: Clean up mark state and turn off the write barrier.Knowing when to run garbage collection is an important consideration for concurrent garbage collectors like Go’s.Earlier generations of garbage collectors were designed to kick in once they reached a certain level of memory consumption.<br>This works fine if the garbage collector is non-concurrent.<br>This means we can overshoot the memory goal if we run the garbage collector too late.<br>(Go can’t just run garbage collection all of the time, either - GC takes away resources and performance from the main application.)Go’s garbage collector uses a  to estimate the optimal times for garbage collection.<br>This helps Go meet its memory and CPU targets without sacrificing more application performance than necessary.As we just established, Go’s concurrent garbage collector relies on a pacer to determine when to do garbage collection.<br>But how does it make that decision?Every time the garbage collector is called, the pacer updates its internal goal for when it should run GC next.<br>This goal is called the trigger ratio.<br>A trigger ratio of  means that the system should run garbage collection again once the heap has gone up  in size.<br>The trigger ratio factors in CPU, memory, and other factors to generate this number.Let’s see how the garbage collector’s trigger ratio changes when we allocate a lot of memory at once.<br>We can grab the trigger ratio by tracing the function .We can see that initially, the trigger ratio is quite high.<br>The runtime has determined that garbage collection won’t be necessary until the program is using  more memory.<br>This makes sense, because the application isn’t doing much (and not using much of the heap).However, once we hit the endpoint to create  of heap allocations, the trigger ratio quickly drops to .<br>Now we need only  more memory before garbage collection should occur (since our memory consumption rose).What happens when I allocate memory, but don’t call the garbage collector? Next I’ll hit the  endpoint, which does the same thing as  but skips the call to .Based on the most recent trigger ratio, the garbage collector shouldn’t have kicked in yet.<br>It turns out, the garbage collector has another trick up its sleeve to prevent out of control memory growth.<br> Goroutines requesting new heap allocations will first have to assist with garbage collection before getting what they asked for.This “assist” system adds latency to the allocation and therefore helps to backpressure the system.<br>It’s really important, because it solves a problem that can arise from concurrent garbage collectors.<br>In a concurrent garbage collector, memory allocation is still being allocated while garbage collection runs.<br>If the program is allocating memory faster than the garbage collector is freeing it, then memory growth will be unbounded.<br>We can trace  to see this process in action.<br> takes in an argument called , which is the amount of assist work requested.We can see that  is the source of the mark and sweep work.<br>It receives a request to fulfill about  units of work.<br>In the previous mark phase diagram, we can see that  performs about 300,000 units of mark work at that same time (just spread out a bit).There’s a lot more to learn about memory allocation and garbage collection in Go! Here’s some other resources to check out:Creating uprobes, like we did in this example, is usually best done in a higher level BPF framework.<br>For this post, I used Pixie’s  feature (which is still in alpha).<br> is another great tool for creating uprobes.<br>You can try out the entire example from this post .Another good option for inspecting the behavior of the Go garbage collector is the gc tracer.<br>Just pass in  when you start your program.<br>It requires a restart, but will tell you all kinds of cool information about what the garbage collector is doing.Questions? Find the Pixie contributors on  or Twitter at .Natalie SerrinoRelated StoriesYaxiong ZhaoJan 19, 2022Hannah TroisiJan 11, 2022Nick LanamDec 14, 2021We are a  sandbox project.Natalie SerrinoGo is a garbage collected language.<br>This makes writing Go simpler, because you can spend less time worrying about managing the lifetime of allocated objects.Memory management is definitely easier in Go than it is in, say, C++.<br>But it’s also not an area we as Go developers can totally ignore, either.<br>Understanding how Go allocates and frees memory allows us to write better, more efficient applications.<br>The garbage collector is a critical piece of that puzzle.In order to better understand how the garbage collector works, I decided to trace its low-level behavior on a live application.<br>In this investigation, I'll instrument the Go garbage collector with eBPF uprobes.<br>The source code for this post lives .Before diving in, let's get some quick context on uprobes, the garbage collector's design, and the demo application we'll be using.<br>are cool because they let us dynamically collect new information without modifying our code.<br>This is useful when you can’t or don’t want to redeploy your app - maybe because it’s in production, or the interesting behavior is hard to reproduce.Function arguments, return values, latency, and timestamps can all be collected via uprobes.<br>In this post, I'll deploy uprobes onto key functions from the Go garbage collector.<br>This will allow me to see how it behaves in practice in my running application.Note: this post uses Go 1.16.<br>I will trace private functions in the Go runtime.<br>However, these functions are subject to change in later releases of Go.Go uses a .<br>For those unfamiliar with the terms, here is a quick summary so you can understand the rest of the post.<br>You can find more detailed information , , , and .Go's garbage collector is called  because it can safely run in parallel with the main program.<br>In other words, it doesn’t need* to halt the execution of your program to do its job.<br>(*more on this later).There are two major phases of garbage collection:: : Here is a simple endpoint that I’ll use in order to trigger the garbage collector.<br>It creates a variably-sized string array.<br>Then it invokes the garbage collector via .Usually, you don't need to call the garbage collector manually, because Go handles that for you.<br>However, this guarantees it kicks in after every API call.Now that we have some context on uprobes and the basics of Go's garbage collector, let's dive in to observing its behavior.First, I decided to add uprobes to following functions in Go's  library.(If you’re interested in seeing how the uprobes were generated, here's the .)After deploying the uprobes, I hit the endpoint and generated an array containing 10 strings that are each 20 bytes.The deployed uprobes observed the following events after that curl call:This makes sense from the  -  is called twice, once as a validation for the prior cycle before starting the next cycle.<br>The mark phase triggers the sweep phase.Next, I took some measurements for  latency after hitting the  endpoint with a variety of inputs.While that was a good high level view, we could use more detail.<br>Next, I probed some helper functions for memory allocation, marking, and sweeping to get the next level of information.These helper functions have arguments or return values that will help us better visualize what is happening (e.g.<br>pages of memory allocated).After hitting the garbage collector with a bit more load, here are the raw results:They’re easier to interpret when plotted as a timeseries:Now we can see what happened:“Stopping the world” refers to the garbage collector temporarily halting everything but itself in order to safely modify the state.<br>We generally prefer to minimize STW phases, because they slow our programs down (usually when it’s most inconvenient…).Some garbage collectors stop the world the entire time garbage collection is running.<br>These are “non concurrent” garbage collectors.<br>While Go’s garbage collector is largely concurrent, we can see from the code that it does technically stop the world in two places.Let's trace the following functions:And trigger garbage collection again:The following events were produced by the new probes:We can see from the  event that garbage collection took 3.1 ms to complete.<br>After I inspected the exact timestamps, it turns out the world was stopped for 300 µs the first time and 365 µs the second time.<br>In other words,  of the garbage collection was performed concurrently.<br>We would expect this ratio to get even better when the garbage collector was invoked “naturally” under real memory pressure.Why does the Go garbage collector need to stop the world?: Set up state and turn on the write barrier.<br>The write barrier ensures that new writes are correctly tracked when GC is running (so that they are not accidentally freed or kept around).: Clean up mark state and turn off the write barrier.Knowing when to run garbage collection is an important consideration for concurrent garbage collectors like Go’s.Earlier generations of garbage collectors were designed to kick in once they reached a certain level of memory consumption.<br>This works fine if the garbage collector is non-concurrent.<br>This means we can overshoot the memory goal if we run the garbage collector too late.<br>(Go can’t just run garbage collection all of the time, either - GC takes away resources and performance from the main application.)Go’s garbage collector uses a  to estimate the optimal times for garbage collection.<br>This helps Go meet its memory and CPU targets without sacrificing more application performance than necessary.As we just established, Go’s concurrent garbage collector relies on a pacer to determine when to do garbage collection.<br>But how does it make that decision?Every time the garbage collector is called, the pacer updates its internal goal for when it should run GC next.<br>This goal is called the trigger ratio.<br>A trigger ratio of  means that the system should run garbage collection again once the heap has gone up  in size.<br>The trigger ratio factors in CPU, memory, and other factors to generate this number.Let’s see how the garbage collector’s trigger ratio changes when we allocate a lot of memory at once.<br>We can grab the trigger ratio by tracing the function .We can see that initially, the trigger ratio is quite high.<br>The runtime has determined that garbage collection won’t be necessary until the program is using  more memory.<br>This makes sense, because the application isn’t doing much (and not using much of the heap).However, once we hit the endpoint to create  of heap allocations, the trigger ratio quickly drops to .<br>Now we need only  more memory before garbage collection should occur (since our memory consumption rose).What happens when I allocate memory, but don’t call the garbage collector? Next I’ll hit the  endpoint, which does the same thing as  but skips the call to .Based on the most recent trigger ratio, the garbage collector shouldn’t have kicked in yet.<br>It turns out, the garbage collector has another trick up its sleeve to prevent out of control memory growth.<br> Goroutines requesting new heap allocations will first have to assist with garbage collection before getting what they asked for.This “assist” system adds latency to the allocation and therefore helps to backpressure the system.<br>It’s really important, because it solves a problem that can arise from concurrent garbage collectors.<br>In a concurrent garbage collector, memory allocation is still being allocated while garbage collection runs.<br>If the program is allocating memory faster than the garbage collector is freeing it, then memory growth will be unbounded.<br>We can trace  to see this process in action.<br> takes in an argument called , which is the amount of assist work requested.We can see that  is the source of the mark and sweep work.<br>It receives a request to fulfill about  units of work.<br>In the previous mark phase diagram, we can see that  performs about 300,000 units of mark work at that same time (just spread out a bit).There’s a lot more to learn about memory allocation and garbage collection in Go! Here’s some other resources to check out:Creating uprobes, like we did in this example, is usually best done in a higher level BPF framework.<br>For this post, I used Pixie’s  feature (which is still in alpha).<br> is another great tool for creating uprobes.<br>You can try out the entire example from this post .Another good option for inspecting the behavior of the Go garbage collector is the gc tracer.<br>Just pass in  when you start your program.<br>It requires a restart, but will tell you all kinds of cool information about what the garbage collector is doing.Questions? Find the Pixie contributors on  or Twitter at .Natalie SerrinoRelated StoriesYaxiong ZhaoJan 19, 2022Hannah TroisiJan 11, 2022Nick LanamDec 14, 2021We are a  sandbox project.</p>
