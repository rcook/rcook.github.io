---
layout: post
title: Haskell in AWS Lambda
created: 2018-03-08 17:01:00 -0800
tags:
- Haskell
- AWS
- Lambda
- Amazon Linux
---
As you know, I've [blogged]({% post_url 2017-12-13-aws-via-haskell %}) a fair amount recently about calling AWS services from Haskell. I've also demonstrated a close-to-minimal [Haskell program]({% post_url 2018-02-24-hlambda %}) that can itself run inside AWS Lambda using the [`serverless-haskell`][serverless-haskell] package. Since those experiments, I've tried to get my AWS Lambda program to something useful and have, unfortunately, run into a wall. Today, I'm going to talk about some of the issues I've encountered:

# Unable to call STS APIs

First, I tried to extend my `HLambda` program to call the STS [`GetCallerIdentity`][aws-sts-GetCallerIdentity] API just to dump my account ID to the log during executing of my Lambda function. This didn't work. My original Lambda function used the `AWSLambdaBasicExecutionRole` security role. I tried increases the privileges granted to my function, even going so far as adding full `AdministratorAccess` to my function's role. None of this allowed my call to this API to succeed. In fact, the call seems to "go nowhere" and never returns. Unable to debug this, even with some metrics from [X-Ray][x-ray], I abandoned this.

# Briefly able to call SSM APIs, until I couldn't

Next, I tried calling various SSM APIs such as [`GetParameter`][aws-ssm-GetParameter] and [`PutParameter`][aws-ssm-PutParameter] after adding the `AmazonSSMFullAccess` policy to my role. At some point this worked. I even had my function successfully reading and writing `SecureString` parameters. And, then, it mysteriously stopped working. Unfortunately, I was not able to roll my program back to a working state. Nothing I was able to do to tweak my security policy etc. seemed to have any effect.

# Unable to call web APIs using [Req][req]

I then thought I'd pare things down to the bare minimum. I was able to write to the [CloudWatch][cloudwatch] log simply by writing to standard output using `putStrLn`. However, presumably due to the way the logs are buffered, not all of my messages would be visible in CloudWatch. I, therefore, created a `logMessage` function to ensure that the message is proactively flushed:

{% gist 4e1e2d624076deb3006c116ea6406ade LogMessage.hs %}

That got things to reliably show up in the log.

I then thought I'd build on that my building a minimal HTTP client using Req [LINK TO REQ]:

{% gist 4e1e2d624076deb3006c116ea6406ade Req.hs %}

This, unfortunately, suffered from the same affliction as my attempts to call into AWS APIs: the call simply doesn't not return. I'm wondering if, somehow, my AWS Lambda environment does not have access to the Internet, though I haven't been able to positively confirm this one way or another.

So, I'm stumped.

# What I'm trying next

It's possible that I'm running into difficulties because I'm building my program inside an Ubuntu 16.04 virtual machine running on VirtualBox instead of the [Amazon Linux][amazon-linux] OS running inside the [AWS Lambda execution environment][aws-lambda-env]. Perhaps, I am generating binaries that are incompatible in some way or failing due to a missing native function at runtime.

So, I decided to try to emulate this environment as closely as possible&hellip;

* I downloaded [Amazon Linux VDI][amazon-linux-download] for VirtualBox
* Following [some instructions I found][superuser-article], I determined that Amazon Linux's root account (`ec2-user`) has no password by default. I, therefore, grabbed this [ISO][init-iso] which sets the password to `password`.
* I was then able to create a new account for myself, add it to `sudoers`, add my SSH public key and log into over `ssh`.

I then proceeded to get a Haskell build environment set up with Stack and other dependencies:

{% gist 4e1e2d624076deb3006c116ea6406ade build.sh %}

I'll let you know how this goes!

[amazon-linux]: https://aws.amazon.com/amazon-linux-ami/
[amazon-linux-download]: https://cdn.amazonlinux.com/os-images/2017.12.0.20180222/virtualbox/
[aws-lambda-env]: [https://docs.aws.amazon.com/lambda/latest/dg/current-supported-versions.html]
[aws-ssm-GetParameter]: https://docs.aws.amazon.com/systems-manager/latest/APIReference/API_GetParameter.html
[aws-ssm-PutParameter]: https://docs.aws.amazon.com/systems-manager/latest/APIReference/API_PutParameter.html
[aws-sts-GetCallerIdentity]: https://docs.aws.amazon.com/STS/latest/APIReference/API_GetCallerIdentity.html
[cloudwatch]: https://aws.amazon.com/cloudwatch/
[init-iso]: http://nerdland.info/init.iso
[req]: https://hackage.haskell.org/package/req
[serverless-haskell]: https://hackage.haskell.org/package/serverless-haskell
[superuser-article]: https://superuser.com/questions/1048091/can-i-install-ec2-amazon-linux-os-locally-on-virtual-machine
[x-ray]: https://aws.amazon.com/xray/
