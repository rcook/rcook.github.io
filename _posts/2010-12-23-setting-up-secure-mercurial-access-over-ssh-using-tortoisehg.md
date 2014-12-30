---
layout: post
title: Setting up secure Mercurial access over ssh using TortoiseHg
created: 2010-12-23 16:22:40 -0800
tags:
- Windows tools
---
# Background

I've been primarily a Linux/Mac OS X-based developer for the last year or so. However, I recently moved back to Microsoft and so figured that I should refamiliarize myself with Windows development. I have, of course, become completely dependent upon the standard tools such as `ssh`. Being the security-minded fellow I am, I will continue to fanatically refuse to use `ssh` with password-based authentication instead of public-private key pairs. While ports of all these tools, of course, exist for Windows, it is not always so straightforward to use them in what is a completely natural way. Here I will describe in detail my experiences setting up Mercurial over `ssh` with passwordless authentication and encryption. I'm going to use TortoiseHg since it includes PuTTY, which is a fairly nice Windows implementation of `ssh`. While these steps have been detailed many times before, I will repeat them here for anyone who's interested.

# Downloads

* Download and install `tortoisehg-1.1.7-hg-1.7.2-x64.msi` from http://mercurial.selenic.com/
* Download and install `plink.exe` from http://the.earth.li/~sgtatham/putty/latest/x86/plink.exe
* Download and install `putty.exe` from http://the.earth.li/~sgtatham/putty/latest/x86/putty.exe
* Download and install `puttygen.exe` from http://the.earth.li/~sgtatham/putty/latest/x86/puttygen.exe

# Prerequisites

* A Linux server with `sshd` and password-based authentication disabled
* A Windows client machine
* Another Windows/Linux/Mac OS X machine that already has public keys exchanged with the Linux server and thus has a trust relationship established with it

# Steps

* Run `puttygen.exe`
* Select `SSH-2 RSA` and enter `2048` in `Number of bits in a generated key`
* Click on `Generate`
* Move mouse as per the instructions in order to generate randomness
* Set a passphrase in `Key passphrase` and `Confirm passphrase`
* Save the public and private keys using `Save public key` and `Save private key`
* Copy the public key into the clipboard from `Public key for pasting into OpenSSH authorized_keys file`
* Using the already trusted machine, upload the public key to the server and append its contents to the `authorized_keys` in the `.ssh` directory
* Create a new `Mercurial.ini` file in your home directory with the following content:

```
[ui]
ssh = TortoisePlink.exe -i "C:/path/to/ppk-file.ppk"
```

* Start `Pageant.exe` (which has equivalent functionality to OpenSSH's `ssh-agent`)
* Add the private key to Pageant
* You should now be able to clone/push/pull etc. to/from the server

