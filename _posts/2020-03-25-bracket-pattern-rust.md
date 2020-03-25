---
layout: post
title: Bracket pattern in Rust
created: 2020-25-16 08:44:00 -0800
tags:
- Rust
- Programming
---
Another Rust-related quickie today!

Much like C++, Rust encourages the [Resource Acquisition is Initialization][raii] pattern: whenever an object goes out of scope, its destructor ([`drop`][drop-method] in Rust) is called and its owned resources are freed. Possibly as a consequence of this, the Rust programming language (like C++) does not include the equivalent of a [`finally`][try-finally] construct as found in languages like Java and C#. In most situations, Rust's standard RAII is perfectly adequate. A downside I've encountered is that some resources or resource-like things do not implement the [`Drop`][drop-trait] trait. To work around this, we have to introduce additional `struct`s which do have implementations for `Drop` to manage these resources. I'll work through an example below.

Here's a simple resource:

{% gist 15c68ff557789265cfde5adae59e5fef main-resource.rs %}

Here's an example illustrating how one might (naively) attempt to manage the resource:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-resource-leak.rs %}

In the presence of errors, this code will leak the resource since an early return will prevent the clean-up code from running. The resource leak is obvious in this example (and obvious to the compiler&mdash;hence the `#[allow(unreachable_code)]` annotation), but this is not always the case. Use of the [`?`][try-operator] operator will obscure early returns in ways that are not obvious to the developer _or_ the compiler.

If we owned the `Resource` `struct`, then we could, of course, directly provide an implementation of `Drop` for it and most of the problems would go away. Imagine if you will, however, that this resource is defined by another package. In this situation Rust will prevent us from defining an implementation of somebody else's trait (i.e. `Drop` in this case) for it (this is Rust's [orphan rule][orphan-rule] which is equivalent to Haskell's [orphan instance rule][orphan-instance]). We can address this by introducing a wrapper (named `ResourceHolder` in this example) with an implementation for `Drop` which will release the resource even in the presence of errors:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-drop.rs %}

This is perfectly acceptable. Note that you have to assign the resource holder to a name (`_holder` in this case) in order for its lifetime to extend to the end of the enclosing lexical scope&mdash;note that the "throwaway" name `_` is _not sufficient_ since the compiler will generate code to release this kind of value _immediately_ and release the resource prematurely.

I'm not a big fan of introducing this kind of unused variable, largely because the intent is not clear. To the casual observer, the name might seem insignificant and someone might mistakenly change the name to `_` in the future which would drastically change the behaviour of the code (by releasing the resource prematurely). We can eliminate this problem by giving it a more meaningful (non-underscore) name and explicitly calling the [`std::mem::drop`][std-mem-drop] function:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-explicit-drop.rs %}

Now it's clear what the variable name, `holder`, is for and it is clear that `holder` must live until the call to `drop` (and no further, since `drop` consumes its argument). The `drop` version still requires this additional holder type which also bothers me.

An approach I like, which addresses all of these concerns, is to introduce the `bracket` function (heavily inspired by [Haskell][bracket-pattern-haskell]):

{% gist 15c68ff557789265cfde5adae59e5fef main-bracket.rs %}

And here's how it's used:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-bracket.rs %}

This [GitHub project][bracket-pattern] is a full working example project demonstrating these approaches.

[bracket-pattern]: https://github.com/rcook/bracket-pattern
[bracket-pattern-haskell]: https://wiki.haskell.org/Bracket_pattern
[drop-trait]: https://doc.rust-lang.org/std/ops/trait.Drop.html
[drop-method]: https://doc.rust-lang.org/std/ops/trait.Drop.html#tymethod.drop
[orphan-instance]: https://wiki.haskell.org/Orphan_instance
[orphan-rule]: https://internals.rust-lang.org/t/revisit-orphan-rules/7795
[raii]: https://doc.rust-lang.org/rust-by-example/scope/raii.html
[std-mem-drop]: https://doc.rust-lang.org/std/mem/fn.drop.html
[try-finally]: https://docs.microsoft.com/en-us/dotnet/csharp/language-reference/keywords/try-finally
[try-operator]: https://doc.rust-lang.org/edition-guide/rust-2018/error-handling-and-panics/the-question-mark-operator-for-easier-error-handling.html
