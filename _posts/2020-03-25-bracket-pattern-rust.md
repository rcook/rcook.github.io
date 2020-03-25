---
layout: post
title: Bracket pattern in Rust
created: 2020-25-16 08:44:00 -0800
tags:
- Rust
- Programming
---
Another Rust-related quickie today!

Much like C++, Rust encourages the [Resource Acquisition is Initialization][raii] pattern: whenever an object goes out of scope, its destructor is called and its owned resources are freed. This is probably the design choice which explains why the Rust programming language does not include the equivalent of a [`finally`][try-finally] construct. In most situations, Rust's standard RAII is perfectly adequate. The only downsides I've found is that some resources that we have to introduce resource management `struct`s with implementations for the [`Drop`][drop] trait to manage them. I'll work through an example in this post.

Here's a simple resource:

{% gist 15c68ff557789265cfde5adae59e5fef main-resource.rs %}

Here's an example illustrating how one might (naively) attempt to manage the resource:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-resource-leak.rs %}

In the presence of errors, this code will leak the resource.

We can address this by introducing a wrapper (named `ResourceHolder`) in this example with an implementation for `Drop` which will release the resource even in the presence of errors:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-drop.rs %}

This is perfectly acceptable. Personally, I don't like having to introduce the `ResourceHolder` type for this. The reason why I don't like this is philosophical I suppose and, perhaps, the subject of a separate conversation. Instead, I introduce the `bracket` function (heavily inspired by [Haskell][bracket-pattern-haskell]):

{% gist 15c68ff557789265cfde5adae59e5fef main-bracket.rs %}

And here's how it's used:

{% gist 15c68ff557789265cfde5adae59e5fef main-demo-bracket.rs %}

This [GitHub project][bracket-pattern] is a full working example project demonstrating these approaches.

[bracket-pattern]: https://github.com/rcook/bracket-pattern
[bracket-pattern-haskell]: https://wiki.haskell.org/Bracket_pattern
[drop]: https://doc.rust-lang.org/std/ops/trait.Drop.html
[raii]: https://doc.rust-lang.org/rust-by-example/scope/raii.html
[try-finally]: https://docs.microsoft.com/en-us/dotnet/csharp/language-reference/keywords/try-finally
