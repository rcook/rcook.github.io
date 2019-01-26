---
layout: post
title: Haskell scripting
created: 2019-01-25 20:10:00 -0800
tags:
- Haskell
- Stack
---
I've just started writing my first serious scripts using [Haskell Stack][script-interpreter]. Unfortunately, I ran into a problem with sharing code between modules: the `stack script` command looks in the _current working directory_ for modules to include as opposed to the directory in which the original Stack script is located. This means that it is impossible to write a Stack script that is location-independent without embedding absolute paths.

Therefore, I came up with [this][haskell-scripting-demo] in which I have to create little Bash stub scripts and compile my shared modules on the fly. Take a look if you're a masochist.

Fortunately, [Michael Sloan][michael-sloan] at FPComplete is very responsive. He'd already recorded this [issue][issue] a while ago and now there's a [pull request][pull-request] to fix this behaviour.

[haskell-scripting-demo]: https://github.com/rcook/haskell-scripting-demo
[issue]: https://github.com/commercialhaskell/stack/issues/3377
[pull-request]: https://github.com/commercialhaskell/stack/pull/4538
[script-interpreter]: https://docs.haskellstack.org/en/stable/GUIDE/#script-interpreter
