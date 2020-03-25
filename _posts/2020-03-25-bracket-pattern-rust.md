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

In the presence of errors, this code will leak the resource since an early return will prevent the clean-up code from running. The resource leak is obvious in this example (and obvious to the compiler&mdash;hence the `#[allow(unreachable_code)]` annotation), but this is not always the case. Use of the [`?`][try-operator] will obscure early returns in ways that are not obvious to the developer _or_ the compiler.

We can address this by introducing a wrapper (named `ResourceHolder`) in this example with an implementation for `Drop` which will release the resource even in the presence of errors:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-drop.rs %}

This is perfectly acceptable. Personally, I don't like having to introduce the `ResourceHolder` type for this. The reason why I don't like this is philosophical I suppose and, perhaps, the subject of a separate conversation. Instead, I introduce the `bracket` function (heavily inspired by [Haskell][bracket-pattern-haskell]):

{% gist 15c68ff557789265cfde5adae59e5fef main-bracket.rs %}

And here's how it's used:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-bracket.rs %}

This [GitHub project][bracket-pattern] is a full working example project demonstrating these approaches.

[bracket-pattern]: https://github.com/rcook/bracket-pattern
[bracket-pattern-haskell]: https://wiki.haskell.org/Bracket_pattern
[drop-trait]: https://doc.rust-lang.org/std/ops/trait.Drop.html
[drop-method]: https://doc.rust-lang.org/std/ops/trait.Drop.html#tymethod.drop
[raii]: https://doc.rust-lang.org/rust-by-example/scope/raii.html
[try-finally]: https://docs.microsoft.com/en-us/dotnet/csharp/language-reference/keywords/try-finally
[try-operator]: https://doc.rust-lang.org/edition-guide/rust-2018/error-handling-and-panics/the-question-mark-operator-for-easier-error-handling.html
