---
layout: post
title: Configuring a Raspberry Pi as a Linux Network Appliance
created: 2018-11-01 17:03:00 -0700
tags:
- Raspberry Pi
- Raspbian
- Linux
---
## Initial setup

* [Raspbian Stretch][raspbian]
* Write it to an 8 GB flash card using [Etcher][etcher]
* Attach a USB keyboard, an HDMI monitor and an Ethernet cable
* Boot it up and log in using the default user `pi` and password `raspberry`

## Configure keyboard

```bash
sudo raspi-config
```

* Select _4 Localisation Options_
* Select _I3 Change Keyboard Layout_
* Follow the prompts

## Enable SSH service

```bash
sudo raspi-config
```

* Select _5 Interfacing Options_
* Select _P2 SSH_

## Get IP address

```bash
hostname -I
```

From now on you can remotely access the system from an SSH client at this IP address, which we'll refer to as `ip` below.

## Expand filesystem

```bash
sudo raspi-config
```

* Select _7 Advanced Options_
* Select _A1 Expand Filesystem_
* Follow the prompts including rebooting the system

## Create new root user

```bash
sudo adduser newuser
sudo adduser newuser sudo
```

## Remove default `pi` user

```bash
sudo deluser --remove-home pi
```

* Follow the prompts to set a password etc.
* Log out of the system
* Log in as the new user
* Verify that this user can elevate to root with `sudo su`

## Copy SSH public key to system

From your client machine:

```bash
ssh-copy-id newuser@ip
```

## Lock down SSH config

Add the following to `/etc/ssh/sshd_config` to enforce public key authentication etc.:

```
Protocol 2
PasswordAuthentication no
PermitRootLogin no
PubkeyAuthentication yes
AuthenticationMethods publickey
AllowUsers newuser
PermitEmptyPasswords no
```

## Change your host name

Edit the host name file:

```bash
sudo nano /etc/hostname
```

Then replace occurrences of `raspberrypi` with the new host name:

```bash
sudo nano /etc/hosts
```

Then reboot your system:

```bash
sudo reboot
```

[etcher]: https://www.balena.io/etcher/
[raspbian]: https://www.raspbian.org/
