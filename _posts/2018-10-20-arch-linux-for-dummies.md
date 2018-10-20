---
layout: post
title: Arch Linux for Dummies
created: 2018-10-20 09:35:00 -0700
tags:
- Operating systems
- Linux
- Arch Linux
---
These instructions assume that you already have a functional Linux installation on your system with all the common commands available etc. I ran all of these on my Lubuntu 18.04 system.

I hope that eventually this is a setup guide that I can print out and follow along with. Installing Arch Linux with just a smartphone to connect to the Internet is no fun. This consolidates all my experience installing Arch on an existing Linux-based system over wi-fi and without requiring an external USB flash media to do so.

## Prerequisites

Make sure you have some free disc space. Use GParted or `fdisk` etc. to resize your partitions as appropriate. I typically set aside 50 GB of unallocated space for this kind of experimentation. I don't typically bother with a swap partition so I won't document how to do that here.

## Download and verify ISO

```bash
# Download SHA1 checksums, ISO and signature files
wget http://mirror.rackspace.com/archlinux/iso/2018.10.01/sha1sums.txt
wget http://mirror.rackspace.com/archlinux/iso/2018.10.01/archlinux-2018.10.01-x86_64.iso
wget http://mirror.rackspace.com/archlinux/iso/2018.10.01/archlinux-2018.10.01-x86_64.iso.sig

# Verify integrity of ISO file
sha1sum -c <<< $(head -1 sha1sums.txt)

# Verify signature
gpg --keyserver-options auto-key-retrieve --verify archlinux-2018.10.01-x86_64.iso.sig
```

## Move the ISO under `/boot` somewhere

I'd like to put the `.iso` file under `/boot/iso` and then configure GRUB to pick the image from this location. So, let's create this directory if it doesn't already exist and then figure out which device it lives on:

```bash
sudo mkdir -p /boot/iso
sudo mv archlinux-2018.10.01-x86_64.iso /boot/iso
df /boot/iso
```

On my system, this reports `/dev/sda5`. This is hard drive 0, GPT partition number 5. Make a note of this for the next section.

## Configure GRUB to boot from ISO

This will create a GRUB custom configuration file in the correct location (assuming you're running on Ubuntu or something similar) and then update GRUB's configuration. As noted previously, `/boot/iso` on my system is hard drive 0, GPT partition 5, hence GRUB device `(hd0,gpt5)` below. Replace this with the appropriate hard drive and partition numbers for your system:

```bash
cat << EOF | sudo tee -a /etc/grub.d/35_arch
#!/bin/sh
exec tail -n +3 \$0
# This file provides an easy way to add custom menu entries.  Simply type the
# menu entries you want to add after this comment.  Be careful not to change
# the 'exec tail' line above.
probe -u \$root --set=rootuuid
set imgdevpath="/dev/disk/by-uuid/\$rootuuid"
menuentry 'archlinux-2018.10.01-x86_64.iso' {
  set isofile='/boot/iso/archlinux-2018.10.01-x86_64.iso'
  loopback loop (hd0,gpt5)\$isofile
  linux (loop)/arch/boot/x86_64/vmlinuz img_dev=\$imgdevpath img_loop=\$isofile
  initrd (loop)/arch/boot/x86_64/archiso.img
}
EOF
sudo chmod 755 /etc/grub.d/35_arch
sudo update-grub
```

The last line will regenerate the GRUB configuration file at `/boot/grub/grub.cfg`.

## Reboot your system

On rebooting your system, you should now be presented with an `archlinux-2018.10.01-x86_64.iso` boot option. If GRUB doesn't present the menu, you may need to tweak your global GRUB configuration file template which is stored typically at `/etc/default/grub`. Options which work well for me are as follows:

```
GRUB_HIDDEN_TIMEOUT=
GRUB_TIMEOUT_STYLE=menu
GRUB_TIMEOUT=10
```

Edit the file using `sudo vim /etc/default/grub` or whatever and make the appropriate changes. Once you've updated the file, regenerate the GRUG configuration file. Reboot your system again after that.

Once you have the `archlinux-2018.10.01-x86_64.iso` option available to you, select this to boot from it.

## Create partition

At this point, you should be running inside a base Arch Linux system running from the `.iso`. Note that you have an ephemeral file system at this point and any changes you make (installing packages), creating files etc. will be discarded on shutdown of the system. So, it's important to get a partition up and running in order to allow your changes to persist.

My free 50 GB of unallocated space is on `/dev/sda`:

```bash
cfdisk /dev/sda
```

I'll assume that you know how to safely create a new ext4 partition for your system. In my case, this step resulted in a shiny new 50 GB ext4 on device `/dev/sda2`.

## Format partition

This step might not be necessary since I think `cfdisk` already does this for you. I'll document it here anyway:

```bash
mkfs.ext4 /dev/sda2
```

## Mount partition

```bash
mount /dev/sda2 /mnt
```

## Get Internet working

I'm working on a laptop without the luxury of a wired Ethernet connection, so I need to get wi-fi working. First figure out which device you care about:

```bash
ip link
```

My wi-fi device is `wlp2s0`. Yours will probably be different. Replace `wlp2s0` with your device name is commands listed below.

```bash
wpa_passphrase ssid > /wpa.conf
```

Replace `ssid` with the name of your wi-fi network and enter the passphrase. This will create a configuration file, `/wpa.conf`, containing an encoded version of the passphrase and other information.

```bash
wpa_supplicant -B -i wlp2s0 -c /wpa.conf
dhclient wlp2s0
ping rcook.org
```

## Install some useful stuff

I like to open up my instructions in a text mode browser and split the screen so I can follow along in the terminal. Let's install a couple of packages to do just that:

```bash
pacman -Sy lynx tmux
```

At this point, I can start tmux, split the screen and run Lynx in one of the splits in order to open up Arch Linux documentation (or this blog post).

## Install base Arch Linux system

This will pull packages from the Internet using the wi-fi connection we just established:

```bash
pacstrap /mnt base base-devel
```

## Configure root account etc.

This will mount the new partition in a sandbox and allow us to configure the root directory and account. It'll also allow us to install some starter packages to get things going:

```bash
arch-chroot /mnt
```

Set your root password:

```bash
passwd
```

Choose your preferred language(s):

```bash
nano /etc/locale.gen
```

Configure your language(s):

```bash
locale-gen
```

Configure your time zone:

```bash
ln -s /usr/share/zoneinfo/America/Los_Angeles /etc/localtime
```

Set your host name:

```bash
echo myhost > /etc/hostname
```

Create an "init" file:

```bash
mkinitcpio -p linux
```

Update your GRUB configuration to scan for this new OS:

```bash
update-grub
```

Install useful starter packages and settings to get wi-fi working on reboot and to enable basic browsing of the Internet:

```bash
pacman -Sy dhclient dialog iw lynx tmux wpa_actiond wpa_supplicant
systemctl enable netctl-auto@wlp2s0.service
```

Once that's done, exit out of the chroot sandbox and reboot your system:

```bash
umount /mnt
reboot
```

## Boot new Arch Linux installation

At this point, your GRUB menu should include an option to start up your fresh new Arch Linux installation. Do it!
