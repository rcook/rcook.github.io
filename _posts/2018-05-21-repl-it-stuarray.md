---
layout: post
title: repl.it and STUArray
created: 2018-05-21 11:02:00 -0700
tags:
- Haskell
- repl.it
---
I just noticed that I almost managed to go through the whole of May 2018 without posting a single article
to my blog. Fortunately, there's still time.

As readers of this blog might know, I typically use [Github Gists][gist] to share code samples. I've been playing around with the free online IDE [repl.it][repl-it] and thought I'd give that a try. So, I will present my code samples a different way today.

[Bartosz][bartosz] gave a [presentation][seahug] on the [ST monad][st-monad] on Saturday, so here I present an [example][repl-it-example] using [`STUArray`][stuarray].

<iframe height="400px" width="100%" src="https://repl.it/@rcook1/STUArray?lite=true" scrolling="no" frameborder="no" allowtransparency="true" allowfullscreen="true" sandbox="allow-forms allow-pointer-lock allow-popups allow-same-origin allow-scripts allow-modals"></iframe>

That's it! See you next time.

[bartosz]: https://bartoszmilewski.com/
[gist]: https://gist.github.com/
[repl-it]: https://repl.it/
[repl-it-example]: https://repl.it/@rcook1/STUArray
[seahug]: http://seattlehaskell.org/minutes/2018/05/19/minutes
[st-monad]: http://hackage.haskell.org/package/base-4.11.1.0/docs/Control-Monad-ST.html
[stuarray]: http://hackage.haskell.org/package/array-0.5.2.0/docs/Data-Array-ST.html
