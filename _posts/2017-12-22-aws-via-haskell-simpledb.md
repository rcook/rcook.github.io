---
layout: post
title: AWS via Haskell Part 4 (SimpleDB)
created: 2017-12-22 06:50:00 -0800
tags:
- Haskell
- AWS
- SimpleDB
---
This will be another quick instalment of "AWS via Haskell". [Yesterday]({% post_url 2017-12-20-aws-via-haskell-sqs %}) we flew through AWS's Simple Queue Service. Today, we'll look at [SimpleDB][simpledb].

## Part 1: Prerequisites

Firstly, you'll need access to SimpleDB. There are several options:

* Create an [AWS][aws] account and use the real SimpleDB service in the cloud: you can start with the [free tier][aws-free-tier] and go from there
* Install [simpledb-dev2][simpledb-dev2] or similar

[localstack][localstack] does not, for reasons unknown to me, provide a SimpleDB implementation.

## Part 2: `aws-via-haskell.cabal`: the dependencies

You'll see that our `sdb-app` target depends on the following

* `amazonka-sdb`
* `base`
* `lens`
* `text`

{% gist b930582d2b389da857d84391f9d0bb19 aws-via-haskell.cabal %}

We'll also use some of the helper functions in our shared [`AWSInfo.hs`][awsinfo] module.

## Part 3: `Main.hs`: the code

This program demonstrates how to:

* Create a domain
* List domains
* Put attributes
* Get attributes

{% gist b930582d2b389da857d84391f9d0bb19 Main.hs %}

## Part 4: The full working demo project

I've gathered this all together into this buildable [project][aws-via-haskell-repo]. As always, I like to build using [Stack][stack].

## Part 5: Related posts

* [Part 1: DynamoDB]({% post_url 2017-12-13-aws-via-haskell %})
* [Part 2: S3]({% post_url 2017-12-19-aws-via-haskell-s3 %})
* [Part 3: SQS]({% post_url 2017-12-20-aws-via-haskell-sqs %})

[aws]: https://aws.amazon.com/
[aws-free-tier]: https://aws.amazon.com/free/
[aws-via-haskell-repo]: https://github.com/rcook/aws-via-haskell/
[awsinfo]: https://github.com/rcook/aws-via-haskell/blob/master/lib/AWSViaHaskell/AWSInfo.hs
[localstack]: https://github.com/localstack/localstack
[simpledb]: https://aws.amazon.com/simpledb/
[simpledb-dev2]: https://pypi.org/project/simpledb-dev2/
[stack]: https://haskellstack.org/
