<p>Finally a video previewer for rangerHow is the resource usage? I bet this would be pretty heavy without a GPU-accelerated terminal emulator.I've tried it on a number of terminal emulators, but they all work reasonably well, although something like kitty works better.I am working on making .<br> The data load is actually small, only 70-300 kbytes/sec.<br> You don't need a GPU at all on the terminal end just for pixels.<br> On a 5-year-old 2/4 core/thread i3-7100U.Here's the link to the project on github: Try ffmpeg, that way you can get rid of opencv dependency.Check out I used to use Sixel and kitty in windows and cygwin.<br>But unfortunately support is pretty limited.<br>I've tried to make the same in iTerm and Mac with no success.I haven't been able to test iTerm2 in about 2 years, but at that time its sixel and iTerm2 image support were very slow and did not properly align on screen.<br> It may have gotten a lot better since then, I don't know.mlterm, wezterm, and contour all have good sixel and are cross-platform.<br>wezterm also has iTerm2 and Kitty, and last I heard is the only Kitty protocol support on Windows.<br> mintty has sixel and iTerm2 on Windows.<br> foot is Wayland and has really good and fast sixel.<br> xterm.js has a good sixel plugin, and DomTerm has very fast sixel (but may have some glitches).<br> EDIT: A still-too-slow sixel video player using JavaCV and Jexer Looks great.Would this work with a CLI-only linux?As long as the terminal used supports unicode and 8 bit colours it should work.<br>But I don't know if it will work in tty.mpv/mplayer can do this for 20 years - no need to reinvent the wheel.I am sorry in advance that you are the one getting this rant.<br> You aren't alone in this kind of response, I don't intend to pick you out, but you Did It Too.<br>After enough years of this, well I'm Really Fucking Tired Of It.Story time: when I first posted  to Reddit, people were all "twin does that".<br> No, it does not.<br> twin does not .<br> twin has .<br> twin does not support images at all, it does not  it does not  and it does not play videos (a bit too slowly but still) in a  that could be part of a larger system.<br> mpv/mplayer doesn't do those things either.<br> In fact, the only two projects I know of that can do these kinds of tricks are Jexer and .<br> (And notcurses is hella faster and great, and I would have used it in 2013 when I started Jexer, but it didn't exist then.)Yet mpv/mplayer and twin are all  they have their fans and users, and sometimes they are the perfect solution.When you tell someone to stop because "it's already been done", you are trying to close the door to them discovering something awesome.<br> Take  - it's really cool, the dev is energetic, and it inspires others.<br> I would have been furious if someone had said to him "don't bother, just use  because it has tiled and cascading terminals, and is the  multiplexer with full image support".<br> XtermWM was a minor diversion so I could continue on a path towards .<br>  I'm excited to see where vtm goes; I already love its translucent windows, gradients, and animations -- so much so that I thought harder about some notes from notcurses and Just as I am excited to see where  decides to take ptmv.<br> Maybe they get bored and move on, or maybe they find something lovely.<br> I just hope they have fun for the time they are doing it.Can it though?Very nice!Do your own thing, always, so this is not to tell you to change things up.<br>But if you are looking for peers or ideas, check out chafa and notcurses.<br>If you decide to go for a pixel-based image format (sixel or iTerm2), I can provide some notes (see my pinned posts).But again, keep hacking on and see where your imagination goes.<br>:)Poor terminal, its not built to withstand that output rateCheck out mpv.<br>It can play videos in terminal using less resources than any web browser.<br>Also notice that OP is using python, which gives additional overhead.<br>Most terminals are capable of really high IO throughput (except powershell, which sucks ass in this matter), so I'd rather say that using python is more handicapping than the fact of using terminal to display graphics.I use  to play video in my terminal.<br>It works pretty well.<br>Will look at this also though.Great tool, Will share it with my friends.Fantastic!!MembersOnlineFinally a video previewer for rangerHow is the resource usage? I bet this would be pretty heavy without a GPU-accelerated terminal emulator.I've tried it on a number of terminal emulators, but they all work reasonably well, although something like kitty works better.I am working on making .<br> The data load is actually small, only 70-300 kbytes/sec.<br> You don't need a GPU at all on the terminal end just for pixels.<br> On a 5-year-old 2/4 core/thread i3-7100U.Here's the link to the project on github: Try ffmpeg, that way you can get rid of opencv dependency.Check out I used to use Sixel and kitty in windows and cygwin.<br>But unfortunately support is pretty limited.<br>I've tried to make the same in iTerm and Mac with no success.I haven't been able to test iTerm2 in about 2 years, but at that time its sixel and iTerm2 image support were very slow and did not properly align on screen.<br> It may have gotten a lot better since then, I don't know.mlterm, wezterm, and contour all have good sixel and are cross-platform.<br>wezterm also has iTerm2 and Kitty, and last I heard is the only Kitty protocol support on Windows.<br> mintty has sixel and iTerm2 on Windows.<br> foot is Wayland and has really good and fast sixel.<br> xterm.js has a good sixel plugin, and DomTerm has very fast sixel (but may have some glitches).<br> EDIT: A still-too-slow sixel video player using JavaCV and Jexer Looks great.Would this work with a CLI-only linux?As long as the terminal used supports unicode and 8 bit colours it should work.<br>But I don't know if it will work in tty.mpv/mplayer can do this for 20 years - no need to reinvent the wheel.I am sorry in advance that you are the one getting this rant.<br> You aren't alone in this kind of response, I don't intend to pick you out, but you Did It Too.<br>After enough years of this, well I'm Really Fucking Tired Of It.Story time: when I first posted  to Reddit, people were all "twin does that".<br> No, it does not.<br> twin does not .<br> twin has .<br> twin does not support images at all, it does not  it does not  and it does not play videos (a bit too slowly but still) in a  that could be part of a larger system.<br> mpv/mplayer doesn't do those things either.<br> In fact, the only two projects I know of that can do these kinds of tricks are Jexer and .<br> (And notcurses is hella faster and great, and I would have used it in 2013 when I started Jexer, but it didn't exist then.)Yet mpv/mplayer and twin are all  they have their fans and users, and sometimes they are the perfect solution.When you tell someone to stop because "it's already been done", you are trying to close the door to them discovering something awesome.<br> Take  - it's really cool, the dev is energetic, and it inspires others.<br> I would have been furious if someone had said to him "don't bother, just use  because it has tiled and cascading terminals, and is the  multiplexer with full image support".<br> XtermWM was a minor diversion so I could continue on a path towards .<br>  I'm excited to see where vtm goes; I already love its translucent windows, gradients, and animations -- so much so that I thought harder about some notes from notcurses and Just as I am excited to see where  decides to take ptmv.<br> Maybe they get bored and move on, or maybe they find something lovely.<br> I just hope they have fun for the time they are doing it.Can it though?Very nice!Do your own thing, always, so this is not to tell you to change things up.<br>But if you are looking for peers or ideas, check out chafa and notcurses.<br>If you decide to go for a pixel-based image format (sixel or iTerm2), I can provide some notes (see my pinned posts).But again, keep hacking on and see where your imagination goes.<br>:)Poor terminal, its not built to withstand that output rateCheck out mpv.<br>It can play videos in terminal using less resources than any web browser.<br>Also notice that OP is using python, which gives additional overhead.<br>Most terminals are capable of really high IO throughput (except powershell, which sucks ass in this matter), so I'd rather say that using python is more handicapping than the fact of using terminal to display graphics.I use  to play video in my terminal.<br>It works pretty well.<br>Will look at this also though.Great tool, Will share it with my friends.Fantastic!!MembersOnlineFinally a video previewer for rangerHow is the resource usage? I bet this would be pretty heavy without a GPU-accelerated terminal emulator.I've tried it on a number of terminal emulators, but they all work reasonably well, although something like kitty works better.I am working on making .<br> The data load is actually small, only 70-300 kbytes/sec.<br> You don't need a GPU at all on the terminal end just for pixels.<br> On a 5-year-old 2/4 core/thread i3-7100U.Here's the link to the project on github: Try ffmpeg, that way you can get rid of opencv dependency.Check out I used to use Sixel and kitty in windows and cygwin.<br>But unfortunately support is pretty limited.<br>I've tried to make the same in iTerm and Mac with no success.I haven't been able to test iTerm2 in about 2 years, but at that time its sixel and iTerm2 image support were very slow and did not properly align on screen.<br> It may have gotten a lot better since then, I don't know.mlterm, wezterm, and contour all have good sixel and are cross-platform.<br>wezterm also has iTerm2 and Kitty, and last I heard is the only Kitty protocol support on Windows.<br> mintty has sixel and iTerm2 on Windows.<br> foot is Wayland and has really good and fast sixel.<br> xterm.js has a good sixel plugin, and DomTerm has very fast sixel (but may have some glitches).<br> EDIT: A still-too-slow sixel video player using JavaCV and Jexer Looks great.Would this work with a CLI-only linux?As long as the terminal used supports unicode and 8 bit colours it should work.<br>But I don't know if it will work in tty.mpv/mplayer can do this for 20 years - no need to reinvent the wheel.I am sorry in advance that you are the one getting this rant.<br> You aren't alone in this kind of response, I don't intend to pick you out, but you Did It Too.<br>After enough years of this, well I'm Really Fucking Tired Of It.Story time: when I first posted  to Reddit, people were all "twin does that".<br> No, it does not.<br> twin does not .<br> twin has .<br> twin does not support images at all, it does not  it does not  and it does not play videos (a bit too slowly but still) in a  that could be part of a larger system.<br> mpv/mplayer doesn't do those things either.<br> In fact, the only two projects I know of that can do these kinds of tricks are Jexer and .<br> (And notcurses is hella faster and great, and I would have used it in 2013 when I started Jexer, but it didn't exist then.)Yet mpv/mplayer and twin are all  they have their fans and users, and sometimes they are the perfect solution.When you tell someone to stop because "it's already been done", you are trying to close the door to them discovering something awesome.<br> Take  - it's really cool, the dev is energetic, and it inspires others.<br> I would have been furious if someone had said to him "don't bother, just use  because it has tiled and cascading terminals, and is the  multiplexer with full image support".<br> XtermWM was a minor diversion so I could continue on a path towards .<br>  I'm excited to see where vtm goes; I already love its translucent windows, gradients, and animations -- so much so that I thought harder about some notes from notcurses and Just as I am excited to see where  decides to take ptmv.<br> Maybe they get bored and move on, or maybe they find something lovely.<br> I just hope they have fun for the time they are doing it.Can it though?Very nice!Do your own thing, always, so this is not to tell you to change things up.<br>But if you are looking for peers or ideas, check out chafa and notcurses.<br>If you decide to go for a pixel-based image format (sixel or iTerm2), I can provide some notes (see my pinned posts).But again, keep hacking on and see where your imagination goes.<br>:)Poor terminal, its not built to withstand that output rateCheck out mpv.<br>It can play videos in terminal using less resources than any web browser.<br>Also notice that OP is using python, which gives additional overhead.<br>Most terminals are capable of really high IO throughput (except powershell, which sucks ass in this matter), so I'd rather say that using python is more handicapping than the fact of using terminal to display graphics.I use  to play video in my terminal.<br>It works pretty well.<br>Will look at this also though.Great tool, Will share it with my friends.Fantastic!!MembersOnline</p>
