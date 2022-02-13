<p>In this article, I'll explain how, and why I acquired an  and some
IPv6 addresses.In late 2020, I read
.
In this post, the author said if they were to build something new, they would
focus on "IPv6 only, mostly".<br>This post got me to thinking about having some
IPv6 connectivity again.Before I got to Montreal, I used to have access to IPv6 Internet.<br>I can't
remember for sure, but I think it was through a  tunnel.My Internet Service Provider (ISP) is a small ISP.<br>They don't own the .<br>They provide native IPv6 for
some other subscription of theirs, where they can.<br>However, on the service I'm
subscribed to, the last mile owner is still 
().No native IPv6 means I'll need to setup some tunnels, one way or another.The first thing I looked at was Hurrincane Electric, since it was the only
provider I knew at the time.<br>Unfortunately, they only offer
 tunnels,
which means no encryption.<br>One could argue that in 2020+, with HTTPS and
/,
there is little unencrypted traffic, but to that I'll reply "meh".I thought I could rent a virtual machine (preferably, since tunnels require
little resources and VMs are way cheaper than dedicated servers) and run my own
tunnel with the IPv6 it provides.As mentioned in , I
have multiple networks (VLAN) at home.<br>Because I didn't want to do some
 things, I needed to have a /64 per network, meaning multiple /64s for
my home.I went on the hunt for a provider that offers something like a /56 (or the
option to get multiple /64s).<br>Unfortunately, I didn't find anything reasonable.
I eventually found some high end servers that came with a /48 but since they
cost nearly as much as my rent, I'll pass.<br>Most providers give at best a /64,
but it can also be a /128 (lol) or nothing (yeah who cares about IPv6).I asked a network engineer friend if he knew any hosting services providing
more than a /64 with a cheap machine and -well- he gave a network-engineer type
of answer "just get your IPv6 addresses and announce them".After inquiring more detail, he kindly answered and I decided to proceed with
this.While I don't qualify as a network engineer, I'm not completely ignorant
network-wise.<br>I used to work for a  (so
I'm no stranger to BGP) and I used to be a volunteer for  
 back in France.: Keep in mind what follows is my own interpretation.<br>Go read the
relevant parties' websites and agreements to make your own opinion.Following my friend's advice, I set out to get some IPv6 addresses and an ASN
to announce them.<br>I could then create my own (encrypted of course) tunnels to
get IPv6 at home.I would also be able to achieve what I had wanted for years: play with
.IP addresses and an ASN can be obtained through a
.Because of my personal situation (which I won't get into), there are two RIRs I
could ask: ARIN and the RIPE.<br>is
the RIR for Corporatist America.<br>If you're not a corporation, well you're not
going to go very far.I considered creating my own, but the cost exceeded what I was ready to spend
on the project.<br>As affordable as it would have been for a corporation, it would
not be for me.<br>is the RIR for Socialist Europe.
You're an individual and you want some resources? That's totally fine, go ask
for some.<br>Well, not directly.<br>RIPE doesn't talk to peasants, you'll have to ask
a
.
If they can provide it directly, they do.<br> Otherwise, they act as a proxy
between you and the RIPE.I went for this option.<br>From my time volunteering, I know quite a lot of people
in quite a lot of LIRs.I chose  for no particular reason.My initial plan was to get a /48 to get IPv6 at home and a /48 to play with
anycast (because it is the smallest network you can announce on the Internet).
I couldn't do anything else with the /48 I would anycast, by design.So after completing my membership, I requested a /48 IPv6 from the RIPE
(through my LIR, as explained).<br>A few days after the request and with some
follow-up questions, I got .<br>Now that I had some address
space, I could justify the need for an ASN.<br>I made the request and got
.So I requested a /48 to my LIR from its own resources.
 kindly carved  out of the LIR reserved address
space for this purpose.(For the readers not versed in the RIPE-world technicalities, ).Shortly after I setup IPv6 at home, I noticed Google believed I was in France.
, I had
no hope for myself.<br>I thought that maybe using a netblock from ARIN would solve
my issue.At first, I went to ask , but
it didn't work because we hit a technical limitation from a common provider.Then, I found the .<br>They
provide a /48 (or more if you can justify the need) out of a netblock called
feda (because it comes from ).Unfortunately, this didn't solve my geolocation problem with Google.<br>I even had
a new problem, my FEDA block was geolocated in China, but I easily fixed it in
maxmind db, and it seems to have been enough.However, as the quote says , I had now a /48 I
could use to test stuff for anycast.Now that I had 3 netblocks that I was going to cut into smaller networks, I
would need a .<br>Nowadays, most
people use .<br>I thought I
was going to use it, but I read a
 of
 the
author of sidekiq and it made me realize I didn't need such a complex tool.For shits and giggles, I initially thought "wouldn't it be nice to use tree(1)
to see everything??".<br>I created directories for blocks, and files for
addresses.<br>Here's what it looked like:Note: This predates the move to the feda netblock.However in the end, editing files was not easy because I had to escape all the
 in my shell.<br>I had a lot of fun creating this arborescence, but it was time
to move on to something more practical.I went for a single text file in a json-inspired format.<br>Here's what it looks
like:Note that here RTBH is  how I named the network, it's not related to
actual RTBH.I manage the file with vim and I can easily (un)fold any level whether I want
an overview or a detailed view.<br>Also this may not be entirely up to date haha.My initial plan was to get some VMs around the world and announce the /48 on
each.<br> Easier said than done, because my requirements are to find a provider
which:I thought "anycast is easy, you just announce your IP everywhere, and done".
Well, yes, but actually no.<br>At least if you don't want to abide by .<br>Proper routing requires a
lot of work.I currently have 4 VMs in this anycast network:This is a work in progress that probably deserves its own blog post when it's
fully done, so I won't go further into details.As you just read, I have two VMs in Toronto.<br>I wish I could have a provider in
Montreal to reduce latency, unfortunately I've not been able to find one quite
yet.I had to choose some tunnelling technology.<br>I picked up WireGuard® because it
had recently made it into OpenBSD kernels (see
) and my experience with ipsec is as "good"
as the next person.My current setup is:R1 and R2 are my VMs in Toronto, and R3 is my router at home.<br>Yes, my router at
home uses BGP, both to announce its own netblock over BGP and to choose the
best route between R1+Upstream 1 and R2+Upstream 2.<br>Isn't that super cool??! :DR1 and R2 both announce my /48 to their provider.<br>They do so with my public
ASN.They have a wg link between each other.<br>The goal is twofold:Case 1 isn't actually a problem.<br>Once the session with the upstream fails, it
won't get the 
anymore, which means R3 won't get the full view from that router, and it will
 traffic only to the other.<br>Traffic  will switch automatically
provided the upstream stops announcing my route (it should, but )I prepend that path with my ASN 15 times (picked by "should be good enough
lol") to avoid using it in normal condition.This simple link was actually quite a big change because until then, R1 and R2
used to do some stateful firewalling (in addition to the one done on R3).
However, this change meant traffic could flow asymmetrically, so I had to
switch to stateless firewall (which I restricted to the specific network, the
rest of the traffic is still checked by 
with stateful rules).R3 announces the /56 I have at home over BGP to R1 and R2.<br>"But this is inter
AS, why didn't you use an IGP???".<br>Well wg(4) doesn't support multicast, and
 (and even
) needs it.<br>You can do without
buuuut...<br>I tried and struggled with ospf6d, so sticking with
 was way easier.Fun fact: I even began to write my own igpd, but I quickly realized I was just
reimplementing bgpd poorly so I aborted.I actually use a private ASN to announce the /56.<br>I picked 4200211935, so it's
obviously both "it's my ASN", and "it's not ":Of course since I announce a /56 and a private ASN, I needed to stop checking
RPKI for this particular host.<br>Fortunately, bgpd's rules system is really easy
to work with.Of course everything runs OpenBSD! It has a lovely
 in base.<br>OpenBSD ships
 which one can use to validate ROA
("improve the routing security" in layman's terms).OpenBSD developers changed OpenBGPD config since last I used it.<br>The thing I
worry the most about is messing what I announce to my peers.<br>They must have
filters, but I don't want to be .<br>OpenBGPD's config file is set in a
way that it's hard to mess up, thanks to sane defaults and a nice logic.It ships with an excellent example config file making easy to start using it!
For that reason, I'm not going to detail mine.OpenBGPD uses little memory:Most VMs have only 1G of ram and 1 cpu.I didn't want to run  on each
and every router.<br>I couldn't either because it uses a truckload of inodes and
my /var/ partitions couldn't afford it.I considered using ,
however it meant running more software (e.g.
/).Also bgpd doesn't support (yet?) encrypted RTR so it would have meant either
doing RTR unecrypted (yuck), or run even more software.What I ended up doing is running rpki-client on my web server (on which I added
a special partion with way more inodes).And on my bgpd routers15 minutes ought to be enough, it used to run in 5 minutes, but apparently it
now runs in around 8 minutes, I guess I should setup some monitoring haha.Of course, I found some improvements for the software I use through this
project.<br>Here are some fixes that made it into the OpenBSD trees because of my
playing around:Of course this weird hobby of mine costs money.<br>I'm however very happy of how
low I could keep my expenses.Here's what I paid Grifon:Out of 4 VMs I run BGP on, I've been using one for other things, so I'm not
counting it since I would pay for it regardless of this project.Here's what I pay for the host:Even if I messed around with BGP before, I hadn't really gone deeper than the
surface.<br>Since I had a lot to learn network engineering-wise, I read a lot of
stuff.<br>Among everything, I highly recommend the 
from The Google Docs  was
incredibly helpful.Probably no.While the resources I'm using are plentiful (32-bit ASNs, 128-bit IP
addresses), people's routers

are not.My 'experiment' is 3 netblocks out of the ~130k in the
.Note that I'm definitely not the first person to get an ASN for personal use.
Once you begin looking into ASN, there are plenty.If you really want to play with BGP, you can look into
!I've been doing this project for a bit over a year now.There were some boring tasks (the perpetual quest to find hosters who don't
suck, administrative things to get the resources, etc), but overall, this
project has been incredibly fun!Yeah sex is good, but have you tried running mtr(8), while shutting a BGP
session, or 
and watch the traffic change?This website is best viewed on a screen identical to my own.<br></p>
