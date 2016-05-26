---
layout: post
title: Installing Agda on Mac OS X
created: 2016-05-26 09:27:00 -0800
tags:
- Agda
- Stack
---

You'll need the [Xcode developer tools][xcode] as a basic prerequisite.

* Install [Stack][stack]
* Install Agda tools

```bash
$ stack install --resolver nightly-2016-05-08 Agda
```

* Grab the Agda standard library

```bash
$ cd ~
$ git clone https://github.com/agda/agda-stdlib.git
```

* Create a "Hello world" program `hello.agda`

```agda
module hello where
  open import IO
  main = run (putStrLn "Hello, World!")
```

* Create a Makefile

```gnumake
default:
  stack exec -- agda -i ~/agda-stdlib/src -i . -c hello.agda
```

Running `agda` via `stack` will ensure that GHC can find your Haskell packages.

* Build the code

```bash
$ make
```

* Run the program

```bash
$ ./hello
Hello, World!
```

Profit!

[stack]: http://haskellstack.org/
[xcode]: https://developer.apple.com/xcode/downloads/
