---
layout: post
title: My first proper Idris program
created: 2018-12-07 09:12:00 -0800
tags:
- Haskell
- Idris
---
I'm learning [Idris][idris-lang]. Unfortunately, my heart sank when I read the words ["The length of the list should be statically known"][fromList]. Then I read [this][ycombinator]. I want to use dependent types to do real things. Specifically, I want to use a [fixed-length vector type][vect] to perform arithmetic on data obtained from the outside world.

I have previously tried to approach this problem in Haskell land using some of its dependent type features and was always disappointed that I could not get a reasonable answer to the problem of reading in data of unknown size and performing operations on it using fixed-length data types. Fortunately, I did not give up and [Edwin Brady's book][idris-book] had the clues all along. The secrets lie in chapter 5 _Interactive programs: input and output processing_, in _dependent pairs_ and in the use of the [`exactLength`][exactLength] function.

Here is my first stab at this problem in all its glory:

{% gist 8f44a4957d7adcc397a1dbe9b50730bc Main.idr %}

The next part of my journey will be to grok how `exactLength` works. I think it's something to do with [this][stackoverflow].

## Update

In case you were wondering about the use of the `the` function in `the (IO (Either FileError (List Int, List Int)))`: this is used to fix the type of the return from `withFile`. Without this, Idris cannot infer the type of the expression. This seems like a [compiler bug][bug] to me.

## Update (2)

Instead of `the (IO (Either FileError (List Int, List)))`, the code now provides a value for the implicit `a` argument to `withFile` using `{a = (List Int, List Int)}`.

[bug]: https://github.com/idris-lang/Idris-dev/issues/4605
[exactLength]: https://www.idris-lang.org/docs/current/base_doc/docs/Data.Vect.html#Data.Vect.exactLength
[fromList]: https://www.idris-lang.org/docs/current/base_doc/docs/Data.Vect.html#Data.Vect.fromList
[idris-book]: https://www.manning.com/books/type-driven-development-with-idris
[idris-lang]: https://www.idris-lang.org/
[stackoverflow]: https://stackoverflow.com/questions/46853917/idris-proving-equality-of-two-numbers
[vect]: https://www.idris-lang.org/docs/current/base_doc/docs/Data.Vect.html
[ycombinator]: https://news.ycombinator.com/item?id=10856501
