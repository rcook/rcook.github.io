---
layout: post
title: Elkulator
created: 2015-06-01 22:00:00 -0800
tags:
- Acorn Electron
- Elkulator
---
My fork of [Elkulator][1] is coming along nicely. Here's what I've done:

* Migrated build over to CMake (still in a private branch)
* Fixed most, if not all, of the compiler warnings
* Fully documented the build process both under Windows and Linux
* My sideways RAM/ROM hacks are still around (in a private branch)

I'm trying to get an automated CI process working with [Travis-CI][2], but it
doesn't seem to like [Allegro][3].

[1]: https://github.com/rcook/elkulator
[2]: https://travis-ci.org/
[3]: https://www.allegro.cc/

