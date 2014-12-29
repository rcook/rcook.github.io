---
layout: post
title: Why Haskell is not yet ready for the mainstream...
created: 2014-07-24 20:36:28 -0700
categories:
- !binary |-
  aGFza2VsbA==
---
<pre><code>
<p>PS C:\Users\rcook&gt; ghci
GHCi, version 7.8.2: http://www.haskell.org/ghc/  :? for help
Loading package ghc-prim ... linking ... done.
Loading package integer-gmp ... linking ... done.
Loading package base ... linking ... done.
Prelude&gt; 1 2</p>
<p>&lt;interactive&gt;:2:1:
&nbsp;&nbsp;&nbsp;&nbsp;Could not deduce (Num (a0 -&gt; t))
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;arising from the ambiguity check for `it'
&nbsp;&nbsp;&nbsp;&nbsp;from the context (Num (a -&gt; t), Num a)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;bound by the inferred type for `it': (Num (a -&gt; t), Num a) =&gt; t
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;at &lt;interactive&gt;:2:1-3
&nbsp;&nbsp;&nbsp;&nbsp;The type variable `a0' is ambiguous
&nbsp;&nbsp;&nbsp;&nbsp;When checking that `it'
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;has the inferred type `forall a t. (Num (a -&gt; t), Num a) =&gt; t'
&nbsp;&nbsp;&nbsp;&nbsp;Probable cause: the inferred type is ambiguous
Prelude&gt;</p>
</code></pre>

Enough said.

