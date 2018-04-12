---
layout: post
title: Haskell miscellany
created: 2016-04-08 19:50:00 -0700
tags:
- Haskell
---
I haven't posted in a week or two, so I thought I'd write something quick and
dirty.

Well, this week my [class][pcph] started, which is very exciting. I'm the
organizer and also the guy who (so far, at least) has typed the sample code up
on the projector in front of class.

Also, random Haskell coolness: use [Stack][stack] to automatically rebuild your
Stack project and run an executable on successfully build:

```bash
$ stack build --file-watch --exec hello-world
```

Nice!

See you next time.

[pcph]: http://seattlehaskell.org/content/pcph
[stack]: http://haskellstack.org/
