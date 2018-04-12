---
layout: post
title: Lambda updates
created: 2018-03-11 11:31:00 -0800
tags:
- Haskell
- AWS
- Lambda
- Amazon Linux
---
This is the update to my post about [not being able to run]({% post_url 2018-03-08-haskell-aws-lambda %}) my Haskell AWS Lambda function.

So, I think I figured it out. These are some of the various things I tried which didn't work:

* Building the function in an Amazon Linux virtual machine
* Packaging up dependencies as described [here][aws-lambda-haskell]

Neither of these experiments fixed the problem.

What did seem to fix the problem, however, was&hellip; Wait for it&hellip;

&hellip; Increasing the amount of RAM in the Lambda function's environment. I increased the RAM from the default (128 MB) to 1 GB and I seem to have achieved reliable execution of my function.

I suppose this shouldn't have surprised me.

[aws-lambda-haskell]: https://github.com/abailly/aws-lambda-haskell/blob/master/README.md
