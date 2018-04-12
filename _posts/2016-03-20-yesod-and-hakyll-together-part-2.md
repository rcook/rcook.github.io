---
layout: post
title: Yesod and Hakyll together (part 2)
created: 2016-03-20 09:26:00 -0700
tags:
- Haskell
- Yesod
- Hakyll
- Keter
- Apache
- Ruby on Rails
---
*[Go to part 1 of this series][part1]*

There's no code today. Just lots and lots of words. Code will follow soon!

Both [Yesod][yesod] and [Hakyll][hakyll] are well-documented and have
reasonable tutorials: both [Michael Snoyman's book][yesod-book] and Jasper Van
der Jeugt's site are great resources.

## Template system mismatches

What is not documented is how to combine the two. Part 1 of this series
describes my Apache configuration for serving content from the two parts of the
web site. After figuring that out, the most difficult challenge was making the
two parts of the sites look and feel as if they were part of a single coherent
site. The single biggest complexity is that both frameworks employ different
templating systems by default. Yesod employs [Shakespearean
templates][shakespearean-templates], specifically Hamlet, Lucius and Cassius.
Hakyll has its own straightforward, but effective, system. I enumerate some of
the interesting characteristics below:

* Shakespearean templates
  * Strongly-typed templates that are parsed at compile time
  * Dynamic "runtime" variants of the templates [are
supported][hamlet-runtime], but are decidedly "second-class" compared to the
strongly-typed variants as one might expect given that Yesod's strong
emphasis on type safety
  * Hamlet (the HTML templates) use a [Haml][haml]-based syntax
* Hakyll templates
  * HTML-based
  * Fully dynamic much more like the [kinds of templates][rails-layout] that
non-Haskell developers are typically used to

## Philosophical thoughts

Both systems have their pros and cons. However, on a personal note, I have a
soft spot for Hamlet's syntax. However, I don't object to using real HTML.
Ultimately, the question came down to the following: do I adapt my Yesod app to
consume Hakyll templates or do I adapt my Hakyll site generator to handle the
templates from my Yesod app. Given my unwillingness to compromise the type
safety of my Yesod app, I decided to do the latter.

## Possible approaches

There were three main approaches I considered:

* Add an "empty" page to my Yesod app whose sole purpose is to serve up its
default layout template rendered as HTML containing Hakyll-style placeholders:
in this model, I'd run a local Yesod development instance while running my
Hakyll generator: the Hakyll generator would pull its default layout template
from the Yesod app using the Haskell equivalent of `wget` and then use that to
render the static site
* Add Hamlet support directly to my Hakyll site generator

I toyed with the first approach briefly and then decided that this was not
personally very satisfying. Both Yesod and Hakyll are highly modular and
configurable frameworks, so I decided to power through things and simply use
the [`shakespeare`][shakespeare-package] in my Hakyll app.

As I'll describe in future instalments of this series, this was not entirely
straightforward, but did ultimately result in a reasonably elegant solution to
the problem.

[hakyll]: https://jaspervdj.be/hakyll/
[haml]: http://haml.info/
[hamlet-runtime]: https://hackage.haskell.org/package/shakespeare-2.0.7/docs/Text-Hamlet-Runtime.html
[part1]: {% post_url 2016-03-16-yesod-and-hakyll-together-part-1 %}
[rails-layout]: http://guides.rubyonrails.org/layouts_and_rendering.html
[shakespearean-templates]: http://www.yesodweb.com/book/shakespearean-templates
[shakespeare-package]: https://hackage.haskell.org/package/shakespeare
[yesod]: http://www.yesodweb.com/
[yesod-book]: http://www.yesodweb.com/book
