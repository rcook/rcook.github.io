---
layout: post
title: Our simple arithmetic expression language in Rust
created: 2019-03-09 12:02:00 -0800
tags:
- Rust
---
In my first post of the month, this is a short follow-up to [previous post]({% post_url 2019-02-19-02-scala-adt %}) in which I presented a simple arithmetic expression language embedded in Scala as well as Haskell, Java and OCaml. Today I present a version implemented in my new second-favourite programming language ([favourite][haskell]) [Rust][rust-lang]:

{% gist dd4db779353cde36646c3a78736ebb2d expr.rs %}

Some thoughts:

* I love Rust's [pattern matching][rust-patterns]
* I love Rust's automatic deriving of [`Debug`][rust-debug]
* I love Rust's [lifetime and borrowing][rust-borrowing] mechanisms

It would be nice if the `Box` builder functions could be automatically generated. Otherwise, Rust has impressed me very much so far.

[haskell]: https://www.haskell.org/
[rust-borrowing]: https://doc.rust-lang.org/beta/rust-by-example/scope/borrow.html
[rust-debug]: https://doc.rust-lang.org/std/fmt/trait.Debug.html
[rust-lang]: https://www.rust-lang.org/
[rust-patterns]: https://doc.rust-lang.org/1.15.1/book/patterns.html
