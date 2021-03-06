---
layout: post
title: Instrumenting IL generation in Mono's C# compiler
created: 2010-10-03 08:10:31 -0700
tags:
- Mono
- C#
---
Someone asked me the other day how I'd go about instrumenting the IL generated
by the Mono C# compiler: something to do with custom profiling I think. I still
haven't come up with a totally satisfactory answer but here's a patch of some
work I did showing how I hacked away at various bits of the sources to emit
custom method prologues and epilogues. Download the patch and apply it to your
Mono Git repo.

{% gist 1bbacb700b49fd733d0c %}

Here is a [Stack Overflow
question](http://stackoverflow.com/questions/3848001/extending-the-mono-c-compiler-is-there-any-documentation-or-precedent)
I asked about the preferred method of extending the C# compiler. This relates to
my plan to do very spiffy things to `mcs`'s ASTs and type checker!

