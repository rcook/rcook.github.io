---
layout: post
title: Juicy Draw
created: 2018-12-19 09:26:00 -0800
tags:
- Haskell
- Graphics
- Geometry
---
Building on my [previous post]({% post_url 2018-12-17-rasterize-triangle %}), I translate my triangle fill method and other basic 2D primitives into Haskell. I present to you [juicy-draw][juicy-draw-hackage] (also on [GitHub][juicy-draw-github]).

Here's an example program:

{% gist 0009a3e02cb3ef5429546ea6a00d7e76 JuicyDrawMain.hs %}

This project is inspired by [JuicyPixels-canvas][juicypixels-canvas] and similarly builds on top of [JuicyPixels][juicypixels] (hence the name). It provides an improper superset of the functions in JuicyPixels-canvas but with one big different: they operate directly on [`MutableImage`][mutable-image] instead of employing an intermediate [`Canvas`][canvas] type.

[canvas]: http://hackage.haskell.org/package/JuicyPixels-canvas-0.1.0.0/docs/Codec-Picture-Canvas.html#t:Canvas
[juicy-draw-github]: https://github.com/rcook/juicy-draw
[juicy-draw-hackage]: http://hackage.haskell.org/package/juicy-draw
[juicypixels]: http://hackage.haskell.org/package/JuicyPixels
[juicypixels-canvas]: http://hackage.haskell.org/package/JuicyPixels-canvas
[mutable-image]: https://www.stackage.org/haddock/lts-12.24/JuicyPixels-3.2.9.5/Codec-Picture-Types.html#t:MutableImage
