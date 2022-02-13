
Video Game Developer
As I read that, I hear the Nodes of Yesod  (by Fred Gray) start to play in my head!When I started at Odin, the game Nodes of Yesod was already underway, plenty of the cool graphics (Astro Charlie, etc) had been created and there was a playable demo (on Spectrum, possibly on C64) already.<br>I have an indelible memory of  somersault animation on  bright blue moon surface.I think Marc (Dawson now Wilding) was working on the title  on C64 (released under the Thor label), which was actually the name of a heavy metal club we frequented in Birkenhead.<br>I'm pretty sure Marc cranked the game out very quickly and if nothing else that game will stand as a memorial to that period of our lives - I think it captured the essence of Stairways pretty well (I seem to remember that the game featured beer, drunks, and a band playing).Stoo Fotheringham was working on graphics for Nodes (and Stairways?), along with Colin Grunes (with whom I would later team up on numerous occasions) and Paul Salmon (with whom I would later work on Robin of the Wood).<br>Rest in peace, Paul.<br>❤️At this time, there was quite a buzz surrounding Nodes of Yesod.<br>The graphics were certainly amongst the best I had ever seen (actual artists!), and I was glad to be asked to work on the game.<br>Besides, Odin had cool, modern offices (in Canning Place - located in Liverpool across the road from the Albert Dock, near the Liver Building, etc - but all demolished in the late '90s), and (all importantly) a spiffy phone system.Odin was run by Paul McKenna who was quite the entrepreneur.<br>A general contractor in the construction industry by trade, he saw that there was potential with computers and computer games, and after an initial stint where he tried to learn some programming, he soon realized he'd be much better off paying other people to do the actual development, with him focusing on the business aspects.The original programmer on Nodes, Dave (I don't recall his last name), was having some difficulty finishing the game.<br>What he had done was actually good - there was a room editing system, the main character could bounce around - a nice demo basically.<br>The problem was that there was a very aggressive schedule (when is this not true?) and Dave basically stopped showing up at the office.<br>So, after a period of a couple of weeks of orientation with the code, Dave was out and I was in.<br>Once Dave was out of the picture, the scope of work for the remaining features really hit home - there was a stack of work to do.<br>The game was looking great though, which provided plenty of motivation for the all-nighters to follow.Sleeping on the office floor became a regular occurrence.<br>I recall numerous occasions where, after a late night, I'd be in my sleeping bag under a table (the offices were modern, I didn't say they were *spacious*) and Paul would bring in some prospective client.<br>I'd just pray that they didn't see me, and lay there, very, very still as the procession of trousered business legs went by.As I recall, we were using the venerable Microdrives as development media when I arrived at Odin.<br>I'm not sure what assembler was being used - possibly Devpac.<br>Pretty soon we moved development over to a more robust system, and we ended up using BBC micros with the Z80 second processor running CP/M.<br>Under CP/M we used the M80 assembler and the L80 linker, and for a text editor, we used Memo (which allowed multiple files to be open at the same time, etc).<br>We'd concocted a download system (which varied over time, initially used a parallel port add-on on the Spectrum, progressing to a serial download using Interface 1.<br>I don't believe any of the Z80 guys (there were a couple of other people, George "Gutt Bucket" Barns and Keith Robinson) had a hard disk drive at this point, but we did have dual disk drives, so we could run the tools from one disk and keep source files, etc on another.<br>It worked very well.George was a good systems guy (with a business programming background) and he helped us get the CP/M stuff together initially.<br>George and I got the download system(s) working.Given that I'd joined Odin after the design for Nodes had been baked, the finishing process on the game was often frustrating.<br>It'd be a case of, "What's supposed to happen here, then?" to which someone would respond, "Oh - well you're supposed to have these gravity sticks that cause all the bad guys to fall to the floor".<br>"Gravity sticks? What are they, then?".<br>And so on.The game used the  technique for drawing the sprites.<br>This uses the property of logical  in that ing a bitmap into another bitmap can be exactly undone by ing the same bitmap into the same place.<br>So, the "sprite print" code can both draw and erase the sprites.<br>One drawback is that ed sprites can look odd when they overlap (you see "holes" where set bits coincide).<br>I discuss various methods of drawing to the screen in my .It all came together pretty well in the end, we threw some speech in there at the last minute (I believe the "Nodes of Yesod, from the Odin Computer Graphics team!" voice was that of Mark Butler - ex of Imagine - who was at Odin for a short time after I joined) and that really set things off nicely.<br>We had some funky 2-voice modulated music (a bit more on that later), and importantly, the gameplay really shone. Needless to say, this game was written in 100% Z80 assembler.<br>Odin was off to a .And that's the genesis of Arc of Yesod.<br>This was really an opportunistic move to leverage the investment made into Nodes.<br>It was basically the same engine, but all of the graphics (apart from Astro Charlie himself) were replaced, the map was redone (albeit on the same 16 x 16 sized grid of rooms), the premise was tweaked slightly, and the price point was lower - it was put out on the newly revamped "Thor" label as a budget title.I was not the lead on this game but certainly put in more than just a helping hand.<br>:-)One interesting aspect of the Arc of Yesod development was that, although we used the same room editor for Arc as was used on Nodes, I am pretty certain that we had actually lost the source code for that editor in a Microdrive crash that has been mentioned in various  related to Nodes development.<br>The only thing we had was a binary executable copy of the editor.<br>This comes up again in the Robin of the Wood section below.Arc of Yesod was done fairly quickly and .This was basically as direct a port as you can imagine from the Spectrum version.<br>The  was being touted as the best thing since sliced bread, but the company behind it had all kinds of problems getting the thing to market, ranging from delays to being forced to change the name of the computer several times (it was called the "Flan" at one point ...)!I had actually seen one of these machines the previous year, as I had been tasked with evaluating it while at Software Projects.<br>Nothing came of those efforts, however.As it happens, the video hardware in the machine was quite elaborate, and all kinds of modes were possible (including a 256 color mode, as the Enterprise guys were keen to point out - I think you only got 80 pixels across the screen though).<br>One feature allowed you to set the start memory address of each scanline; another feature allowed color attributes to be specified, corresponding to 8x8 pixel areas of the screen.<br>Well, it didn't take too long to figure out that by setting the memory start addresses appropriately, and by using the attribute mode, you could essentially set up a Spectrum screen (so much for 256 colors)! There were slight differences in the format of the attributes (as I recall, they used 4/4 bits for paper and ink, with no flashing attribute bit) but other than that the screen layout was the same.<br>Once this was accomplished (and with a little help from George Barns, who figured out how to interpret the documentation relating to making a change of screen mode stick!) the rest was plain sailing.<br>The Enterprise had some nice features, like the ability to load a program from any input stream (not just tape).<br>This made it possible to fabricate a suitable header over a serial port and download directly from the BBC Micro development machines into the Enterprise.<br>The sound engine was pulled from the 128K Spectrum version of Nodes (or did it go the other way ...<br>don't recall).All told, the Enterprise version probably took me a couple of weeks.<br>It was a clean clone of the Spectrum original.<br>I think the Enterprise folks were disappointed that we didn't make more use of the hardware; that said, the ability to clone the Spectrum screen mode made that the obvious development choice.<br>I'm still not sure it was a worthwhile endeavor, I'm not sure that even one unit of the game was sold, though there are photos of the packaging out there (I'd be interested to hear otherwise from anyone that actually bought a copy).<br>I had fun doing it, nonetheless.<br>:-)I do distinctly recall Enterprise asking for their machines back once the port was finished.<br>I believe they were out of business by 1986.And so it was, after a particularly heavy lunchtime session at The Dolphin ('80s UK lunchtime pub culture) that a certain artist (who shall be nameless) was feeling a little the worse for wear.<br>Actually, he was feeling a lot the worse for wear, though he had somehow made it back to the Odin office. As his face cycled through various shades of green, he realized that he should probably get himself to the bathroom, or to a sink basin at the very least, lest he should make a mess in his (or someone else's) office.<br>As the urgency of his situation increased, he spied the brand new, newly-fitted Odin kitchen sink and he made it there just in time to christen it, so to speak.<br>Noisily.<br>And all was well.<br>No messed up office, damage contained (though some explaining to do to a shocked receptionist who'd had a narrow escape).<br>One problem: the newly fitted kitchen sink was not actually plumbed-in yet, no water, no drainage pipe.<br>And the sink dripped its dubious new charge into the cupboard below.<br>Drip.<br>Drip.Again, when I read that I hear the Robin of the Wood  (by Andy Walker) start to play in my head!This was Odin's next big effort after Nodes of Yesod.<br>I was the lead programmer on the Spectrum, Marc was lead on the C64.<br>Paul Salmon was the lead artist and main designer for the game, and design work had been underway through the completion of Nodes and all the other miscellaneous versions.<br>The initial direction was a sort of location-based 3D composite view.<br>The idea was that as you enter a location from a certain direction, you would see a 3D view of that location rendered from that perspective.<br>We experimented with this approach but found that constantly switching the viewing perspective was too jarring for the player.In the end, we switched to the more traditional 2D room-based approach (after all, it had worked for Nodes), albeit that each "room" was, for the most part, a forest location.Interestingly, Robin of the Wood was developed from scratch and did not use Nodes of Yesod code (I mean, it may have used odds and ends, but it was not built on the "Nodes codebase").<br>Partially, this was because we needed an editor to create the rooms, and no such thing existed for Nodes (as mentioned above) so we could not extend it for RotW.The sprite graphics used an  technique this time out, using a type of  system to clean up.<br>The drawback to the dirty rectangle method is that, at worst, it is little better than the cheap and cheerful "full-screen-copy" method employed elsewhere, you can end up with overdraw (when objects are close together), and frame rate can be variable (the full-screen method takes so much time for the copy procedure that the time taken to draw sprites is almost negligible in comparison).As an example of the full-screen copy method, on the spectrum version of Manic Miner, there are three physical copies of the screen.<br>The first is the clean, unpolluted (by sprites, etc) screen containing just the background, platforms, etc.<br>The second is the working screen where sprites are drawn and animated, and the third is the actual visible screen.<br>The order of operation goes like this (in 'C' for clarity here - Spectrum games rarely used anything other than Z80 assembler):In the case of Manic Miner on the Spectrum, the copy operation was simply a Z80  instruction, which was elegant, if supremely performance-inefficient (it is one of the slowest ways to copy memory, though very compact).<br>We'll get to a discussion of this notion of "efficiency" later on in a future post covering Sidewize and Crosswize.In any case, I chose the dirty rectangle system in Robin for the higher average frame rate, even though it was probably no better than a gross screen copy method in the worst case.<br>The  graphics system means you need to do one or the other.Again, Robin of the Wood was developed on the trusty BBC micros, with the M80/L80/Memo combination.<br>Debugging was done with Derrick Rowson's disassembler, changing the border color, and crossed-fingers.<br>The ability to single-step with source code was not yet available, though we may have started to use the HiSoft monitor/debugger around this time for more down and dirty debugging.The C64 version of Robin was developed in parallel.<br>Interestingly, there was very little data shared between the two games - the map data would be copied over periodically - though I think they played pretty much the same.<br>Marc and I had a little rivalry going, some friendly competition. Marc was a faster coder than me.<br>I think I would agonize more, over little details, for the sake of creating more elegant, or clever code.<br>Not that my code was any better - I just agonized more.<br>:-)The music for RotW was composed (for Spectrum - possibly the same music was ported to C64) by Andy Walker, who was also a coder.<br>He and I figured out how to get 2 bits (or perhaps it was 1.5 bits - 3 levels) of audio resolution from the Spectrum beeper, which facilitated 2 simultaneous voices.<br>Andy created the sound driver and music for the title page and game over, etc.<br>The two voice data made it easy to create the AY tunes for 128KB version later on.Paul has a distinctive art style, very different from Colin's style, and RotW, in particular, was often "emulated" (see below). These were done over a couple of evenings.<br>I think we may have been "advised", by the distributors who controlled the UK market at that time, that it would behoove us to support the new 128KB variants of the Sinclair Spectrum.<br>We were not convinced that the market penetration would be there and wanted to spend a minimal amount of effort, so we basically filled memory with various voice samples that were played at various (sometimes inopportune - gameplay paused while a sample was played) places in the games.<br>The sample playback was just about intelligible, utilizing 1.5 bits - just like the Nodes and Robin intro speech.<br>The music for the 128K versions was upgraded to  versions (source data pulled variously from the 48K and C64 versions of these games).<br>My AY sound chip experience came from my Amstrad work at Software Projects, so this was a breeze.<br>If I remember correctly, the voice behind all the sampled speech was that of Andy Walker, composer of the RotW and Arc music, among others).A trick when moving 2-voice music (from our Spectrum 48K player) to 3-voice systems (such as the Spectrum 128K and Enterprise computers) was to take the lead voice and double it, but then detune one of those voices ever so slightly.<br>This gives a pleasing phasing or flanging effect and fills out the sound.<br>Another note on this is that the 48K Nodes of Yesod music is basically handled the same way.<br>The music player we wrote is capable of playing 2 channels through the beeper, but at that time was not able to handle two individual lines of note data; the solution, take the single voice note data, double it and detune one of the playback channels.<br>This goes some way to explain the slightly dissonant sound quality in the original Nodes of Yesod music - we're basically hammering the beeper to get it to do more than just, beep.In the second installment of the Odin Computer Graphics period, I'll touch on Heartland,  Telecomsoft deal, and more - lookout for part 2 coming soon to a blog near you!</p>
