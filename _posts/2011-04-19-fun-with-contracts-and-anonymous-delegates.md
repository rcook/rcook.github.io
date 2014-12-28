---
layout: post
title: Fun with contracts and anonymous delegates
created: 1303281600
categories:
- !binary |-
  ZnVuY3Rpb25hbCBwcm9ncmFtbWluZw==
- !binary |-
  ZGVzaWduIGJ5IGNvbnRyYWN0
- !binary |-
  YyM=
---
I officially blew my own mind today. I discovered `System.Diagnostics.Contracts` and inline declaration and invocation of anonymous delegates all in the same day...

[gist:8486222]

The call to `Contract.Ensures` is simply breathtaking!
