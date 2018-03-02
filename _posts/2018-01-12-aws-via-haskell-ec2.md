---
layout: post
title: AWS via Haskell Part 6 (EC2)
created: 2018-01-12 07:00:00 -0800
tags:
- Haskell
- AWS
- EC2
---
Welcome back! It's been a week or two since my last post on this subject, but here it is! Today, I'm going to talk about how to interact with AWS [EC2][ec2] using the [amazonka][amazonka] and [amazonka-ec2][amazonka-ec2] packages. EC2, like [Lambda]({% post_url 2017-12-29-aws-via-haskell-lambda %}), is a more involved service than some of the others. Furthermore, because the APIs I'll talk about in this post are used to start and stop real, live, actual virtual machines, some of the APIs take longer to run and consume more AWS resources. Fortunately, the [AWS free tier][aws-free-tier] provides sufficient juice to learn how to use the APIs.

There are many moving parts to EC2. Consequently, the EC2 API is big. If you don't believe me, then feel free to [check out][amazonka-ec2-types] the number of types in amazonka-ec2. I have managed to pare down the APIs required to produce a minimally useful demo that demonstrates the following:

* Importing key pairs for credentials
* Creating security groups
* Running a new EC2 instance
* Querying the EC2 instance's status

The end result is a program that will start an EC2 instance and provide enough information for users to connect to the instance via [SSH][openssh]. The resulting example program will run a single instance of one of the standard Amazon Linux [AMIs][amis]. It will assume that you have a private-public key pair in the standard locations, i.e. `$HOME/.ssh/id_rsa` and `$HOME/.ssh/id_rsa.pub`, on your system. To grab the key pairs from a different location, please edit the program as necessary. Windows users will need to generate an `ssh-keygen`-style key pair using [PuTTY][putty] or similar and edit the program as appropriate. The program will import the public portion of your key pair in order to allow remote access to your newly created EC2 instance.

## Part 1: Shared code

Since my previous instalments, the shared code has undergone some more refactoring. I've simplified some of the names and also introduced an AWS-specific prelude in the form of `AWSViaHaskell.Prelude`:

{% gist da0443e277d2c25800930e4599cf030d Prelude.hs %}

This imports the most commonly used amazonka functions and types in order to slim down the import lists in each Haskell sample. This is the best approach I have devised so far to deal with "Haskell import hell". Similarly, I have extracted all the amazonka-ec2 imports for this program in the form of `EC2Imports.hs`:

{% gist da0443e277d2c25800930e4599cf030d EC2Imports.hs %}

## Part 2: Prerequisites

To run this example code, you'll need access to EC2. The most obvious way is to use the AWS free tier. This code will assume that you set up an appropriate account. Unfortunately, I have not yet found a local-only test environment for this kind of thing. [localstack][localstack] does not, yet, provide emulation of EC2.

## Part 3: The dependencies

We have a pretty standard set of dependencies:

* `amazonka-ec2`
* `aws-via-haskell`
* `base`
* `bytestring`
* `directory`
* `filepath`
* `lens`
* `text`

You'll notice that we do not require a direct dependency on `amazonka`. This is handled by the re-exports provided by `AWSViaHaskell.Prelude`.

{% gist da0443e277d2c25800930e4599cf030d aws-via-haskell.cabal %}

## Part 4: The program

### EC2 service wrappers

We generate type-safe wrappers for the EC2 service using `wrapAWSService`:

{% gist da0443e277d2c25800930e4599cf030d wrapAWSService.hs %}

This generates the following items:

* `ec2Service`
* `EC2Service`
* `EC2Session`

### `newtype` wrappers for function arguments

We declare a number of `newtype` wrappers around the `Text` type. These are intended to prevent the developer from passing one type of `Text` when a function expects another `Text`.

Aside: amazonka, like many frameworks, is somewhat "stringly-typed" and this is my attempt to impose some order on some of its functions which take multiple `Text` arguments. In fact, there is [concrete example][csg-bug] of a bug resulting from stringly-typeness and code generation where the order of multiple `Text` arguments have been changed between version 1.4.5 and 1.5.0. This results in unfortunately _runtime_ bugs in the code. `newtype` wrappers for my sample functions here should minimize the chance of this happening at least at the level of these new functions.

{% gist da0443e277d2c25800930e4599cf030d newtype-wrappers.hs %}

### Summary of `main` function

* Loads the public key portion from `$HOME/.ssh/id_rsa.pub`
* Connects to EC2 in the "Ohio" region: you'll need to tweak this to match your own region
* Imports the public key portion into EC2 if it's not already there present: the function evaluated here demonstrates error handling using a custom matcher`_DuplicateKeyPair`: many of the other amazonka subpackages provide custom error matchers which is not the case for amazonka-ec2, presumably because the number of errors that are routinely encountered in EC2 land is large: fortunately, it's straightforward to implement custom matchers for the kinds of errors we'll encounter in our simple example
* Lists all public keys registered in EC2
* Creates a security group if not already there: the newly created security group allows inbound traffic on port 22 from any IP address, thus enabling remote access via SSH; it also defines another custom error matcher `_DuplicateGroup`
* Runs a single instance using the _ami-caaf84af_ AMI and the name of the key and ID of the security group created previously
* Demonstrates how to wait until the instance is running
* Demonstrates how to wait until the instance's status is OK
* Gets the new instance's public DNS name
* Writes the SSH command line used to connect to the new instance

Here is the code:

{% gist da0443e277d2c25800930e4599cf030d Main.hs %}

## Part 5: Notes

So, this should be enough to provision all the resources required to run an instance and to provide an `ssh` command line to connect to it.

Don't forget to terminate the EC2 instance after you're done!

## Part 6: The full working demo project

I've gathered this all together into this buildable [project][aws-via-haskell-repo]. As always, I like to build using [Stack][stack].

## Part 7: Related posts

* [Part 1: DynamoDB]({% post_url 2017-12-13-aws-via-haskell %})
* [Part 2: S3]({% post_url 2017-12-19-aws-via-haskell-s3 %})
* [Part 3: SQS]({% post_url 2017-12-20-aws-via-haskell-sqs %})
* [Part 4: SimpleDB]({% post_url 2017-12-22-aws-via-haskell-simpledb %})
* [Part 5: Lambda]({% post_url 2017-12-29-aws-via-haskell-lambda %})
* [Part 7: SSM]({% post_url 2018-03-02-aws-via-haskell-ssm %})

[amazonka]: https://hackage.haskell.org/package/amazonka
[amazonka-ec2]: https://hackage.haskell.org/package/amazonka-ec2
[amazonka-ec2-types]: https://hackage.haskell.org/package/amazonka-ec2-1.5.0/docs/Network-AWS-EC2-Types.html
[amis]: https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/AMIs.html
[aws-free-tier]: https://aws.amazon.com/free/
[aws-via-haskell-repo]: https://github.com/rcook/aws-via-haskell/
[csg-bug]: https://github.com/brendanhay/amazonka/issues/439
[ec2]: https://aws.amazon.com/ec2/
[localstack]: https://github.com/localstack/localstack
[openssh]: https://en.wikipedia.org/wiki/OpenSSH
[putty]: https://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html
[stack]: https://haskellstack.org/
