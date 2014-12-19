---
layout: post
title: Installing Yesod on Windows
created: 1400985517
categories:
- !binary |-
  eWVzb2Q=
- !binary |-
  aGFza2VsbA==
---
Here we go:

* [Download GHC 7.8.2](http://www.haskell.org/ghc/dist/7.8.2/ghc-7.8.2-x86_64-unknown-mingw32.tar.bz2)
* Unzip into directory and add `bin` and `mingw/bin` subdirectories to path
* [Download cabal-install 1.20.0.1](http://www.haskell.org/cabal/release/cabal-install-1.20.0.1/cabal-i386-unknown-mingw32.tar.gz)
* Unzip and copy `cabal.exe` into `bin` directory specified above
* [Download sources for `unix-compat` 0.4.1.1](https://hackage.haskell.org/package/unix-compat-0.4.1.1/unix-compat-0.4.1.1.tar.gz)
* Unzip into any directory
* [Patch `cbits/HsUname.c` and `cbits/mktemp.c` and `unix-compat.cabal`](https://github.com/gzh/unix-compat/commit/f586b22eda51f86bd2d5ba4f01fb556b8cbf40fd#commitcomment-6439418)
* [Build this package from source and install (per-user)](http://www.haskell.org/haskellwiki/Cabal/How_to_install_a_Cabal_package):
  * `runhaskell Setup configure --user --prefix=$env:APPDATA\cabal-custom`
  * `runhaskell Setup build`
  * `runhaskell Setup install`

Oh, and it still doesn't work. I'm thwarted by the following:

`ghc.exe: Unknown PEi386 section name ``.text.unlikely' (while processing: C:\Users\rcook\AppData\Roaming\cabal\x86_64-windows-ghc-7.8.2\yaml-0.8.8.2\HS
yaml-0.8.8.2.o)`

Turns out that GHC 7.8.2 is busted (see [here](https://ghc.haskell.org/trac/ghc/ticket/9080), [here](https://ghc.haskell.org/trac/ghc/ticket/9116) and [here](https://ghc.haskell.org/trac/ghc/ticket/9141)). I'll let you know if I figure anything out.
