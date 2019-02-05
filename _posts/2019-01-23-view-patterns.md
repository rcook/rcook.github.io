---
layout: post
title: View patterns
created: 2019-01-23 07:10:00 -0800
tags:
- Haskell
- GHC
- View patterns
- Pattern synonyms
- oset
---
I'm learning about the [GHC][ghc] [ViewPatterns][view-patterns-ghc] language extension at the same time as learning about [`Data.Sequence`][data-sequence]. I like the the ability to pattern-match on sequences a lot. Unfortunately, it looks like the exhaustiveness checker cannot detect when all possible patterns are covered. Here's an example:

{% gist a2927d5045b646da9a59c588b0f98b07 ViewPatternsExhaustivenessFalsePositive.hs %}

Running this script results in the following compiler warnings:

```
/path/to/ViewPatternDemo.hs:11:1: warning: [-Wincomplete-patterns]
    Pattern match(es) are non-exhaustive
    In an equation for ‘joinShow’: Patterns not matched: _
   |
11 | joinShow (viewl -> EmptyL) = ""
   | ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^...
-}
```

I'm going to see if there are known GHC bugs related to this issue.

**Update: 2019-01-25**

It turns out that the [`PatternSynonyms`][pattern-synonyms] language extension can do more or less the same thing but with nicer syntax:

{% gist a2927d5045b646da9a59c588b0f98b07 PatternSynonyms.hs %}

I think pattern synonyms are strictly less powerful than view patterns which is why (I think) GHC's exhaustiveness checker works better with them.

[data-sequence]: hackage.haskell.org/package/containers/docs/Data-Sequence.html
[ghc]: http://ghc.haskell.org/
[pattern-synonyms]: https://ghc.haskell.org/trac/ghc/wiki/PatternSynonyms/Implementation
[view-patterns-ghc]: https://ghc.haskell.org/trac/ghc/wiki/ViewPatterns
