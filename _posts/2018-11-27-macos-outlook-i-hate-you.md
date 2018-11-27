---
layout: post
title: I hate macOS and Microsoft Outlook!
created: 2018-11-27 08:15:00 -0800
tags:
- macOS
- Outlook
---
Microsoft Outlook on macOS randomly throws away my keyboard shortcuts. Therefore, I am forced to document the process of fixing the keyboard shortcut here:

In Outlook:

* Create a folder for storing your archived messages
* Select a message and move it to the newly created folder
* Ensure that an appropriate command is added to the _Message_ \| _Move_ menu
* Make a note of the exact command name

From the _System Preferences&hellip;_ system menu:

* Click _Keyboard_
* Click _Shortcuts_ tab
* Select _App Shortcuts_
* Click _+_
* Select _Microsoft Outlook_ under _Application_
* Enter the exact command name under _Menu Title_
* Enter a keyboard shortcut under _Keyboard Shortcut_
* Click _Add_

Voil&agrave;!

Note that Outlook might periodically remove the command from the _Message_ \| _Move_ menu. In this case your keyboard shortcut will stop working. To fix this issue, reinstate the command by moving another message to the archive folder.
