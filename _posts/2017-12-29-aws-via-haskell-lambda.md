---
layout: post
title: AWS via Haskell Part 5 (Lambda)
created: 2017-12-29 07:14:00 -0800
tags:
- Haskell
- AWS
- Lambda
- IAM
- STS
- Template Haskell
---
Welcome to another instalment of "AWS via Haskell". [Last time]({% post_url 2017-12-22-aws-via-haskell-simpledb %}) we discussed AWS's SimpleDB database. Today, we will talk about [Lambda][lambda].

Lambda is at the forefront of AWS's "serverless" offerings. The gist of it is that you can write functions and upload them to Lambda and the system will take care of scaling them as appropriate. These functions can interoperate with backend AWS services and can be invoked in various different ways. AWS Lambda functions can be written in various programming languages, including JavaScript, Java, C# and Python. In this post, I will take you through provisioning and calling a function written in Python 2.7.

This post will, by necessity, be more detailed than most of my previous posts on the subject of [AWS][aws]. This is largely because getting a Lambda function up and running is a good deal more involved than the other services we have discussed up until now. It requires us to interact with two other AWS services, namely [IAM (Identity and Access management)][iam] and the AWS [STS (Security Token Service)][sts] in order to grant appropriate permissions to our function to execute.

## Part 1: Shared code

As I wrote the example code for this article, I took the time to polish the pieces of code shared between the various demo programs in my [AWS via Haskell project][aws-via-haskell-repo]. Here's a summary of what I did to the [shared library][lib]:

* Split the main `AWSInfo` module into the following separate child modules:
    * [`AWSService`][gist-AWSService]: configures and creates connections to AWS, specifically the `connect` and `withAWS` functions
    * [`Classes`][gist-Classes]: provides the `ServiceClass` and `SessionClass` type classes to enable type-safe wrapping of AWS connections
    * [`TH`][gist-TH]: provides a Template Haskell function `wrapAWSService` which can be used to generate type-safe wrappers
    * [`Types`][gist-Types]: provides various supporting types
* Tried to develop some kind of naming convention

You may wonder what the purpose of [`wrapAWSService`][gist-wrapAWSService] and the type classes is. Well, since the code in today's program uses three distinct AWS services (IAM, STS and Lambda), all three of which are modelled by a single [`Service`][service] type, I found it tricky to keep the three separate: for example, I found myself passing the [`sts`][sts-service] service object to functions expecting the [`lambda`][lambda-service] object instead. I decided to use a combination of type classes and Template Haskell to generate type-safe wrappers around `Service`. The type classes look like:

{% gist 802f0b02591d4fd46e47e8de34b8218d Classes.hs %}

`ServiceClass` represents types that wrap the `Network.AWS.Service` type while `SessionClass` wraps the concept of a "session", which I invented for this blog post. A session combines a service along with environment (`Network.AWS.Env`) and configuration information. This is very much analogous to a database connection or session, hence the name. Note how I'm using GHC's [`TypeFamilies`][ghc-type-families] language extension to allow us to declare the type alias `TypedSession` within the `ServiceClass` type class. This allows us to introduce a functional dependency between the argument to the [`connect`][gist-connect] function and its return type:

{% gist 802f0b02591d4fd46e47e8de34b8218d Connect.hs %}

This type signature also requires another language extension, namely [`ScopedTypeVariables`][ghc-scoped-type-variables] to enable explicit `forall` quantification.

We can manually create our own service and session types and provide instances of the `ServiceClass` and `SessionClass` type classes:

{% gist 802f0b02591d4fd46e47e8de34b8218d DDBService.hs %}

It occurred to me after I'd already got things up and running that `newtype` wrappers instead of `data` wrappers would be more efficient. I will probably revisit the design of these type classes at some point in the future. In fact, you will have noticed that I have gradually and repeatedly refined the implementation of this kind of machinery over the course of these blog posts.

As you can probably appreciate, manually implementing these types and type class instances for every `Service` instance in the amazonka library is liable to get tedious. Since the code produced is totally uniform, I decided to implement some Template Haskell to generate the types automatically. Incidentally, this happens to be my first program to use Template Haskell. I found this [Template Haskell tutorial][markkarpov-th] to be invaluable along the way.

Here is the big ol' lump of Template Haskell used to automatically derive instances for service and session types:

{% gist 802f0b02591d4fd46e47e8de34b8218d TH.hs %}

From the comment block, you can see the approximate shape of code that the `Q`-based tree will generate. I would've liked to have implemented more of this using Template Haskell's quasiquoters, but I ran into a few problems with interpolation of splices within quasiquoted blocks. Again, I may revisit this once I have more time to study Template Haskell.

Using the `wrapAWSService` function, we can do the following at the top level in our program:

{% gist 802f0b02591d4fd46e47e8de34b8218d WrapAWSServiceSample.hs %}

This will generate the following types and values:

* `IAMService`
* `IAMSession`
* `iamService`
* `LambdaService`
* `LambdaSession`
* `lambdaService`
* `STSService`
* `STSSession`
* `stsService`

We can now write functions that operate only on an `STSSession`, for example:

{% gist 802f0b02591d4fd46e47e8de34b8218d DoGetAccountID.hs %}

This has the strong advantage over a version taking `Service`: we can only pass an `STSSession` value here.

## Part 2: Prerequisites

Now, we can move onto the task of writing code against Lambda. First, you'll need access to a Lambda instance. There are several options:

* Create an [AWS][aws] account and use the real SimpleDB service in the cloud: you can start with the [free tier][aws-free-tier] and go from there
* Install [localstack][localstack] or similar and use its Lambda implementation

localstack is a fine solution. Unfortunately, it has a few limitations:

* localstack does not provide implementations of IAM and STS: in fact, localstack runs "wide open" and none of the roles and policy stuff we'll need to do to work against the "real" Lambda will be necessary
* localstack currently only handles Python functions: this is not much of a limitation for this post, since Python is my choice of Lambda language anyway

In order to get around localstack's lack of IAM and STS support, I have extracted the roles and policy code into a separate helper function (`awsSession`). Other than that, the program will work equally well against AWS or localstack. You'll need to edit [this line][line214] of the program to switch between AWS or localstack.

## Part 3: The dependencies

Here is the relevant section from our (continually growing!) `.cabal` file:

{% gist 802f0b02591d4fd46e47e8de34b8218d aws-via-haskell.cabal %}

A few notes:

* amazonka dependencies:
    * `amazonka`
    * `amazonka-iam`
    * `amazonka-lambda`
    * `amazonka-sts`
* amazonka uses `aeson` for its JSON serialization/deserialization
* Other new dependencies:
    * `directory`: to get the user's home directory
    * `filepath`: for file path manipulations
    * `text-format`: for formatting strings
    * `time`: for generating Posix timestamps
    * `zip-archive`: for creating Zip packages

## Part 4: The program

Here it is in all its glory:

{% gist 802f0b02591d4fd46e47e8de34b8218d Main.hs %}

As always, I have adopted the "explicit `import`" style in which I list out almost every function consumed by the body of my code. This improves discoverability of a program's dependencies, though it does lead to what I'm going to call "Haskell `import` Hell".

I'll go over the code function by function:

### `main`

* Sets up the Lambda session using either `awsSession` (for AWS Lambda) or `localStackSession` (for localstack Lambda)
* Zips up a code package containing the following simple `add_handler` Python function
* Creates the function in Lambda
* Invokes the function in Lambda and outputs the result

The Python handler function looks like:

{% gist 802f0b02591d4fd46e47e8de34b8218d add_handler.py %}

This shows how Lambda passes arguments into handlers and how handlers return values to the caller. Everything is handled using Python dictionaries: `event` contains all the arguments and the return value from the function is a Python dictionary containing zero or more result fields. Lambda essentially serializes the arguments and return values as JSON which explains amazonka-lambda's dependency on [aeson][aeson].

### `awsSession`

This function is used in the case of AWS Lambda to provision a `lambda_basic_execution` role in order to run our handler. This code creates the role and attaches the standard `AWSLambdaBasicExecutionRole` policy to it which gives the handler permission to run. This function also shows how to delete functions, detach policies, delete roles and other housekeeping tasks. It consumes the following self-explanatory functions to do this:

* `awsLambdaBasicExecutionRolePolicy`
* `doGetAccountID`
* `doDeleteFunctionIfExists`
* `doDetachRolePolicyIfExists`
* `doDeleteRoleIfExists`
* `doCreateRoleIfExists`
* `doAttachRolePolicy`

### `waitForRolePolicy` and `doListAttachedRolePolicies`

These two functions are not needed in the case of localstack. In the case of AWS Lambda they demonstrate how one might deal with replication delays in AWS. As we saw in previous "AWS via Haskell" posts, many of the AWS APIs provide "waiters" to enable client code to wait for certain long-running operations to complete. Waiters, however, are not provided to deal with AWS's eventual consistency model and some operations take longer to replicate than other. According to AWS documentation and [forum posts][forum-post], the process of attaching policies to roles will sometimes result in different policies being visible from different endpoints. Unfortunately, the API does not provide a waiter or equivalent mechanism that would allow us to block until the `AttachRolePolicy` operation is fully visible across all endpoints. Instead, this code demonstrates one possible way to poll the service until there is a good likelihood that the policy has replicated.

### `localStackSession`

This connects to localstack's Lambda service which runs on `localhost` on port `4574` by default.

### `zipFunctionCode`

This function uses functions from the zip-archive package to create a conforming handler code package for Lambda.

### Creating, listing and invoking functions

These operations are handled by the following functions:

* `doListFunctions`
* `doCreateFunctionIfNotExists`
* `doInvoke`

## Part 5: Notes

As with my previous "AWS via Haskell" posts, this is a very brief zoom through the APIs in question. However, I think it should give you enough information to get started exploring them yourself. It also serves to pass on the experience I gained and to avoid some of the [pitfalls][my-nonbug] I encountered along the way. Suffice it to say, programming against the Lambda service was considerably more challenging than some of the simpler services such as DynamoDB etc.

## Part 6: The full working demo project

I've gathered this all together into this buildable [project][aws-via-haskell-repo]. As always, I like to build using [Stack][stack].

## Part 7: Related posts

* [Part 1: DynamoDB]({% post_url 2017-12-13-aws-via-haskell %})
* [Part 2: S3]({% post_url 2017-12-19-aws-via-haskell-s3 %})
* [Part 3: SQS]({% post_url 2017-12-20-aws-via-haskell-sqs %})
* [Part 4: SimpleDB]({% post_url 2017-12-22-aws-via-haskell-simpledb %})
* [Part 6: EC2]({% post_url 2018-01-12-aws-via-haskell-ec2 %})
* [Part 7: SSM]({% post_url 2018-03-02-aws-via-haskell-ssm %})

[aeson]: https://hackage.haskell.org/package/aeson
[aws]: https://aws.amazon.com/
[aws-free-tier]: https://aws.amazon.com/free/
[aws-via-haskell-repo]: https://github.com/rcook/aws-via-haskell/
[forum-post]: https://forums.aws.amazon.com/message.jspa?messageID=732022
[ghc-scoped-type-variables]: https://wiki.haskell.org/Scoped_type_variables
[ghc-type-families]: https://wiki.haskell.org/GHC/Type_families
[gist-AWSService]: https://gist.github.com/rcook/802f0b02591d4fd46e47e8de34b8218d#file-awsservice-hs
[gist-Classes]: https://gist.github.com/rcook/802f0b02591d4fd46e47e8de34b8218d#file-classes-hs
[gist-TH]: https://gist.github.com/rcook/802f0b02591d4fd46e47e8de34b8218d#file-th-hs
[gist-Types]: https://gist.github.com/rcook/802f0b02591d4fd46e47e8de34b8218d#file-types-hs
[gist-connect]: https://gist.github.com/rcook/802f0b02591d4fd46e47e8de34b8218d#file-awsservice-hs-L71
[gist-wrapAWSService]: https://gist.github.com/rcook/802f0b02591d4fd46e47e8de34b8218d#file-th-hs-L56
[iam]: https://aws.amazon.com/iam/
[lambda]: https://aws.amazon.com/lambda/
[lambda-service]: https://hackage.haskell.org/package/amazonka-lambda-1.5.0/docs/Network-AWS-Lambda.html#v:lambda
[lib]: https://github.com/rcook/aws-via-haskell/tree/master/lib
[line214]: https://gist.github.com/rcook/802f0b02591d4fd46e47e8de34b8218d#file-main-hs-L214
[markkarpov-th]: https://markkarpov.com/tutorial/th.html
[my-nonbug]: https://github.com/brendanhay/amazonka/issues/434
[localstack]: https://github.com/localstack/localstack
[service]: https://hackage.haskell.org/package/amazonka-core-1.5.0/docs/Network-AWS-Types.html#t:Service
[sts]: http://docs.aws.amazon.com/STS/latest/APIReference/Welcome.html
[sts-service]: https://hackage.haskell.org/package/amazonka-sts-1.5.0/docs/Network-AWS-STS.html#v:sts
[stack]: https://haskellstack.org/
