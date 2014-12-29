---
layout: post
title: Visitor pattern (re)visited
description: Example of visitor pattern in Java
created: 2010-08-02 14:01:13 -0700
tags:
- Development
- Design patterns
- Java
---
I am aware that the visitor design pattern has been around in some form for
years and so what I'm about to write in this post is not particularly innovative
or special in any way. I just thought I'd discuss something I've been pondering
for a while in my attempts to come up with interesting refactorings for the
[DuctileJ](http://code.google.com/p/ductilej/) project.

Anyway, I read [this](https://www.re-motion.org/blogs/mix/archive/2010/04/10/virtual-methods-outside-of-classes-the-visitor-pattern.aspx)
article describing the pattern in C# and thought I'd translate the samples into
Java.

## Before implementing the visitor pattern

{% gist e2536672f7afdf6a4660 Before.java %}

## An intermediate version

{% gist e2536672f7afdf6a4660 Intermediate.java %}

## With the visitor design pattern

{% gist e2536672f7afdf6a4660 After.java %}

I'll write more on the subject later.

