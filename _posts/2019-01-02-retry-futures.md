---
layout: post
title: Retry in Java futures
created: 2019-01-02 21:44:00 -0800
tags:
- Java
- Concurrency
---
Been playing with [`CompletableFuture`][completable-future] in Java for a couple of days and thought I'd get this off my chest&hellip;

{% gist db989fd140eb5c776b8f877fcb9f817e RetryFutures.java %}

[completable-future]: https://docs.oracle.com/javase/8/docs/api/java/util/concurrent/CompletableFuture.html
