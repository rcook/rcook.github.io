---
layout: post
title: AWS via Haskell
created: 2017-12-13 09:50:00 -0800
tags:
- Haskell
- AWS
- DynamoDB
---
Since I am now an [Amazonian][amazon], I figure it's a good time to start learning how to use our technologies. So, here it is: the first instalment in my occasional series which I am tentatively calling "AWS via Haskell". Today, I'll talk about how to do some basic tasks with [DynamoDB][dynamodb] using our programming language of choice, i.e. [Haskell][haskell]. I will build these examples on top of the awesome and comprehensive [amazonka][amazonka] family of packages by Brendan Hay.

This is a fairly straightforward set of examples today. I'll add commentary as I find time.

## `dynamodb-demo.cabal`: the dependencies

This example uses the following packages:

* `amazonka`
* `amazonka-dynamodb`
* `bytestring`
* `conduit`
* `lens`
* `text`
* `unordered-containers`

{% gist 553ae2f596bbad3852f5f6d2edd3a257 dynamodb-demo.cabal %}

## `Main.hs`: the code

{% gist 553ae2f596bbad3852f5f6d2edd3a257 Main.hs %}

I've gathered this altogether into this buildable [project][dynamodb-demo].

[amazon]: http://www.amazon.com/
[amazonka]: https://github.com/brendanhay/amazonka/
[dynamodb]: https://aws.amazon.com/dynamodb/
[dynamodb-demo]: https://github.com/rcook/aws-via-haskell/tree/master/dynamodb-demo
[haskell]: https://www.haskell.org/
