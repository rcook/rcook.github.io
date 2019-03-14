---
layout: post
title: Unchecked casts in Java
created: 2019-03-14 08:51:00 -0800
tags:
- Java
---
How should we handle unchecked casts in Java? I think it's subjective. For now, I'll present a brief summary of the kinds of behaviours that this interesting type system "feature" introduces:

{% gist 492a773c698d7a47da090087e328f6ef Main.java %}

Here's the output:

{% gist 492a773c698d7a47da090087e328f6ef output.txt %}

Thoughts, questions?
