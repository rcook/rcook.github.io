---
layout: post
title: Using doctest-discover with Stack
created: 2016-01-06 09:00:00 -0800
tags:
- Haskell
- Stack
- GitHub
---
I recently got into using [doctest][1] to run tests embedded in my Haskell code
as comments. Having enjoyed using [Python doctest][2] in the past, this made me
very happy.

The little toy app I've been working on is my [GitHub client][3] which now
contains lovely tests embedded as comments, for example:

{% gist 029e1a34e81da05fa3d6 UriGetPort.hs %}

So, this is wonderful and great. I can even run my doctests using the following
little bash script:

{% gist 029e1a34e81da05fa3d6 doctest %}

As you can see, I am an aficionado of [Stack][7]. Anyway, one useful property of
this script is that it will run all doctests in all `.hs` files in my `src`
directory.

The next step for my project was then to add a `test-suite` target to my project
so that my doctests run when I run `stack test`. I followed the instructions on
the doctest [README][4] and then ran into a problem. These instructions suggest
create a new `test-suite` section with `main-is` referencing a test main looking
something like:

{% gist 029e1a34e81da05fa3d6 doctests.hs %}

Unfortunately, this requires me to do one of two things:

* Hardcode the list of source files names into `doctests.hs`
* Write globbing code in `doctests.hs` to discover all the test files

I realized that this is something that other people must've run into and, sure
enough, I discovered [`doctest-discover`][5] designed specifically to deal with
this scenario. This is when things got interesting: `doctest-discover`'s version
constraints on `base` were incompatible with any of the Stack build plans
available to me. Therefore, I forked [`doctest-discover`][6] and updated my
project's `stack.yaml` to refer to my fork via a GitHub package location:

{% gist 029e1a34e81da05fa3d6 stack.yaml %}

Thus, I am now able to reference my own hacked version of this module to
implement the standard auto-discovering entry point for my doctests:

{% gist 029e1a34e81da05fa3d6 MyDocTests.hs %}

Fun!

My changes enabling use of `doctest-discover` have since been [merged][8] into
the main `doctest-discover` repo, but this still serves as an illustration of
how to use packages from Git repositories with Stack: something which is
reminiscent of RubyGems and another thing that makes me happy!

[1]: https://hackage.haskell.org/package/doctest
[2]: https://docs.python.org/2/library/doctest.html
[3]: https://github.com/rcook/github-api-haskell/
[4]: https://github.com/sol/doctest
[5]: https://hackage.haskell.org/package/doctest-discover
[6]: https://github.com/rcook/doctest-discover
[7]: http://haskellstack.org/
[8]: https://github.com/karun012/doctest-discover/pull/5

