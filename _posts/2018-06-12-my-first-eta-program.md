---
layout: post
title: My first Eta program
created: 2018-06-12 09:40:00 -0700
tags:
- Haskell
- Eta
- Java
- JVM
---
I've been reading up on [Eta][eta] and thought I'd give it a try. Since I've started using IntelliJ to do more things, this seemed to make sense. The first thing to note is that Eta's Haskell language implementation is essentially GHC's, though I don't remember which version it's based on. Thus, the Haskell part of Eta is probably not interesting. I figured that the [Java/JVM interop][eta-java-interop] was the interesting bit. I followed the tutorial and wondered how easy or difficult it would be to pop open a window on the screen. This is the Java program I started with:

{% gist 47e67e065a85b4542601565c1f6bbbe2 Main.java %}

I was pleasantly surprised to find that I could translate this into Eta very easily and it took me less than ten minutes to do so:

{% gist 47e67e065a85b4542601565c1f6bbbe2 Main.hs %}

That's it for today!

[eta]: https://eta-lang.org/
[eta-java-interop]: https://eta-lang.org/docs/user-guides/eta-user-guide/java-interop/java-interop-basics
