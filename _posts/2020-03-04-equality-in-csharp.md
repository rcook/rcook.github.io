---
layout: post
title: Equality in C#
created: 2020-03-05 15:15:00 -0800
tags:
- C#
- Programming
---
In this article I'm going to discuss the notion of _equality_ in the C# programming language. In particular, I'm going to show you how it's very difficult to correctly implement comparisons of objects in the presence of inheritance. This will lead up to the conclusion that it's usually best to stick to implementing equality comparisons only for value types (i.e. `struct`s) or classes with value-like semantics (i.e. `sealed` classes, usually with immutable fields). These conclusions cover all comparisons which are implemented by extending a `struct` or `class` such as:

* [`System.Object.Equals(System.Object)`][system-object-equals]
* [`System.IComparable.CompareTo(System.Object)`][system-icomparable-compareto]
* [`System.IComparable<T>.CompareTo(T)`][system-icomparablet-compareto]
* [`System.IEquatable<T>.Equals(T)`][system-iequatablet-equals]

Comparisons are often best left to the various mechanisms offered elsewhere in the .NET Framework such as:

* `IComparer`
* `IEqualityComparer`
* `IStructuralComparable`
* `IStructuralEquatable`

A quick note before you proceed: make sure you understand why the following program behaves the way it does:

{% gist c64ee0d59400c1ac643f0e19c77933b0 QuickQuiz.cs %}

Now on to the discussion proper. Caveat: My code probably has subtle bugs in it. This is kind of the point.

Here's our base class, imaginatively named `BaseClass`:

{% gist c64ee0d59400c1ac643f0e19c77933b0 BaseClass.cs %}

We've decided, for whatever reason, that `BaseClass` is to be _value-like_:

* We implement `System.IEquatable<BaseClass>.Equals(BaseClass)`
* We override `System.Object.Equals(System.Object)`
* We override `System.Object.GetHashCode()`
* We implement a helper `SlicingEquals(System.Object)`

Other features of note:

* We use _delegation_ to ensure that the two `Equals` method compare consistently: `Equals(BaseClass)` delegates to `Equals(object)`
* `Equals(object)` requires the type of the receiver (`this`) and the argument (`obj`) to be _exactly_ the same since, in general, if `obj.GetType()` is a different (even if derived) from `this.GetType()` the objects should not be considered equivalent
* `SlicingEquals` which performs the field-wise comparison of the objects and only requires `obj.GetType()` to be assignable to `this.GetType()`: this is provided as a helper for derived classes so that field comparisons do not need to be repeated

Most discussions of `IEquatable<T>` state that this interface is provided for more strongly-typed comparisons as well as to allow a more efficient implementation. While it can achieve the former, it cannot always achieve the latter. If the type `T` is a `struct`, then we certainly can provide a more efficient implementation than the implemented for `(object)` that is generated for us by the C# compiler (which performs the comparison by reflecting over the type `T` to enumerate all of its fields&mdash;I need to verify this claim at some point). However, providing a custom behaviour for `Equals(T)` _without_ providing a consistent implementation for `Equals(object)` will break comparisons. Weird behaviour will ensue if objects are ever compared via virtual `Equals(object)` calls instead of static `Equals(T)` calls: you wouldn't want to live in a world where `123.Equals(123)` yielded a different result from `((object)123).Equals((object)123)`. In practice, therefore, you'll want to delegate your `Equals(T)` call to your `Equals(object)` implementation so that they are guaranteed to be equivalent.

In the case of a class like this which attempts to handle inheritance, no performance enhancement is gained by implementing `IEquatable<T>` since all comparison methods must dynamically dispatch via virtual method calls.

Here's a derived class named `DerivedClass`:

{% gist c64ee0d59400c1ac643f0e19c77933b0 DerivedClass.cs %}

We've decided, for whatever reason, that `DerivedClass` is also to be _value-like_:

* We implement `System.IEquatable<DerivedClass>.Equals(DerivedClass)`
* We override `System.IEquatable<BaseClass>.Equals(BaseClass)`
* We override `System.Object.Equals(System.Object)`
* We override `System.Object.GetHashCode()`
* We override `SlicingEquals(System.Object)`

Of note:

* `SlicingEquals` compares the additional fields defined in `DerivedClass` and delegates to the base `SlicingEquals` method defined in `BaseClass`

Pretty ugly, huh?

To drive the point home, let's define another class, `MoreDerivedClass`, that derives from `DerivedClass`:

{% gist c64ee0d59400c1ac643f0e19c77933b0 MoreDerivedClass.cs %}

We've decided that `MoreDerivedClass` like its ascendants is also to be _value-like_:

* We implement `System.IEquatable<MoreDerivedClass>.Equals(MoreDerivedClass)`
* We override `System.IEquatable<DerivedClass>.Equals(DerivedClass)`
* We override `System.IEquatable<BaseClass>.Equals(BaseClass)`
* We override `System.Object.Equals(System.Object)`
* We override `System.Object.GetHashCode()`
* We override `SlicingEquals(System.Object)`

Well, this all sucks. Here are some tests:

{% gist c64ee0d59400c1ac643f0e19c77933b0 Program.cs %}

Note that these tests are by no means exhaustive: it covers only a subset of the various `Equals` overrides and does not test `GetHashCode` at all.

This is a lot of work and any given implementation is likely to contain subtle bugs. Some of this complexity and bugginess could be eliminated through the use of code generation since each of these overload methods is more-or-less mechanically generatable. This is roughly what [`@EqualsAndHashCode`][lombok-equals-and-hash-code] in [Lombok][lombok] does. Writing this code by hand is generally tedious and pointless. Life is simpler if we stick to only comparing value or properly _value-like_ types. Doing this kind of work requires that the developer spend some time thinking about _why_ he or she is contemplating it. Often it will be to take advantage of language or framework features such as hash tables and sets etc. There will often require a _value-like_ object as key and developers will be tempted to slap an `Equals` or `IComparable` on a class to make this work. This is usually the Wrong Thing to do. A more principled approach to designing systems like this will be to try to determine what the _key_ in such a system is and then probably implement around that: these keys will typically be stable, immutable values or value-like objects.

I'll probably talk more on this subject in the future. Bye for now!

**Update 2020-03-12**

Here's an interesting, related project from my co-worker [Jay Bazuzi][jay-bazuzi]: [`ValueTypeAssertions`][value-type-assertions].

[jay-bazuzi]: https://github.com/JayBazuzi
[lombok]: https://projectlombok.org/
[lombok-equals-and-hash-code]: https://projectlombok.org/features/EqualsAndHashCode
[system-object-equals]: https://docs.microsoft.com/en-us/dotnet/api/system.object.equals
[system-icomparable-compareto]: https://docs.microsoft.com/en-us/dotnet/api/system.icomparable.compareto
[system-icomparablet-compareto]: https://docs.microsoft.com/en-us/dotnet/api/system.icomparable-1.compareto
[system-iequatablet-equals]: https://docs.microsoft.com/en-us/dotnet/api/system.iequatable-1.equals
[value-type-assertions]: https://github.com/JayBazuzi/ValueTypeAssertions
