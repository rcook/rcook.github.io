---
layout: post
title: You need a data backup strategy
created: 2018-10-03 09:12:00 -0800
tags:
- Data
---
## Equipment

* 100 GB cloud storage account (**CloudSync**)
    * This is the primary data store
    * Also enables easy syncing between computers
    * Price: $11.99 per year
* 100 GB cloud backup plan (**CloudBackup**)
    * This is cold storage
    * Price: $9.99 per year
* 1 TB network-attached storage (**NAS**)
    * This is the live backup
* External USB drives
    * 1 TB USB external drive (**ExternalUSBBackupA**)
    * 500 GB USB external drive (**ExternalUSBBackupB**)
    * One of **ExternalUSBBackupA** or **ExternalUSBBackupB** remains off-site
    * Another, **CurrentExternalUSBBackup**, is attached to **NAS**
    * **ExternalUSBBackupA** and **ExternalUSBBackupB** are exchanged once a week

## Overview

* **CloudSync** continually syncs to **NAS**
* **NAS** backs up to **CloudBackup** once a day
* **NAS** backs up to **CurrentExternalUSBBackup** once a day
* **NAS** backs up to its own local file system every 6 hours

## Possible enhancements

* Use a smart power plug to periodically disconnect **CurrentExternalUSBBackup** from **NAS**
