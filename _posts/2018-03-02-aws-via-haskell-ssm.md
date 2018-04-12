---
layout: post
title: AWS via Haskell Part 7 (SSM)
created: 2018-03-02 07:11:00 -0800
tags:
- Haskell
- AWS
- SSM
- Simple Systems Manager
- Parameter store
---
As we continue our exploration of programming AWS from Haskell, we'll hit on an important subject that is often neglected: that of configuration. Today we'll talk about AWS's [SSM][ssm] service. SSM, or Simple Systems Manager, is a big service and we'll only talk about the _parameter store_ part of it, but I hope this article will encourage you to explore more of this important service.

Why do I mention configuration? Well, most likely any application you're likely to write will require some configuration, either to customize behaviour for individual users of your application, or as a way to persist user-specific data. I'm currently working on a side project to programmatically access my [Fitbit][fitbit] data. The Fitbit web API uses OAuth2 authentication and to effectively use this protocol, your application needs to know various pieces of information that will vary from user to user and from session to session, such as:

* Authorization URL (fixed for a given API)
* Token URL (fixed for a given API)
* Client ID (fixed for a given client)
* Client secret (fixed for a given client)
* Access token (varies over lifetime of application session)
* Refresh token (varies over lifetime of application session)

I've describe the usual lifetime of these values in parentheses. Not only do these values vary as described here, they should also be treated differently in security terms. For example, the _client secret_ as well as the access and refresh tokens should never be shared with another application. The one common theme to all of these values, however, is that they should not be stored as part of the application's source code. Applications will typically use one or more of the following mechanisms for managing these values:

* Environment variables
* Files (configuration files, "dotfiles" etc.)
* Registry (Windows)
* Property lists (macOS)

When moving our code to AWS, not all of these options are left available to us. Consider moving a program to run under AWS [Lambda][lambda], for example. Lambda only supports one of these options: environment variables. This mechanism might suffice for some of the values we need to pass into our application but not all. The main issues with environment variables are:

* Security: values are stored in cleartext
* They cannot be changed between sessions

So, to address these two important shortcomings, an application developer might decide to fall back on other strategies for handling things like access tokens, such as storing these values in a database. This might work out, but is a little heavyweight for managing a small number of values like this. This is where AWS Systems Manager's _parameter store_ comes in. This is a mechanism for storing strings, lists of strings or encrypted strings for use by AWS services. The values are protected by all the standard AWS IAM mechanisms and, furthermore, can be mutated by services as desired.

Today, I'll show you a quick-and-dirty Haskell programs that demonstrates how to write and read parameters using the [amazonka-ssm][amazonka-ssm] package.

## Part 1: Prerequisites

Firstly, you'll need access to SSM. There are two main options:

* Create an [AWS][aws] account and use the real S3 service in the cloud: you can start with the [free tier][aws-free-tier] and go from there
* Install [localstack][localstack]

## Part 2: The dependencies

We have a pretty standard set of dependencies:

* `amazonka-ssm`
* `aws-via-haskell`
* `base`
* `directory`
* `filepath`
* `text`

These are defined as part of the `ssm-app` target:

{% gist d0b144694361c41f4d450cd79f0bf82e aws-via-haskell.cabal %}

## Part 3: The imports

We import a few functions from the `amazonka-ssm` package:

{% gist d0b144694361c41f4d450cd79f0bf82e SSMImports.hs %}

## Part 4: The program

This is one of the simpler AWS programs in this series. This is a summary:

* We generate type-safe wrappers for the SSM service using `wrapAWSService`
* We declare some `newtype` wrappers
* We write a string parameter in `doPutParameter`
* We read the parameter back in `doGetParameter`

{% gist d0b144694361c41f4d450cd79f0bf82e Main.hs %}

## Part 5: The full working demo project

I've gathered this all together into this buildable [project][aws-via-haskell-repo]. As always, I like to build using [Stack][stack].

## Part 6: Related posts

* [Part 1: DynamoDB]({% post_url 2017-12-13-aws-via-haskell %})
* [Part 2: S3]({% post_url 2017-12-19-aws-via-haskell-s3 %})
* [Part 3: SQS]({% post_url 2017-12-20-aws-via-haskell-sqs %})
* [Part 4: SimpleDB]({% post_url 2017-12-22-aws-via-haskell-simpledb %})
* [Part 5: Lambda]({% post_url 2017-12-29-aws-via-haskell-lambda %})
* [Part 6: EC2]({% post_url 2018-01-12-aws-via-haskell-ec2 %})

[amazonka-ssm]: https://hackage.haskell.org/package/amazonka-ssm
[aws]: https://aws.amazon.com/
[aws-free-tier]: https://aws.amazon.com/free/
[aws-via-haskell-repo]: https://github.com/rcook/aws-via-haskell/
[fitbit]: https://www.fitbit.com/
[lambda]: https://aws.amazon.com/lambda/
[localstack]: https://github.com/localstack/localstack
[ssm]: https://aws.amazon.com/systems-manager/
[stack]: https://haskellstack.org/
