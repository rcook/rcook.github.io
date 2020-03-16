---
layout: post
title: Traits and polymorphism in Rust
created: 2020-03-13 11:08:00 -0700
tags:
- Rust
- Programming
---
Most of the articles on this blog are really a way for me to document my learning process. This post is no exception: you are under no obligation to read any of this if it is totally obvious or old hat!

Today I'm going to briefly discuss Rust's approach to polymorphism using [_traits_][rust-traits]. I will employ the medium of working code examples with embedded tests/assertions. A full working, [Cargo][hello-cargo]-based project is available [here][github-traits-and-polymorphism].

First, we'll define some common `struct`s, `Foo` and `Bar`, and a trait `Frobber`:

{% gist 4b71acef90a501678db30244b00d79d4 common.rs %}

`Frobber` is akin to an interface or type class in other languages. It defines a set of operations that another type can implement. `Frobber` is _not_ a concrete type: it defines a _family_ of types that implement a standard contract but which are _not_ related through inheritance. In this respect, traits are much more similar to [type classes][haskell-type-classes] in Haskell than, say, abstract classes or interfaces in common-or-garden "curly-brace" object-oriented languages such as Java or C#. They exhibit some of the characteristics of [templates][cpp-templates] in C++ (especially in the presence of [constraints and concepts][cpp-constraints]) but do not support C++'s [static duck typing][duck-typing-cpp] behaviour (thankfully).

The first set of examples illustrate the "statically dispatched" (compile-time) use of traits:

{% gist 4b71acef90a501678db30244b00d79d4 example0.rs %}

Under this model, functions with type arguments are effectively template functions (in the C++ sense) that are used by the Rust compiler to generate _families_ of functions. In this world, traits are the constraints on these type arguments, specifying the operations that otherwise-unknown types must implement. They, therefore, explicitly tell the compiler what operations the body of the function can perform on its arguments. In this respect [constraints liberate][constraints-liberate]. See inline comments in code for more discussion.

The second set of examples illustrate how we can use traits to perform dynamic dispatch:

{% gist 4b71acef90a501678db30244b00d79d4 example1.rs %}

Under this model, we do not use type arguments and instead make use of _references to objects implementing a given trait_ (and Rust's [`dyn`][dyn-rust] keyword)s to perform dynamic (runtime) dispatch. This will be very familiar to anybody who has used interfaces or method overriding and virtual methods when using the inheritance-based subsets of languages such as C++, Java, C# and the like. Here we're effectively passing pointers to [virtual method tables][virtual-method-table] and dispatching method calls based on the runtime type of an object.

Finally, the third set of examples illustrates the implications of this on _homogeneous_ and _heterogeneous_ collections of objects implementing traits. They also touch on the ownership semantics:

{% gist 4b71acef90a501678db30244b00d79d4 example2.rs %}

That's enough for now. I've only scratched the surface, but maybe this will be useful to someone!

[constraints-liberate]: https://www.youtube.com/watch?v=GqmsQeSzMdw
[cpp-constraints]: https://en.cppreference.com/w/cpp/language/constraints
[cpp-templates]: https://en.cppreference.com/w/cpp/language/templates
[duck-typing-cpp]: http://p-nand-q.com/programming/cplusplus/duck_typing_and_templates.html
[dyn-rust]: https://doc.rust-lang.org/edition-guide/rust-2018/trait-system/dyn-trait-for-trait-objects.html
[rust-traits]: https://doc.rust-lang.org/rust-by-example/trait.html
[github-traits-and-polymorphism]: https://github.com/rcook/traits-and-polymorphism
[haskell-type-classes]: https://www.haskell.org/tutorial/classes.html
[hello-cargo]: https://doc.rust-lang.org/book/ch01-03-hello-cargo.html
[virtual-method-table]: https://en.wikipedia.org/wiki/Virtual_method_table
