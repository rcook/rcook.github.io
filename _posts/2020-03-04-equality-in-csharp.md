---
layout: post
title: Equality in C#
created: 2020-03-05 15:15:00 -0800
tags:
- C#
- Programming
---
I haven't written about programming for a while. It's time to make up for that. Today I'm going to briefly discuss the notion of _equality_ in the C# programming language. Particularly I'm going to show you how it's very difficulty to design for equality in the presence of inheritance or subtype polymorphism and, why, it usually make sense to not bother at all and to restrict oneself to only implementing equality for value types (i.e. `struct`s) or class's with value-like semantics (i.e. `sealed` classes, usually with immutable fields).

Here's our base class, imaginatively named `BaseClass`:

{% gist c64ee0d59400c1ac643f0e19c77933b0 BaseClass.cs %}

Here's a derived class named `DerivedClass`:

{% gist c64ee0d59400c1ac643f0e19c77933b0 DerivedClass.cs %}

And another class, `MoreDerivedClass`, that derives from `DerivedClass`:

{% gist c64ee0d59400c1ac643f0e19c77933b0 MoreDerivedClass.cs %}

And here are some tests:

{% gist c64ee0d59400c1ac643f0e19c77933b0 Program.cs %}
