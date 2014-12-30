---
layout: post
title: Fun with contracts and anonymous delegates
created: 2011-04-19 23:40:00 -0700
tags:
- Functional programming
- Design by contract
- C#
---
I officially blew my own mind today. I discovered `System.Diagnostics.Contracts` and inline declaration and invocation of anonymous delegates all in the same day...

[gist:8486222]

The call to `Contract.Ensures` is simply breathtaking!

