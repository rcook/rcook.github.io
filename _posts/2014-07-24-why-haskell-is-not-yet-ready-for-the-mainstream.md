---
layout: post
title: Why Haskell is not yet ready for the mainstream...
description: The indecipherability of Haskell error messages
created: 2014-07-24 20:36:28 -0700
tags:
- Haskell
---
{% highlight text %}
PS C:\Users\rcook> ghci
GHCi, version 7.8.2: http://www.haskell.org/ghc/  :? for help
Loading package ghc-prim ... linking ... done.
Loading package integer-gmp ... linking ... done.
Loading package base ... linking ... done.
Prelude> 1 2
<interactive>:2:1:
    Could not deduce (Num (a0 -> t))
      arising from the ambiguity check for `it'
    from the context (Num (a -> t), Num a)
      bound by the inferred type for `it': (Num (a -> t), Num a) => t
      at <interactive>:2:1-3
    The type variable `a0' is ambiguous
    When checking that `it'
      has the inferred type `forall a t. (Num (a -> t), Num a) => t'
    Probable cause: the inferred type is ambiguous
Prelude>
{% endhighlight %}

Enough said.

