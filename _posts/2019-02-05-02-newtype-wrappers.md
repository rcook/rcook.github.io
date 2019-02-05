---
layout: post
title: Alternative `newtype` wrappers
created: 2019-02-05 15:30:00 -0800
tags:
- Haskell
- Hackage
---
I recently published [`oset-0.1.1.0`][oset-0.1.1.0] in order to get around some (perceived, by me) shortcomings of [`ordered-containers`][ordered-containers]. Mainly I was frustrated by the lack of [`Semigroup`][semigroup] and [`Monoid`][monoid] instances.

In retrospect, I think I should have thought some more before ploughing ahead and implementing them the way I did, mainly because there are ( think) at least two valid, and obvious, possible instances of these type classes for an ordered set. Specifically:

* Left-preserving, or left-biased, append: in which duplicate elements on the _right-hand_ side of the append are discarded
* Right-preserving, or right-biased, append: in which duplicates elements on the _left-hand_ side of the append are discarded

Therefore, I'm [planning][issue] to remove the existing `Semigroup` and `Monoid` instances and replace them with `newtype` wrappers providing the desired behaviours. Here's a sketch of what I intend to do:

{% gist b341e0a5c31d2def4d338a8b9eb96cf9 OSetDemo.hs %}

`leftPreservingAppend` and `rightPreservingAppend` are not the real implementations but are provided for illustrative purposes only.

[issue]: https://github.com/rcook/oset/issues/2
[monoid]: https://www.stackage.org/haddock/lts-13.6/base-4.12.0.0/Prelude.html#t:Monoid
[ordered-containers]: https://hackage.haskell.org/package/ordered-containers
[oset-0.1.1.0]: http://hackage.haskell.org/package/oset-0.1.1.0
[semigroup]: https://www.stackage.org/haddock/lts-13.6/base-4.12.0.0/Prelude.html#t:Semigroup
