---
layout: post
title: Unchecked casts in Java
created: 2019-03-14 08:51:00 -0800
tags:
- Java
---
How should we handle unchecked casts in Java (search for "unchecked" in the [javac][javac] documentation)? Here is a brief summary of the kinds of behaviours that this interesting type system "feature" introduces as a consequence of Java's [type-erasure][type-erasure]:

{% gist 492a773c698d7a47da090087e328f6ef Main.java %}

Here's the output:

{% gist 492a773c698d7a47da090087e328f6ef output.txt %}

The last test case, `testExplicitCastToIncorrectTypeFailsEarly` illustrates the principle of coercing the types via explicit casts at the earliest possible opportunity. This minimizes the scope of the unchecked object: i.e. we try to prevent the unchecked object from "escaping" out into the wild which can lead to `ClassCastException` being thrown in weird places later on in the code, in what we might describe as "geographically distant" places and places where there is no syntactic cast in the source code.

[javac]: https://docs.oracle.com/javase/7/docs/technotes/tools/windows/javac.html
[type-erasure]: https://docs.oracle.com/javase/tutorial/java/generics/erasure.html
