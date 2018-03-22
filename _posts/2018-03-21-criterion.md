---
layout: post
title: Criterion for benchmarking Haskell programs
created: 2018-03-21 20:01:00 -0700
tags:
- Haskell
- Criterion
---
It's been bothering me for a while now that I don't know the most efficient way to append/concatenate strings in Haskell. I thought that this might be an interesting motivation for learning how to use [Criterion][criterion].

## The standard way

Here's the first version of the function I want to test:

{% gist c1aa48cd6de18f6442c9096d8786e1df JoinWordsAppend.hs %}

This is pretty standard stuff: I want to build a string in left-to-right order. It uses the append operator, `++`.

## Using `concat`

Here's another variant using `concat`:

{% gist c1aa48cd6de18f6442c9096d8786e1df JoinWordsConcat.hs %}

## Using `ShowS`

And another using `showString` from `ShowS`:

{% gist c1aa48cd6de18f6442c9096d8786e1df JoinWordsShowS.hs %}

## Using `Seq`

And, finally, using sequence which supports `O(1)` append to either end of the sequence:

{% gist c1aa48cd6de18f6442c9096d8786e1df JoinWordsSeq.hs %}

## The program

Here's the whole program:

{% gist c1aa48cd6de18f6442c9096d8786e1df Main.hs %}

This depends on the following non-`base` packages:

* `containers`
* `criterion`
* `random-strings`

Here's a [full, working project][project] if you like.

I run it using [`stack`][haskell-stack] as follows:

```
stack clean
stack build
stack exec -- concat-vs-append --output bench.html
```

## The results

You can view the output from the program [here][criterion-chart].

## The conclusion

Use `++`, `concat` or `ShowS`, it really makes no difference. Don't use `Seq`. I will need to analyse further to make sure that this is a meaningful test. See you later!

[criterion]: http://www.serpentine.com/criterion/tutorial.html
[criterion-chart]: /pages/2018-03-21-criterion.html
[haskell-stack]: https://haskellstack.org/
[project]: https://github.com/rcook/concat-vs-append