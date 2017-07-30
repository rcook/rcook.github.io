---
layout: post
title: Backpack with Stack
created: 2017-07-30 14:43:00 -0700
tags:
- Haskell
- SeaHUG
- Backpack
- Stack
---
At yesterday's meeting of the [Seattle Area Haskell Users' Group][seahug], I talked briefly about my very recent experimentation with Haskell's new module system, namely [Backpack][backpack]. I'll briefly discuss what I've done so far right here.

The main thrust of my experimentation was to work through Edward Yang's ["Try Backpack"][try-backpack] tutorial. For reasons that I gave up trying to figure out, I could not compile Edward's examples, so I [wrote my own][backpack-app] from scratch. Here are the contents of the project and a brief description of each file:

## `foo.bkp`: the Backpack file itself

{% gist 96efba09f8ada983e0f0bfef9fdcdbf9 foo.bkp %}

This describes four _units_:

* `foo-indef`: defines the _signature_ `Str` and a module `Foo` that implements a function `theLength` in terms of `Str`
* `foo-int`: defines a concrete implementation of the `Str` signature in terms of `Int`
* `foo-string`: defines a concrete implementation of the `Str` signature in terms of `String`
* `main`: defines the `Main` module that consumes `theLength` using both `foo-int` and `foo-string`

## `Makefile`: the build definition

{% gist 96efba09f8ada983e0f0bfef9fdcdbf9 Makefile %}

Since Stack does not yet support Backpack, I opted to use Stack just to manage the GHC compiler installation, and to describe the build of the project using a good old-fashioned Makefile.

To build the project:

```
make
```

## `stack.yaml`: the Stack configuration file

{% gist 96efba09f8ada983e0f0bfef9fdcdbf9 stack.yaml %}

This specifies which resolver and compiler version to use.

To install the correct version of GHC:

```
stack setup
```

The project also contains basic documentation about how to build on Windows, Linux and macOS.

## Comments

I have a few questions about Backpack which I've not found any answers to yet:

* How do I move my Haskell code out of the `.bkp` file and into separate `.hs` files?
* How am I _really_ supposed to build this kind of project?

Happy Backpacking!

[backpack]: https://ghc.haskell.org/trac/ghc/wiki/Backpack
[backpack-app]: https://github.com/rcook/backpack-app
[seahug]: http://seattlehaskell.org/
[try-backpack]: http://blog.ezyang.com/2016/10/try-backpack-ghc-backpack/
