---
layout: post
title: AWS via Haskell Part 3 (SQS)
created: 2017-12-20 07:02:00 -0800
tags:
- Haskell
- AWS
- SQS
---
Today, in "AWS via Haskell", we'll quickly look at accessing AWS [SQS][sqs] (Simple Queue Service) after looking at [S3]({% post_url 2017-12-19-aws-via-haskell-s3 %}) yesterday.

## Part 1: Prerequisites

Firstly, you'll need access to SQS. There are several options:

* Create an [AWS][aws] account and use the real S3 service in the cloud: you can start with the [free tier][aws-free-tier] and go from there
* Install [localstack][localstack]

## Part 2: `aws-via-haskell.cabal`: the dependencies

You'll see that our `s3-app` target depends on the following

* `amazonka-sqs`
* `base`

{% gist 50505fbf45dc006f31215c0e88da8ce8 aws-via-haskell.cabal %}

We'll also use some of the helper functions in our shared [`AWSInfo.hs`][awsinfo] module.

## Part 3: `Main.hs`: the code

This program demonstrates how to:

* Create a queue
* List queues
* Get queue URLs
* Send messages
* Receive messages

{% gist 50505fbf45dc006f31215c0e88da8ce8 Main.hs %}

## Part 4: The full working demo project

I've gathered this all together into this buildable [project][aws-via-haskell-repo]. As always, I like to build using [Stack][stack].

## Part 5: Related posts

* [Part 1: DynamoDB]({% post_url 2017-12-13-aws-via-haskell %})
* [Part 2: S3]({% post_url 2017-12-19-aws-via-haskell-s3 %})
* [Part 4: SimpleDB]({% post_url 2017-12-22-aws-via-haskell-simpledb %})
* [Part 5: Lambda]({% post_url 2017-12-29-aws-via-haskell-lambda %})
* [Part 6: EC2]({% post_url 2018-01-12-aws-via-haskell-ec2 %})
* [Part 7: SSM]({% post_url 2018-03-02-aws-via-haskell-ssm %})

[aws]: https://aws.amazon.com/
[aws-free-tier]: https://aws.amazon.com/free/
[aws-via-haskell-repo]: https://github.com/rcook/aws-via-haskell/
[awsinfo]: https://github.com/rcook/aws-via-haskell/blob/master/lib/AWSViaHaskell/AWSInfo.hs
[localstack]: https://github.com/localstack/localstack
[sqs]: https://aws.amazon.com/sqs/
[stack]: https://haskellstack.org/
