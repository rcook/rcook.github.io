---
layout: post
title: Ginger examples
created: 2019-01-06 11:18:00 -0800
tags:
- Haskell
- Ginger
---
[Ginger][ginger] is an HTML templating library for Haskell which is heavily inspired by [Jinja2][jinja2]. Jinja2 just so happens to be one of my favourite HTML templating engines for Python.

I decided to play around with Ginger because it is a _dynamic_ templating engine. Since it resolves most types at runtime it does not make use of too many inscrutable Haskell language extensions or compile-time tools such as Template Haskell. My opinion&mdash;possibly unpopular among Haskell enthusiasts (you should also ask me about my opinions on category theory at some point)&mdash;is that these more "highly typed" approaches to Haskell programming, while very clever, often yield APIs that are very tricky for newcomers to grasp and, most importantly, use. I am not against static typing at all. If I were I wouldn't program in Haskell. There are, however, times when these things become an active obstacle to getting things done.

However, while Ginger avoids many of the excesses, many of its types and functions are still fairly polymorphic. This can leads to situations where type signatures are required in order to resolve ambiguities in the type inference. In my case, this led to some frustration even when using the so-called _easy_ API. See [this bug][ginger-issue] (which I hope to submit a fix for soon) for starters.

Now that I've tamed [`easyRender`][easy-render-doc] (I think!), I thought I'd share the fruits of my labour with you here. Here's a [GitHub project][github-project] with my experimentation. I'll regurgitate specific interesting bits right here.

This snippet demonstrates how to directly render a template with a [`HashMap`][hashmap-doc] as the context:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderHashMap.hs %}

This is more or less equivalent to the example given in Ginger's _Getting Started_ guide under [_Running - The Easy Interface_][getting-started].

This is fun, but we'll need to do more sophisticated things eventually. Ginger has a _variant_ type [`GVal`][gval-doc] that it uses to represent all of the possible types Ginger templates can handle at runtime. In the `HashMap` example given above, Ginger uses `HashMap`'s [`ToGVal`][togval-doc] instance via its `toGVal` function to convert the `HashMap` into an instance of `GVal`.

The main problem with `GVal` for newcomers is, in my opinion, the mysterious `m` type parameter which, the documentation says, _should be a `Monad`_. Unfortunately, I'm a bit dense and do not have a natural intuition for that might mean exactly. Thence my experimentation and this article. The first step in untangling `GVal` and figuring out what a viable value for `m` might be, I thought, might to be try to explicitly convert my `HashMap` myself. This led to:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderGValNoTypeSignature.hs %}

Attempts to use `easyRender` on `ctx` without providing an explicit type signature for `ctx` leads to the following yummy GHC compiler error:

```text
/path/to/src/gingerapp/src/Main.hs:36:21: error:
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

I spent quite a bit of time staring at this wondering what to do next. It then dawned on me that a reasonable value for `m0` might be `Run SourcePos (Writer Text) Text` (see documentation for the various types at [`Run`][run-doc], [`SourcePos`][source-pos-doc], [`Writer`][writer-doc] and [`Text`][text-doc]). I'm not sure why GHC couldn't infer this automatically but&mdash;whatever&mdash;let's just move on:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderGVal.hs %}

And, huzzah: it compiles! Of course, a simple map of `Text` to `Text` is one thing. What if we want to store other things in our `GVal`. This question led me to look at using [`dict`][dict-doc]. This is a convenience function for generating heterogeneous `GVal` dictionaries:

{% gist 3147f518869c5bd2b1f917b9e88f8830 EasyRenderDict.hs %}

And, miraculously, it worked.

Now I think I know enough to be dangerous with Ginger!

[dict-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-GVal.html#v:dict
[easy-render-doc]:  http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-Run.html#v:easyRender
[getting-started]: https://ginger.tobiasdammers.nl/guide/getting-started/
[ginger]: https://ginger.tobiasdammers.nl/
[ginger-issue]: https://github.com/tdammers/ginger/issues/40
[github-project]: https://github.com/rcook/gingerapp
[gval-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-GVal.html#t:GVal
[hashmap-doc]: https://www.stackage.org/haddock/lts-13.1/unordered-containers-0.2.9.0/Data-HashMap-Lazy.html#t:HashMap
[jinja2]: http://jinja.pocoo.org/
[run-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-Run.html#g:4
[source-pos-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-Parse.html#t:SourcePos
[text-doc]: http://hackage.haskell.org/package/text-1.2.3.1/docs/Data-Text.html#t:Text
[togval-doc]: http://hackage.haskell.org/package/ginger-0.8.4.0/docs/Text-Ginger-GVal.html#t:ToGVal
[writer-doc]: http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#t:Writer
