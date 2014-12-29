---
layout: post
title: Simulating packet loss with iptables/ipfw
created: 1290449583
categories:
- !binary |-
  bWFjIG9zIHg=
- !binary |-
  bGludXg=
---
I need to simulate packet loss for a little programming assignment I'm working on which involves implementing a multicast chat application using UDP sockets. I need to build reliability into the system (sequence numbers and acknowledgements etc.) and thought it might be sensible to test the behaviour of my program under WAN-style network conditions. Originally I was just going to randomly drop packets in my server, but then I thought to myself that there ought to be an OS-level way of doing it. Indeed, there is and here is my bash script that demonstrates it. This has been tested under Ubuntu 10.10 (using iptables) and Mac OS X 10.6 (using ipfw) but should work with minor modifications under any Unix/Linux distro that has an iptables/ipfw-based firewall.

Usage: run the attached bash script as root passing the packet loss rate on the command line. The script will save and restore your firewall settings before and after use.

For example, for 50% packet loss:
<code>
sudo ./simulate-packet-loss 0.5
</code>

This script is presented as-is. No guarantees implicit or explicit etc. If you have customized firewall settings I would heartily advise you to save them to a backup file beforehand in case my script trashes your settings permanently.

