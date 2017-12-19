---
layout: post
title: AWS via Haskell
created: 2017-12-13 09:50:00 -0800
tags:
- Haskell
- AWS
- DynamoDB
---
Since I am now an [Amazonian][amazon], I thought it would be a good time to start learning how to use our technologies. So, here it is: the first instalment in my new, occasional series, which I am tentatively calling "AWS via Haskell". In these posts we'll do [AWS][aws] stuff using our programming language of choice, i.e. [Haskell][haskell]. I will build these examples on top of the awesome and comprehensive [amazonka][amazonka] family of packages by Brendan Hay.

# Part 1: DynamoDB

Today, I'll talk about how to do some basic tasks with [DynamoDB][dynamodb].

## Prerequisites

You'll need access to a DynamoDB instance. The two most common ways of doing this are as follows:

* Create an [AWS][aws] account and use your DynamoDB instance in the cloud: you can start with the [free tier][aws-free-tier] and go from there
* Download and install DynamoDB [locally][dynamodb-local]

## `dynamodb-demo.cabal`: the dependencies

This examples use the following standard Haskell packages which do not require additional explanation:

* `bytestring`
* `lens`
* `resourcet`
* `text`
* `unordered-containers`

In addition, we depend on the following amazonka packages:

* `amazonka`: connection and credential handling etc.
* `amazonka-dynamodb`: DynamoDB-specific APIs

{% gist 553ae2f596bbad3852f5f6d2edd3a257 dynamodb-demo.cabal %}

## `Main.hs`: the code

This simple program demonstrates the core tasks you'll most likely find yourself doing with DynamoDB:

* Creating tables
* Deleting tables
* Putting items
* Getting items
* Updating items

{% gist 553ae2f596bbad3852f5f6d2edd3a257 Main.hs %}

The things of most note are as follows:

* amazonka APIs make heavy use of lenses
* The DynamoDB APIs make heavy use of `HashMap`s
* Expensive operations such as creation and deletion of tables are asynchronous and amazonka provides access to the native AWS "waiter" APIs to simplify polling for these kinds of operation to complete

## A full, working demo project

I've gathered this all together into this buildable [project][aws-via-haskell-repo]. As always, I like to build using [Stack][stack].

[amazon]: http://www.amazon.com/
[amazonka]: https://github.com/brendanhay/amazonka/
[aws]: https://aws.amazon.com/
[aws-free-tier]: https://aws.amazon.com/free/
[aws-via-haskell-repo]: https://github.com/rcook/aws-via-haskell/
[dynamodb]: https://aws.amazon.com/dynamodb/
[dynamodb-local]: http://docs.aws.amazon.com/amazondynamodb/latest/developerguide/DynamoDBLocal.html
[haskell]: https://www.haskell.org/
[stack]: https://haskellstack.org/