---
layout: post
title: Retry in Java futures (part 2)
created: 2019-01-04 08:06:00 -0800
tags:
- Java
- Concurrency
---
This is a follow-up to [_Retry in Java futures_]({% post_url 2019-01-02-retry-futures %}). This post presented a snippet of code demonstrating how to compose futures in Java, specifically [`java.util.concurrent.CompletableFuture`][completable-future]. It demonstrated how to swallow exceptions and compose futures including branching etc.

It turns out that I need to interoperate with [Guava][guava] futures too, specifically [`com.google.common.util.concurrent.ListenableFuture`][listenable-future]. In some ways this post can be considered to be a short translation guide for switching back and forth between `CompletableFuture` and `ListenableFuture`.

On first encountering `ListenableFuture` I was dismayed that, unlike `CompletableFuture`, this interface does not expose any methods for composing futures. `CompletableFuture`, for example, provides the following and many more:

* `exceptionally`
* `thenCompose`
* `thenApply`

On deeper inspection, however, we find that Guava eschews interface methods for static helper methods on the [`com.google.common.util.concurrent.Futures`][futures] class. Roughly corresponding to the methods mentioned above we find:

* `catchingAsync` corresponding to `exceptionally`
* `transformAsync` corresponding to `thenCompose`
* `transform` corresponding to `thenApply`

My "add-with-retry" example using `CompletableFuture` looks like:

{% gist 7284d36be3deb22bc3cf8ebdf8e8d4fe JavaFutures.java %}

These are my observations about this:

* It has a reasonable "fluent" API which should be familiar to anybody who uses Java streams, for example
* Swallowing exceptions seems like a hack:
    * See `.exceptionally(e -> null)`
    * This leads to a loss of information: it is impossible to distinguish between a `null` returned from the `App.add` future and a swallowed exception
    * This can be worked around by introducing an intermediate "union" type (see below)
* In order to respond with another future to exceptions, we have to do the `exceptionally`-followed-by-`thenCompose` hack

Regarding the "union" type comment above, I can think of at least one more principled approach we might take to handling exceptions that does not lose information. We could, for example, introduce a tagged union type as follows:

{% gist 7284d36be3deb22bc3cf8ebdf8e8d4fe JavaFuturesWithIntermediateUnionType.java %}

With the introduction of the tagged union, `ValueOrException` (roughly equivalent to Haskell's [`Either`][either]), we can now distinguish accurately between the exceptional case and the `null` response case.

Here's my rough translation of this example into Guava futures:

{% gist 7284d36be3deb22bc3cf8ebdf8e8d4fe GuavaFutures.java %}

And here's the accompanying `ListenableFutureHelper` helper class:

{% gist 7284d36be3deb22bc3cf8ebdf8e8d4fe ListenableFutureHelper.java %}

Here are my thoughts:

* The API leads to a series of difficult-to-read nested method calls
* This is quite jarring for anybody used to newer Java "chaining" APIs
* It is an artifact of the fact that the methods are static helper methods on `Futures` as opposed to first-class members of the `ListenableFuture` interface
* C# gets around this problem by having [extension methods][extension-methods] which effectively open up classes/interface for extension
* On the plus side, `ListenableFuture`'s `catchingAsync` is far superior to `exceptionally` followed by `thenCompose` and does not lose information and does not require the invention of a tagged union to distinguish between `null` and exceptions

In order to address the syntactic issues with `ListenableFuture`, Guava now has [`com.google.common.util.concurrent.FluentFuture`][fluent-future] in recent versions of the library. I haven't had a chance to play with this yet. If I do, I'll get back to you!

Here's a buildable [GitHub project][github-project].

[completable-future]: https://docs.oracle.com/javase/8/docs/api/java/util/concurrent/CompletableFuture.html
[either]: https://www.stackage.org/haddock/lts-13.1/base-4.12.0.0/Prelude.html#t:Either
[extension-methods]: https://docs.microsoft.com/en-us/dotnet/csharp/programming-guide/classes-and-structs/extension-methods
[fluent-future]: https://google.github.io/guava/releases/23.0/api/docs/com/google/common/util/concurrent/FluentFuture.html
[futures]: https://google.github.io/guava/releases/21.0/api/docs/com/google/common/util/concurrent/Futures.html
[guava]: https://google.github.io/guava/releases/21.0/api/docs/
[listenable-future]: https://google.github.io/guava/releases/21.0/api/docs/com/google/common/util/concurrent/ListenableFuture.html
[github-project]: https://github.com/rcook/RetryFuturesJava
