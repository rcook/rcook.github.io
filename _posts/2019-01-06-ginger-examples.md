---
layout: post
title: Ginger examples
created: 2019-01-06 11:18:00 -0800
tags:
- Haskell
- Ginger
---
[Ginger][ginger] is an HTML templating library for Haskell which is heavily inspired by [Jinja2][jinja2] which just so happens to be one of my favourite HTML templating engines for Python.

I decided to play around with Ginger because it is a _dynamic_ templating engine which does not make use of too many Haskell language extensions or compile-time tools such as Template Haskell. My opinion&mdash;possibly unpopular among Haskell enthusiasts (you should also ask me about my opinions on category theory at some point)&mdash;is that these very much more highly-typed approaches to Haskell programming, while very clever, yield APIs that are very tricky for the newcomers to grasp and, most importantly, use.

However, while Ginger avoiding most of these excesses, is still fairly polymorphic which leads to situations where type signatures are required to resolve ambiguities in the type inference. In my case, this led to some frustration even when using the so-called _easy_ API. See [this bug][ginger-issue] (which I hope to submit a fix for soon) for starters.

Now that I've figured out how to tame [`easyRender`][easy-render-doc], I thought I'd share the fruits of my labour with you here. Here's a [GitHub][github-project] with my experimentation. I'll regurgitate specific interesting code snippets right here.

This is direct rendering of a Ginger template using a [`HashMap`][hashmap-doc] as the context:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderHashMap.hs %}

This is more or less the example given in Ginger's _Getting Started_ guide under [_Running - The Easy Interface_][getting-started].

This is fun, but we'll need to do more sophisticated things eventually. Ginger has a _variant_ type [`GVal`][gval-doc] it uses to represent all of the possible types Ginger templates can handle at runtime. In the `HashMap` example given above, Ginger uses `HashMap`'s [`ToGVal`][togval-doc] to convert the `HashMap` into an instance of `GVal`.

The main problem with `GVal`, in my humble opinion, is the mysterious `m` type parameter which, the documentation says, _should be a `Monad`_. Unfortunately, I'm a bit dense and cannot figure out what this means exactly. Thence the cause of my experimentation. The first step in untangling `GVal` and figuring out what a viable value for `m` might be, I thought I'd tried converting the `HashMap` myself leading to:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderGValNoTypeSignature.hs %}

Attempts to use `easyRender` on `ctx` without providing an explicit type signature for `ctx` leads to the following yummy GHC compiler error:

```text
/home/rcook/src/gingerapp/src/Main.hs:36:21: error:
    • Ambiguous type variable ‘m0’ arising from a use of ‘easyRender’
      prevents the constraint ‘(ToGVal
                                  (Run SourcePos (Writer Text) Text) (GVal m0))’ from being solved.
      Probable fix: use a type annotation to specify what ‘m0’ should be.
      These potential instance exist:
        instance ToGVal m (GVal m) -- Defined in ‘Text.Ginger.GVal’
    • In the second argument of ‘($)’, namely ‘easyRender ctx template’
      In a stmt of a 'do' block: Text.putStrLn $ easyRender ctx template
      In the expression:
        do let ctx = toGVal $ HashMap.fromList ...
           Text.putStrLn $ easyRender ctx template
   |
36 |     Text.putStrLn $ easyRender ctx template
   |                     ^^^^^^^^^^^^^^^^^^^^^^^
```

I spent quite a bit of time staring at this wondering what to do next, when it dawned on me that `m0` might be `Run SourcePos (Writer Text) Text`. I'm not sure why GHC couldn't infer this but, whatever, let's just move on:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderGVal.hs %}

And, huzzah, it compiles! This leads to the following use of [`dict`][dict-doc] which is a convenience function for generating heterogeneous `GVal` dictionaries:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderDict.hs %}

Now I know enough to be dangerous with Ginger!

[dict-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-GVal.html#v:dict
[easy-render-doc]:  http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-Run.html#v:easyRender
[getting-started]: https://ginger.tobiasdammers.nl/guide/getting-started/
[ginger]: https://ginger.tobiasdammers.nl/
[ginger-issue]: https://github.com/tdammers/ginger/issues/40
[github-project]: https://github.com/rcook/gingerapp
[gval-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-GVal.html#t:GVal
[hashmap-doc]: https://www.stackage.org/haddock/lts-13.1/unordered-containers-0.2.9.0/Data-HashMap-Lazy.html#t:HashMap
[jinja2]: http://jinja.pocoo.org/
[togval-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-GVal.html#t:ToGVal
