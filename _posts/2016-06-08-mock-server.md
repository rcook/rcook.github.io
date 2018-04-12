---
layout: post
title: Mock web server
created: 2016-06-08 15:00:00 -0700
tags:
- Haskell
---
So, it turned out that my [Hspec][hspec] tests fail when I run them on an
aeroplane with no network connection. How to fix the tests to isolate them from
unreliable external web services?

Well, I wrote a mock server using [warp][warp]: [6f220e7][commit]. Done.

[commit]: https://github.com/seahug/seattlehaskell-org/commit/6f220e7bfdbbdc69765b1ffc17eb1f4b680bf146
[hspec]: http://hspec.github.io/
[warp]: https://hackage.haskell.org/package/warp
