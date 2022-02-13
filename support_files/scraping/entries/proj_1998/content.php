<p>Let's say I am trying to develop some sort of "high throughput" network application, that for example process IP packet stream into something else.<br>How big of a gain would one get if he decided to do  this in Kernel space as opposed to User space? Is it even good idea to use Kernel space for better performance?Bad idea.<br>If you want to do I/O at high speeds, you want io_uring.If you want high performance networking than what you want is a network cards which can be configured to work entirely in user space.<br> You theoretically could write things in kernel space but then you open yourself to various kinds of corruptions since you loose all protections kernel is offering to user space.Depending in what you want, eBPF can be an alternative.<br>Cilium is a popular network introspection software based on eBPFMembersOnlineLet's say I am trying to develop some sort of "high throughput" network application, that for example process IP packet stream into something else.<br>How big of a gain would one get if he decided to do  this in Kernel space as opposed to User space? Is it even good idea to use Kernel space for better performance?Bad idea.<br>If you want to do I/O at high speeds, you want io_uring.If you want high performance networking than what you want is a network cards which can be configured to work entirely in user space.<br> You theoretically could write things in kernel space but then you open yourself to various kinds of corruptions since you loose all protections kernel is offering to user space.Depending in what you want, eBPF can be an alternative.<br>Cilium is a popular network introspection software based on eBPFMembersOnlineLet's say I am trying to develop some sort of "high throughput" network application, that for example process IP packet stream into something else.<br>How big of a gain would one get if he decided to do  this in Kernel space as opposed to User space? Is it even good idea to use Kernel space for better performance?Bad idea.<br>If you want to do I/O at high speeds, you want io_uring.If you want high performance networking than what you want is a network cards which can be configured to work entirely in user space.<br> You theoretically could write things in kernel space but then you open yourself to various kinds of corruptions since you loose all protections kernel is offering to user space.Depending in what you want, eBPF can be an alternative.<br>Cilium is a popular network introspection software based on eBPFMembersOnline</p>
