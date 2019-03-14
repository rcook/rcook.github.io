---
layout: post
title: Unchecked casts in Java
created: 2019-03-14 08:51:00 -0800
tags:
- Java
---
How should we handle unchecked casts in Java? Here is a brief summary of the kinds of behaviours that this interesting type system "feature" introduces:

{% gist 492a773c698d7a47da090087e328f6ef Main.java %}

Here's the output:

{% gist 492a773c698d7a47da090087e328f6ef output.txt %}

The last test case, `testExplicitCastToIncorrectTypeFailsEarly` illustrates the principle of coercing the types via explicit casts at the earliest possible opportunity. This minimizes the scope of the unchecked object: i.e. we try to prevent the unchecked object from "escaping" out into the wild which can lead to `ClassCastException` being thrown in weird places later on the code "geographically distant" from where the object is first obtained.
