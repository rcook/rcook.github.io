---
layout: post
title: AWS via Haskell Part 2 (S3)
created: 2017-12-19 07:07:00 -0800
tags:
- Haskell
- AWS
- S3
---
In this instalment of "AWS via Haskell", we'll look at how to perform basic tasks with [S3][s3]. This follows on from my [previous post]({% post_url 2017-12-13-aws-via-haskell %}) in which I talked about DynamoDB.

# Part 1: Prerequisites

Firstly, you'll need access to S3. There are several options:

* Create an [AWS][aws] account and use the real S3 service in the cloud: you can start with the [free tier][aws-free-tier] and go from there
* Install [localstack][localstack] or similar: note, however, that you [may occasionally][bug] encounter compatibility issues with these mock services

# Part 2: `aws-via-haskell.cabal`: the dependencies

You'll see that our `s3-app` target depends on the following

* `amazonka`
* `amazonka-s3`
* `base`
* `bytestring`
* `conduit-extra`
* `lens`
* `resourcet`
* `text`

{% gist 67c81760dd046d21fd496ab6ae8e404a aws-via-haskell.cabal %}

# Part 3: `AWSInfo.hs`: helper functions

The `AWSInfo` module provided here extracts some of the helper functions from [my previous post]({% post_url 2017-12-13-aws-via-haskell %} and generalizes them to all [AWS][aws] services.

{% gist 67c81760dd046d21fd496ab6ae8e404a AWSInfo.hs %}

# Part 4: `Main.hs`: the code

This program demonstrates how to:

* Create a bucket
* List buckets
* Put objects
* Get objects
* List objects

{% gist 67c81760dd046d21fd496ab6ae8e404a Main.hs %}

## Part 5: The full working demo project

I've gathered this all together into this buildable [project][aws-via-haskell-repo]. As always, I like to build using [Stack][stack].

## Part 6: Related posts

* [Part 1: DynamoDB]({% post_url 2017-12-13-aws-via-haskell %})

[aws]: https://aws.amazon.com/
[aws-free-tier]: https://aws.amazon.com/free/
[aws-via-haskell-repo]: https://github.com/rcook/aws-via-haskell/
[bug]: https://github.com/brendanhay/amazonka/issues/432
[localstack]: https://github.com/localstack/localstack
[s3]: https://aws.amazon.com/s3/
[stack]: https://haskellstack.org/
