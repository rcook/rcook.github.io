---
layout: post
title: Xiaolin Wu's fast antialiased line drawing algorithm in Haskell
created: 2018-12-23 11:07:00 -0800
tags:
- Haskell
- Graphics
- Algorithms
- Rosetta Code
- Geometry
---
While working on [juicy-draw]({% post_url 2018-12-19-juicy-draw %}), I thought it would be nice to look at drawing nicely antialiased lines. I thought I'd have a go at implementing [Xiaolin Wu's algorithm][wikipedia] and post it up at [Rosetta Code][rosetta-code] while I was at it:

{% gist 07932dba512be7e151d474cff53ff630 XiaolinWu.hs %}

You can also check out the [GitHub project][github].

I have a couple of remaining issues that I may or may not get to at some point in the future:

* Should it use `Double` instead of `Int` for coordinates?
* Attempting to draw a line covering the full extent of the image will crash the program due to out-of-range indices: the current code fudges the issue by deliberately drawing the line with two pixels of padding from the edges

[github]: https://github.com/rcook/xiaolin-wu-algorithm
[rosetta-code]: https://rosettacode.org/wiki/Xiaolin_Wu%27s_line_algorithm#Haskell
[wikipedia]: https://en.wikipedia.org/wiki/Xiaolin_Wu%27s_line_algorithm
