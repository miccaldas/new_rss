
As they're wont to do, a certain tweet was floating around the interwebs for a while the other week.

Recruiters be like:

We're looking for someone who can connect to the database using CSS.

It's been a hell of a long time since I last embarked on a quality shitpost project, in fact it's been so long that back then I probably didn't even have the word  in my vocabulary.

To that end, I was partially inspired by an earlier shitpost project based on a blockchain startup's projection of their investors' faces onto 3D cubes.<br>Reminds me of the old days of the internet when everything was just .

I'm not looking to write a recipe here so I'll spare you the life story.<br>Instead, I'm going to talk about how I managed my own new shitpost project: sqlcss.xyz

As the name might suggest, this is how you connect to a database using CSS.<br>It only works in Chrome, unfortunately, but you can provide any SQLite database you like and query it via CSS.

How does it work?

-—

A new set of APIs affectionately known as Houdini give your browser the power to control CSS via its own Object Model in Javascript.<br>In English, this means that you can make custom CSS styles, add custom properties, and so on.

Possibly the biggest feature to come out of this work is the CSS Paint Worklet, which allows you to 'paint' on an element, not unlike the Canvas you know and love, and have the browser treat it as an image in CSS.<br>There are some examples to play with at houdini.how.

However, this worklet provides only a subset of the Worker API, and the canvas context itself is also heavily stripped down.<br>The practical result of this is that your custom CSS painting code provides a smaller sandbox than you might have expected.

What does that mean? You have no network access, so you can kiss  and  goodbye.<br>You have no  functionality on the paint context.<br>Various other JS APIs have also vanished, just in case you were hoping to work around some of those issues.

No need to worry, though.<br>All is not lost.<br>Let's break this down into steps.

—

This has to be the first step, to understand if a proof of concept is even possible.

There's a library called .<br>It's quite literally a version of SQLite compiled into WebAssembly and old-skool ASM.js via emscripten.<br>We can't use the WASM version unfortunately, because it has to fetch a binary over the network.<br>The ASM version doesn't have this limitation though as all of the code is available in a single module.

While the PaintWorklet restricts network access inside the worker, you are still allow to  code as long as it's an ES6 Module.<br>That means the file has to have an  statement somewhere inside it.<br>Unfortunately, sql.js doesn't have an ES6 only build so I modified the script myself to make this work.

Now for the moment of truth: can I set up a database inside my worklet?

Success! No errors.<br>But no data either, so let's fix that.

Easiest thing to do at the start is set up some fake data.<br>Sql.js has a couple of functions to do precisely that.

I've got my test table with some values in it now.<br>I should be able to query this and get those values back, although I'm not sure how the result will be structured.

Results are there, as expected.<br>It would be nice to actually render this result though.

I assumed this would be just like writing text to a canvas.<br>How hard can that be, right?

Nah, that would have been too simple.<br>The context here isn't the same as the context you can get for a canvas element, it only provides a subset of functionality.

It can still draw paths and curves, of course, so the lack of a convenient API is an impediment but not a dealbreaker.

Luckily, a library called opentype.js offers hope of a solution.<br>It can parse a font file and then, given a string of text, generate the letterforms of each character.<br>The practical result of this operation is a path object that represents the string, which can then rendered into my context.

I don't have to modify the opentype library to import it this time, as it's already available from JSPM.<br>If you give JSPM an npm package, it'll autogenerate an ES6 module that you can import directly into your browser.<br>This is fantastic because I really didn't want to have to fuck around with a bundling tool for the sake of a joke project.

One problem here though - it wants to load a font over the network and I can't do that! Gah, foiled again!

…Or am I? It also has a  method that accepts an array buffer.<br>I'll just base64 encode the font then and decode it in my module.

Did I tell you that the worklet doesn't have the APIs for handling base64 strings either? Not even  and ? I had to find a plain JS implementation for that, too.

I put this code in its own file because it's not very…ergonomic…to have to work around a 200kb string of encoded font alongside the rest of the code.

And that's how I abused an ES module to load my font.

The opentype library does all the heavy lifting from now on, so all I need to do is a little mathemology to align things nicely.

Better had do some HTML and CSS to see what's happening.

It works, but there's not enough CSS here and the query is hardcoded.

It would be better if you had to use CSS to query the database.<br>In fact, that's the only way we can communicate with the paint worker from outside of its context as there is no messaging API like with normal workers.

For this, a custom CSS property is required.<br>Defining  has the benefit of subscribing to changes to that property, so this will re-render if the value of that property ever changes.<br>No need to set up any listeners ourselves.

Those CSS properties are known as typed properties, but they're essentially boxed up in a special  class that isn't very useful by itself.<br>So you have to manually convert it to a string or a number or some such to use it, as above.

Just a quick tweak to the CSS now.

Quotes are deliberately omitted here because otherwise I would have to remove them from the string before passing it to the database.<br>That said, this works well!



If you've played with sqlcss.xyz already you will have noticed that I didn't settle for that.<br>After a bit of refactoring, a couple more changes were made.

Hard-coding a database schema and, well, actual data, kinda sucks.<br>It proves the concept but surely we can do better than that.

It would be cool if you could query whatever database you liked, so long as you had the database file handy.<br>I would just have to read that file and base64 encode it, like I did with the font file.

I made an extra CSS property for that, where you can provide your SQLite database as a base64-encoded data URI.<br>The data URI is basically just for show and to make sure it's valid for the DOM; I'll parse that stuff out on the worker side.

The last step is to make it easier to query, because otherwise you have to go into your debugger to manipulate the CSS on an element.

This is possibly the least complicated part of the project.<br>The custom property has a bit of an issue with semicolons, and SQLite doesn't care if the trailing semicolon is omitted, so the easiest thing to do is delete it if it's found in the input.

Now you can use CSS to import and browse your own database!

One thing I left out from all of this is how to nicely render the results when there are a lot of them and they need to be split up onto separate lines.<br>That's not really related to connecting to a database via CSS so I decided it wasn't worth it, but the code is all available on git if you want to take this ridiculous concept even further.





















      -UUU:----F1  Yes, I can connect to a DB in CSS    Bot
      L100%  Git:main  (HTML+) ----------
    
As they're wont to do, a certain tweet was floating around the interwebs for a while the other week.

Recruiters be like:

We're looking for someone who can connect to the database using CSS.

It's been a hell of a long time since I last embarked on a quality shitpost project, in fact it's been so long that back then I probably didn't even have the word  in my vocabulary.

To that end, I was partially inspired by an earlier shitpost project based on a blockchain startup's projection of their investors' faces onto 3D cubes.<br>Reminds me of the old days of the internet when everything was just .

I'm not looking to write a recipe here so I'll spare you the life story.<br>Instead, I'm going to talk about how I managed my own new shitpost project: sqlcss.xyz

As the name might suggest, this is how you connect to a database using CSS.<br>It only works in Chrome, unfortunately, but you can provide any SQLite database you like and query it via CSS.

How does it work?

-—

A new set of APIs affectionately known as Houdini give your browser the power to control CSS via its own Object Model in Javascript.<br>In English, this means that you can make custom CSS styles, add custom properties, and so on.

Possibly the biggest feature to come out of this work is the CSS Paint Worklet, which allows you to 'paint' on an element, not unlike the Canvas you know and love, and have the browser treat it as an image in CSS.<br>There are some examples to play with at houdini.how.

However, this worklet provides only a subset of the Worker API, and the canvas context itself is also heavily stripped down.<br>The practical result of this is that your custom CSS painting code provides a smaller sandbox than you might have expected.

What does that mean? You have no network access, so you can kiss  and  goodbye.<br>You have no  functionality on the paint context.<br>Various other JS APIs have also vanished, just in case you were hoping to work around some of those issues.

No need to worry, though.<br>All is not lost.<br>Let's break this down into steps.

—

This has to be the first step, to understand if a proof of concept is even possible.

There's a library called .<br>It's quite literally a version of SQLite compiled into WebAssembly and old-skool ASM.js via emscripten.<br>We can't use the WASM version unfortunately, because it has to fetch a binary over the network.<br>The ASM version doesn't have this limitation though as all of the code is available in a single module.

While the PaintWorklet restricts network access inside the worker, you are still allow to  code as long as it's an ES6 Module.<br>That means the file has to have an  statement somewhere inside it.<br>Unfortunately, sql.js doesn't have an ES6 only build so I modified the script myself to make this work.

Now for the moment of truth: can I set up a database inside my worklet?

Success! No errors.<br>But no data either, so let's fix that.

Easiest thing to do at the start is set up some fake data.<br>Sql.js has a couple of functions to do precisely that.

I've got my test table with some values in it now.<br>I should be able to query this and get those values back, although I'm not sure how the result will be structured.

Results are there, as expected.<br>It would be nice to actually render this result though.

I assumed this would be just like writing text to a canvas.<br>How hard can that be, right?

Nah, that would have been too simple.<br>The context here isn't the same as the context you can get for a canvas element, it only provides a subset of functionality.

It can still draw paths and curves, of course, so the lack of a convenient API is an impediment but not a dealbreaker.

Luckily, a library called opentype.js offers hope of a solution.<br>It can parse a font file and then, given a string of text, generate the letterforms of each character.<br>The practical result of this operation is a path object that represents the string, which can then rendered into my context.

I don't have to modify the opentype library to import it this time, as it's already available from JSPM.<br>If you give JSPM an npm package, it'll autogenerate an ES6 module that you can import directly into your browser.<br>This is fantastic because I really didn't want to have to fuck around with a bundling tool for the sake of a joke project.

One problem here though - it wants to load a font over the network and I can't do that! Gah, foiled again!

…Or am I? It also has a  method that accepts an array buffer.<br>I'll just base64 encode the font then and decode it in my module.

Did I tell you that the worklet doesn't have the APIs for handling base64 strings either? Not even  and ? I had to find a plain JS implementation for that, too.

I put this code in its own file because it's not very…ergonomic…to have to work around a 200kb string of encoded font alongside the rest of the code.

And that's how I abused an ES module to load my font.

The opentype library does all the heavy lifting from now on, so all I need to do is a little mathemology to align things nicely.

Better had do some HTML and CSS to see what's happening.

It works, but there's not enough CSS here and the query is hardcoded.

It would be better if you had to use CSS to query the database.<br>In fact, that's the only way we can communicate with the paint worker from outside of its context as there is no messaging API like with normal workers.

For this, a custom CSS property is required.<br>Defining  has the benefit of subscribing to changes to that property, so this will re-render if the value of that property ever changes.<br>No need to set up any listeners ourselves.

Those CSS properties are known as typed properties, but they're essentially boxed up in a special  class that isn't very useful by itself.<br>So you have to manually convert it to a string or a number or some such to use it, as above.

Just a quick tweak to the CSS now.

Quotes are deliberately omitted here because otherwise I would have to remove them from the string before passing it to the database.<br>That said, this works well!



If you've played with sqlcss.xyz already you will have noticed that I didn't settle for that.<br>After a bit of refactoring, a couple more changes were made.

Hard-coding a database schema and, well, actual data, kinda sucks.<br>It proves the concept but surely we can do better than that.

It would be cool if you could query whatever database you liked, so long as you had the database file handy.<br>I would just have to read that file and base64 encode it, like I did with the font file.

I made an extra CSS property for that, where you can provide your SQLite database as a base64-encoded data URI.<br>The data URI is basically just for show and to make sure it's valid for the DOM; I'll parse that stuff out on the worker side.

The last step is to make it easier to query, because otherwise you have to go into your debugger to manipulate the CSS on an element.

This is possibly the least complicated part of the project.<br>The custom property has a bit of an issue with semicolons, and SQLite doesn't care if the trailing semicolon is omitted, so the easiest thing to do is delete it if it's found in the input.

Now you can use CSS to import and browse your own database!

One thing I left out from all of this is how to nicely render the results when there are a lot of them and they need to be split up onto separate lines.<br>That's not really related to connecting to a database via CSS so I decided it wasn't worth it, but the code is all available on git if you want to take this ridiculous concept even further.





















      -UUU:----F1  Yes, I can connect to a DB in CSS    Bot
      L100%  Git:main  (HTML+) ----------
    
As they're wont to do, a certain tweet was floating around the interwebs for a while the other week.

Recruiters be like:

We're looking for someone who can connect to the database using CSS.

It's been a hell of a long time since I last embarked on a quality shitpost project, in fact it's been so long that back then I probably didn't even have the word  in my vocabulary.

To that end, I was partially inspired by an earlier shitpost project based on a blockchain startup's projection of their investors' faces onto 3D cubes.<br>Reminds me of the old days of the internet when everything was just .

I'm not looking to write a recipe here so I'll spare you the life story.<br>Instead, I'm going to talk about how I managed my own new shitpost project: sqlcss.xyz

As the name might suggest, this is how you connect to a database using CSS.<br>It only works in Chrome, unfortunately, but you can provide any SQLite database you like and query it via CSS.

How does it work?

-—

A new set of APIs affectionately known as Houdini give your browser the power to control CSS via its own Object Model in Javascript.<br>In English, this means that you can make custom CSS styles, add custom properties, and so on.

Possibly the biggest feature to come out of this work is the CSS Paint Worklet, which allows you to 'paint' on an element, not unlike the Canvas you know and love, and have the browser treat it as an image in CSS.<br>There are some examples to play with at houdini.how.

However, this worklet provides only a subset of the Worker API, and the canvas context itself is also heavily stripped down.<br>The practical result of this is that your custom CSS painting code provides a smaller sandbox than you might have expected.

What does that mean? You have no network access, so you can kiss  and  goodbye.<br>You have no  functionality on the paint context.<br>Various other JS APIs have also vanished, just in case you were hoping to work around some of those issues.

No need to worry, though.<br>All is not lost.<br>Let's break this down into steps.

—

This has to be the first step, to understand if a proof of concept is even possible.

There's a library called .<br>It's quite literally a version of SQLite compiled into WebAssembly and old-skool ASM.js via emscripten.<br>We can't use the WASM version unfortunately, because it has to fetch a binary over the network.<br>The ASM version doesn't have this limitation though as all of the code is available in a single module.

While the PaintWorklet restricts network access inside the worker, you are still allow to  code as long as it's an ES6 Module.<br>That means the file has to have an  statement somewhere inside it.<br>Unfortunately, sql.js doesn't have an ES6 only build so I modified the script myself to make this work.

Now for the moment of truth: can I set up a database inside my worklet?

Success! No errors.<br>But no data either, so let's fix that.

Easiest thing to do at the start is set up some fake data.<br>Sql.js has a couple of functions to do precisely that.

I've got my test table with some values in it now.<br>I should be able to query this and get those values back, although I'm not sure how the result will be structured.

Results are there, as expected.<br>It would be nice to actually render this result though.

I assumed this would be just like writing text to a canvas.<br>How hard can that be, right?

Nah, that would have been too simple.<br>The context here isn't the same as the context you can get for a canvas element, it only provides a subset of functionality.

It can still draw paths and curves, of course, so the lack of a convenient API is an impediment but not a dealbreaker.

Luckily, a library called opentype.js offers hope of a solution.<br>It can parse a font file and then, given a string of text, generate the letterforms of each character.<br>The practical result of this operation is a path object that represents the string, which can then rendered into my context.

I don't have to modify the opentype library to import it this time, as it's already available from JSPM.<br>If you give JSPM an npm package, it'll autogenerate an ES6 module that you can import directly into your browser.<br>This is fantastic because I really didn't want to have to fuck around with a bundling tool for the sake of a joke project.

One problem here though - it wants to load a font over the network and I can't do that! Gah, foiled again!

…Or am I? It also has a  method that accepts an array buffer.<br>I'll just base64 encode the font then and decode it in my module.

Did I tell you that the worklet doesn't have the APIs for handling base64 strings either? Not even  and ? I had to find a plain JS implementation for that, too.

I put this code in its own file because it's not very…ergonomic…to have to work around a 200kb string of encoded font alongside the rest of the code.

And that's how I abused an ES module to load my font.

The opentype library does all the heavy lifting from now on, so all I need to do is a little mathemology to align things nicely.

Better had do some HTML and CSS to see what's happening.

It works, but there's not enough CSS here and the query is hardcoded.

It would be better if you had to use CSS to query the database.<br>In fact, that's the only way we can communicate with the paint worker from outside of its context as there is no messaging API like with normal workers.

For this, a custom CSS property is required.<br>Defining  has the benefit of subscribing to changes to that property, so this will re-render if the value of that property ever changes.<br>No need to set up any listeners ourselves.

Those CSS properties are known as typed properties, but they're essentially boxed up in a special  class that isn't very useful by itself.<br>So you have to manually convert it to a string or a number or some such to use it, as above.

Just a quick tweak to the CSS now.

Quotes are deliberately omitted here because otherwise I would have to remove them from the string before passing it to the database.<br>That said, this works well!



If you've played with sqlcss.xyz already you will have noticed that I didn't settle for that.<br>After a bit of refactoring, a couple more changes were made.

Hard-coding a database schema and, well, actual data, kinda sucks.<br>It proves the concept but surely we can do better than that.

It would be cool if you could query whatever database you liked, so long as you had the database file handy.<br>I would just have to read that file and base64 encode it, like I did with the font file.

I made an extra CSS property for that, where you can provide your SQLite database as a base64-encoded data URI.<br>The data URI is basically just for show and to make sure it's valid for the DOM; I'll parse that stuff out on the worker side.

The last step is to make it easier to query, because otherwise you have to go into your debugger to manipulate the CSS on an element.

This is possibly the least complicated part of the project.<br>The custom property has a bit of an issue with semicolons, and SQLite doesn't care if the trailing semicolon is omitted, so the easiest thing to do is delete it if it's found in the input.

Now you can use CSS to import and browse your own database!

One thing I left out from all of this is how to nicely render the results when there are a lot of them and they need to be split up onto separate lines.<br>That's not really related to connecting to a database via CSS so I decided it wasn't worth it, but the code is all available on git if you want to take this ridiculous concept even further.





















      -UUU:----F1  Yes, I can connect to a DB in CSS    Bot
      L100%  Git:main  (HTML+) ----------
    
As they're wont to do, a certain tweet was floating around the interwebs for a while the other week.

Recruiters be like:

We're looking for someone who can connect to the database using CSS.

It's been a hell of a long time since I last embarked on a quality shitpost project, in fact it's been so long that back then I probably didn't even have the word  in my vocabulary.

To that end, I was partially inspired by an earlier shitpost project based on a blockchain startup's projection of their investors' faces onto 3D cubes.<br>Reminds me of the old days of the internet when everything was just .

I'm not looking to write a recipe here so I'll spare you the life story.<br>Instead, I'm going to talk about how I managed my own new shitpost project: sqlcss.xyz

As the name might suggest, this is how you connect to a database using CSS.<br>It only works in Chrome, unfortunately, but you can provide any SQLite database you like and query it via CSS.

How does it work?

-—

A new set of APIs affectionately known as Houdini give your browser the power to control CSS via its own Object Model in Javascript.<br>In English, this means that you can make custom CSS styles, add custom properties, and so on.

Possibly the biggest feature to come out of this work is the CSS Paint Worklet, which allows you to 'paint' on an element, not unlike the Canvas you know and love, and have the browser treat it as an image in CSS.<br>There are some examples to play with at houdini.how.

However, this worklet provides only a subset of the Worker API, and the canvas context itself is also heavily stripped down.<br>The practical result of this is that your custom CSS painting code provides a smaller sandbox than you might have expected.

What does that mean? You have no network access, so you can kiss  and  goodbye.<br>You have no  functionality on the paint context.<br>Various other JS APIs have also vanished, just in case you were hoping to work around some of those issues.

No need to worry, though.<br>All is not lost.<br>Let's break this down into steps.

—

This has to be the first step, to understand if a proof of concept is even possible.

There's a library called .<br>It's quite literally a version of SQLite compiled into WebAssembly and old-skool ASM.js via emscripten.<br>We can't use the WASM version unfortunately, because it has to fetch a binary over the network.<br>The ASM version doesn't have this limitation though as all of the code is available in a single module.

While the PaintWorklet restricts network access inside the worker, you are still allow to  code as long as it's an ES6 Module.<br>That means the file has to have an  statement somewhere inside it.<br>Unfortunately, sql.js doesn't have an ES6 only build so I modified the script myself to make this work.

Now for the moment of truth: can I set up a database inside my worklet?

Success! No errors.<br>But no data either, so let's fix that.

Easiest thing to do at the start is set up some fake data.<br>Sql.js has a couple of functions to do precisely that.

I've got my test table with some values in it now.<br>I should be able to query this and get those values back, although I'm not sure how the result will be structured.

Results are there, as expected.<br>It would be nice to actually render this result though.

I assumed this would be just like writing text to a canvas.<br>How hard can that be, right?

Nah, that would have been too simple.<br>The context here isn't the same as the context you can get for a canvas element, it only provides a subset of functionality.

It can still draw paths and curves, of course, so the lack of a convenient API is an impediment but not a dealbreaker.

Luckily, a library called opentype.js offers hope of a solution.<br>It can parse a font file and then, given a string of text, generate the letterforms of each character.<br>The practical result of this operation is a path object that represents the string, which can then rendered into my context.

I don't have to modify the opentype library to import it this time, as it's already available from JSPM.<br>If you give JSPM an npm package, it'll autogenerate an ES6 module that you can import directly into your browser.<br>This is fantastic because I really didn't want to have to fuck around with a bundling tool for the sake of a joke project.

One problem here though - it wants to load a font over the network and I can't do that! Gah, foiled again!

…Or am I? It also has a  method that accepts an array buffer.<br>I'll just base64 encode the font then and decode it in my module.

Did I tell you that the worklet doesn't have the APIs for handling base64 strings either? Not even  and ? I had to find a plain JS implementation for that, too.

I put this code in its own file because it's not very…ergonomic…to have to work around a 200kb string of encoded font alongside the rest of the code.

And that's how I abused an ES module to load my font.

The opentype library does all the heavy lifting from now on, so all I need to do is a little mathemology to align things nicely.

Better had do some HTML and CSS to see what's happening.

It works, but there's not enough CSS here and the query is hardcoded.

It would be better if you had to use CSS to query the database.<br>In fact, that's the only way we can communicate with the paint worker from outside of its context as there is no messaging API like with normal workers.

For this, a custom CSS property is required.<br>Defining  has the benefit of subscribing to changes to that property, so this will re-render if the value of that property ever changes.<br>No need to set up any listeners ourselves.

Those CSS properties are known as typed properties, but they're essentially boxed up in a special  class that isn't very useful by itself.<br>So you have to manually convert it to a string or a number or some such to use it, as above.

Just a quick tweak to the CSS now.

Quotes are deliberately omitted here because otherwise I would have to remove them from the string before passing it to the database.<br>That said, this works well!



If you've played with sqlcss.xyz already you will have noticed that I didn't settle for that.<br>After a bit of refactoring, a couple more changes were made.

Hard-coding a database schema and, well, actual data, kinda sucks.<br>It proves the concept but surely we can do better than that.

It would be cool if you could query whatever database you liked, so long as you had the database file handy.<br>I would just have to read that file and base64 encode it, like I did with the font file.

I made an extra CSS property for that, where you can provide your SQLite database as a base64-encoded data URI.<br>The data URI is basically just for show and to make sure it's valid for the DOM; I'll parse that stuff out on the worker side.

The last step is to make it easier to query, because otherwise you have to go into your debugger to manipulate the CSS on an element.

This is possibly the least complicated part of the project.<br>The custom property has a bit of an issue with semicolons, and SQLite doesn't care if the trailing semicolon is omitted, so the easiest thing to do is delete it if it's found in the input.

Now you can use CSS to import and browse your own database!

One thing I left out from all of this is how to nicely render the results when there are a lot of them and they need to be split up onto separate lines.<br>That's not really related to connecting to a database via CSS so I decided it wasn't worth it, but the code is all available on git if you want to take this ridiculous concept even further.





















      -UUU:----F1  Yes, I can connect to a DB in CSS    Bot
      L100%  Git:main  (HTML+) ----------
    
As they're wont to do, a certain tweet was floating around the interwebs for a while the other week.

Recruiters be like:

We're looking for someone who can connect to the database using CSS.

It's been a hell of a long time since I last embarked on a quality shitpost project, in fact it's been so long that back then I probably didn't even have the word  in my vocabulary.

To that end, I was partially inspired by an earlier shitpost project based on a blockchain startup's projection of their investors' faces onto 3D cubes.<br>Reminds me of the old days of the internet when everything was just .

I'm not looking to write a recipe here so I'll spare you the life story.<br>Instead, I'm going to talk about how I managed my own new shitpost project: sqlcss.xyz

As the name might suggest, this is how you connect to a database using CSS.<br>It only works in Chrome, unfortunately, but you can provide any SQLite database you like and query it via CSS.

How does it work?

-—

A new set of APIs affectionately known as Houdini give your browser the power to control CSS via its own Object Model in Javascript.<br>In English, this means that you can make custom CSS styles, add custom properties, and so on.

Possibly the biggest feature to come out of this work is the CSS Paint Worklet, which allows you to 'paint' on an element, not unlike the Canvas you know and love, and have the browser treat it as an image in CSS.<br>There are some examples to play with at houdini.how.

However, this worklet provides only a subset of the Worker API, and the canvas context itself is also heavily stripped down.<br>The practical result of this is that your custom CSS painting code provides a smaller sandbox than you might have expected.

What does that mean? You have no network access, so you can kiss  and  goodbye.<br>You have no  functionality on the paint context.<br>Various other JS APIs have also vanished, just in case you were hoping to work around some of those issues.

No need to worry, though.<br>All is not lost.<br>Let's break this down into steps.

—

This has to be the first step, to understand if a proof of concept is even possible.

There's a library called .<br>It's quite literally a version of SQLite compiled into WebAssembly and old-skool ASM.js via emscripten.<br>We can't use the WASM version unfortunately, because it has to fetch a binary over the network.<br>The ASM version doesn't have this limitation though as all of the code is available in a single module.

While the PaintWorklet restricts network access inside the worker, you are still allow to  code as long as it's an ES6 Module.<br>That means the file has to have an  statement somewhere inside it.<br>Unfortunately, sql.js doesn't have an ES6 only build so I modified the script myself to make this work.

Now for the moment of truth: can I set up a database inside my worklet?

Success! No errors.<br>But no data either, so let's fix that.

Easiest thing to do at the start is set up some fake data.<br>Sql.js has a couple of functions to do precisely that.

I've got my test table with some values in it now.<br>I should be able to query this and get those values back, although I'm not sure how the result will be structured.

Results are there, as expected.<br>It would be nice to actually render this result though.

I assumed this would be just like writing text to a canvas.<br>How hard can that be, right?

Nah, that would have been too simple.<br>The context here isn't the same as the context you can get for a canvas element, it only provides a subset of functionality.

It can still draw paths and curves, of course, so the lack of a convenient API is an impediment but not a dealbreaker.

Luckily, a library called opentype.js offers hope of a solution.<br>It can parse a font file and then, given a string of text, generate the letterforms of each character.<br>The practical result of this operation is a path object that represents the string, which can then rendered into my context.

I don't have to modify the opentype library to import it this time, as it's already available from JSPM.<br>If you give JSPM an npm package, it'll autogenerate an ES6 module that you can import directly into your browser.<br>This is fantastic because I really didn't want to have to fuck around with a bundling tool for the sake of a joke project.

One problem here though - it wants to load a font over the network and I can't do that! Gah, foiled again!

…Or am I? It also has a  method that accepts an array buffer.<br>I'll just base64 encode the font then and decode it in my module.

Did I tell you that the worklet doesn't have the APIs for handling base64 strings either? Not even  and ? I had to find a plain JS implementation for that, too.

I put this code in its own file because it's not very…ergonomic…to have to work around a 200kb string of encoded font alongside the rest of the code.

And that's how I abused an ES module to load my font.

The opentype library does all the heavy lifting from now on, so all I need to do is a little mathemology to align things nicely.

Better had do some HTML and CSS to see what's happening.

It works, but there's not enough CSS here and the query is hardcoded.

It would be better if you had to use CSS to query the database.<br>In fact, that's the only way we can communicate with the paint worker from outside of its context as there is no messaging API like with normal workers.

For this, a custom CSS property is required.<br>Defining  has the benefit of subscribing to changes to that property, so this will re-render if the value of that property ever changes.<br>No need to set up any listeners ourselves.

Those CSS properties are known as typed properties, but they're essentially boxed up in a special  class that isn't very useful by itself.<br>So you have to manually convert it to a string or a number or some such to use it, as above.

Just a quick tweak to the CSS now.

Quotes are deliberately omitted here because otherwise I would have to remove them from the string before passing it to the database.<br>That said, this works well!



If you've played with sqlcss.xyz already you will have noticed that I didn't settle for that.<br>After a bit of refactoring, a couple more changes were made.

Hard-coding a database schema and, well, actual data, kinda sucks.<br>It proves the concept but surely we can do better than that.

It would be cool if you could query whatever database you liked, so long as you had the database file handy.<br>I would just have to read that file and base64 encode it, like I did with the font file.

I made an extra CSS property for that, where you can provide your SQLite database as a base64-encoded data URI.<br>The data URI is basically just for show and to make sure it's valid for the DOM; I'll parse that stuff out on the worker side.

The last step is to make it easier to query, because otherwise you have to go into your debugger to manipulate the CSS on an element.

This is possibly the least complicated part of the project.<br>The custom property has a bit of an issue with semicolons, and SQLite doesn't care if the trailing semicolon is omitted, so the easiest thing to do is delete it if it's found in the input.

Now you can use CSS to import and browse your own database!

One thing I left out from all of this is how to nicely render the results when there are a lot of them and they need to be split up onto separate lines.<br>That's not really related to connecting to a database via CSS so I decided it wasn't worth it, but the code is all available on git if you want to take this ridiculous concept even further.





















      -UUU:----F1  Yes, I can connect to a DB in CSS    Bot
      L100%  Git:main  (HTML+) ----------
    </p>
