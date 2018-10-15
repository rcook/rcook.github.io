---
layout: post
title: Preparing Ubuntu VM for screencasting
created: 2018-07-25 07:35:00 -0700
tags:
- Ubuntu
- VirtualBox
---
## Prerequisites

This tutorial assumes you already have a working installation of [VirtualBox][virtualbox]. This tutorial assumes VirtualBox 5.2.16 and Ubuntu 18.04 Desktop.

## Downloads

Download [Ubuntu][ubuntu].

## Create new VM

* Open VirtualBox
* Click _New_
* Enter _ubuntu-18.04-desktop_ next to _Name_
* Select _Linux_ next to _Type_
* Select _Ubuntu (64-bit)_ next to _Version_
* Click _Continue_
* Select _4096 MB_ under _Memory size_
* Click _Continue_
* Select _Create a virtual hard disk now_ radio button
* Click _Create_
* Select _VDI (VirtualBox Disk Image)_ under _Hard disk file type_
* Click _Continue_
* Select _Dynamically allocated_ under _Storage on physical hard disk_
* Click _Continue_
* Enter _10.00 GB_ under _File location and size_
* Click _Create_

## Attach installation medium

* Right-click _ubuntu-18.04-desktop_ from list of virtual machines
* Click _Settings&hellip;_
* Click _Storage_
* Click _Empty_ under _Controller: IDE_
* Click CD icon next to _IDE Secondary Master_
* Click _Choose Virtual Optical Disk File&hellip;_
* Select _ubuntu-18.04-desktop-amd64.iso_ downloaded previously and click _Open_

## Start new VM

* Right-click _ubuntu-18.04-desktop_ from list of virtual machines
* Select _Start_ and click _Normal Start_
* Select _English_
* Click _Install Ubuntu_
* Select _English (US)_ and _English (US)_
* Click _Continue_
* Select _Normal installation_ radio button
* Click _Continue_
* Select _Erase disk and install Ubuntu_ radio button
* Click _Install Now_
* Click _Continue_
* Click _Continue_ under _Where are you?_
* Enter your name next to _Your name_
* Enter a computer name next to _Your computer's name_
* Enter a user name next to _Pick a username_
* Enter a password next to _Choose a password_ and _Confirm your password_
* Select _Require my password to log in_
* Click _Continue_
* Wait for a while&hellip;
* Click _Restart Now_
* Press _Enter_

## Get rid of "What's new in Ubuntu"

* Log in
* Under _What's new in Ubuntu_, click _Next_
* Click _Next_ again
* Select _No, don't send system info_
* Click _Next_
* Click _Done_

## Perform software updates

Open a terminal and run the following:

```
sudo apt-get -y update
sudo rm /var/lib/apt/lists/lock /var/cache/apt/archives/lock /var/lib/dpkg/lock
sudo apt-get -y upgrade
sudo apt-get -y install build-essential module-assistant
```

## Install VM Additions

* From _Devices_, click _Insert Guest Additions CD image&hellip;_
* When prompted, click _Run_ for _VBox_GAs_5.2.16_ CD
* Enter password
* Click _Authenticate_
* When install completed, press _Enter_ to close the window
* From _Devices_, _Optical Drives_, click _Remove disk from virtual drive_
* Click _Force Unmount_
* Restart the VM
* Right-click _ubuntu-18.04-desktop_ from list of VMs
* Click _Settings&hellip;_
* Under _General_ and _Advanced_, ensure _Shared Clipboard_ is set to _Bidirectional_
* Click _OK_

## Set resolution and remove window chrome

* From _View_, click _Virtual Screen 1_ and click _Resize to 1280x720_
* From _View_, click _Status Bar_ and uncheck _Show Status Bar_
* From _View_, click _Menu Bar_ and uncheck _Show Menu Bar_

## Tidy up desktop

* Remove unused icons from dock
* Right-click Terminal in dock and click _Add to Favorites_
* Click _Activities_ and type _hide top bar_
* Click on _Hide Top Bar_ (GNOME Shell Extension)
* Follow prompts
* Click _Install_ and _Install_ to confirm
* Click _Extension Settings_
* Under _Intellihide_, toggle both _Only hide panel when a window takes the space_ and _Only when the active window takes the space_ into the "off" position
* Open terminal and run `sudo apt-get -y install gnome-tweak-tool`
* Launch Tweaks using `gnome-tweaks &`
* Click _Desktop_ and set _Show Icons_ to "off"
* Close Tweaks

## Install Chrome

* Open Firefox from dock
* Go to `https://chrome.google.com/` and follow instructions to install Chrome
* Once installed, launch Chrome and add it to the dock by right-clicking and selecting _Add to Favorites_
* Remove Firefox from dock

## Install large-icon theme

* Go `https://www.gnome-look.org/content/show.php/Large+Mouse+Cursors?content=140787`
* Download `140787-LargeCursors.tar.bz`

```
mkdir $HOME/.icons
cd $HOME/.icons
tar xvjf $HOME/Downloads/140787-LargeCursors.tar.bz2
gnome-tweaks &
```

* Click on _Appearance_
* Select _Large Mouse Cursors_ next to _Cursor_

## Install and configure key-mon

From a terminal:

```
sudo apt-get -y install key-mon
key-mon &
```

Configure it as follows:

* Drag to bottom right-hand corner of screen
* Right-click the window and click _Settings&hellip;_
* Click _Misc_ tab
* Next to _Themes_ select _big-letters_
* Next to _Keymap_ select _us.kbd_
* Click _Close_

Configure it to run at startup:

```
gnome-session-properties &
```

* Under _Additional startup programs_, click _Add_
* Next to _Name_ enter _key-mon_
* Next to _Command_ enter _/usr/bin/key-mon_
* Click _Add_
* Click _Close_
* Log out and log back in

[ubuntu]: http://releases.ubuntu.com/18.04/ubuntu-18.04-desktop-amd64.iso
[virtualbox]: https://www.virtualbox.org/
