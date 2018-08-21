---
layout: post
title: GHCi custom key bindings
created: 2018-08-21 10:15:00 -0800
tags:
- GHCi
- Haskeline
- Haskell
---
## Keyboard shortcuts in GHCi

I want to bind keyboard shortcuts to [GHCi][ghci] commands. GHCi makes use of the [Haskeline][haskeline] package for performing line input. Thus, it is Haskeline's configuration file, `$HOME/.haskeline`, where we'll need to place our shortcuts.

As an example, I'm going to show you how to bind `F7` to the GHCi `:reload` command.

## The basics

Here's the [documentation][haskeline-custom-key-bindings] for custom key bindings in Haskeline. We'll need to add something of the following form to `$HOME/.haskeline`:

```text
bind: <key> <keys>
```

`F7`, for `<key>` is simply `f7`. The string `:reload` needs to be decomposed into a space-separated sequence of `<key>` values, i.e. `: r e l o a d`. Thus, the first line in `$HOME/.haskeline` becomes:

```text
bind: f7 : r e l o a d
```

Let's fire up GHCi and see what happens when you press `F7`:

```bash
stack ghci
```

If you're on Windows, you're probably done at this point: this _should just work_. On Linux or macOs, `F7` will probably do nothing at this point. To work on Posix platforms, you'll need to add `keyseq` entry:

```text
keyseq: <term> <string> <key>
```

So, we'll need to add `keyseq` for `F7`. How do I get the appropriate key code? Fortunately, [GHC][ghc] can do this for you:

```bash
stack exec ghc -- -e getLine
```

At this point, press `F7` followed by `Enter` and you'll get output like the following:

```text
^[[18~
"\ESC[18~"
```

The second line is the key sequence that you'll use with Haskeline. Grab this string, create a new `keyseq` entry to map it to `F7` and you'll end up with a configuration file looking something like the following:

```text
bind: f7 : r e l o a d
keyseq: "\ESC[18~" f7
```

And you're done! Fire up GHCi, and `F7` should generate `:reload` for you.

My current favourite configuration looks like:

```text
bind: f7 : r e l o a d return : m a i n return
keyseq: "\ESC[18~" f7
```

This will cause `F7` to reload the current module and run `main` all in one keypress. Nice!

[ghc]: https://wiki.haskell.org/GHC
[ghci]: https://downloads.haskell.org/~ghc/latest/docs/html/users_guide/ghci.html
[haskeline]: https://github.com/judah/haskeline
[haskeline-custom-key-bindings]: https://github.com/judah/haskeline/wiki/CustomKeyBindings