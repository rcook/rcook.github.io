---
layout: post
title: GHCi Helper
created: 2017-12-24 20:22:00 -0800
tags:
- Haskell
- VSCode
- JavaScript
---
Now I've got back into the swing of hacking and prototyping in Haskell, I have spent some time tweaking my workflow in my editor of choice, [Visual Studio Code][vscode].

The approach that I currently favour is to run GHCi in the integrated terminal and run the `:reload` and `:main` commands to iteratively reload and run my programs. What has hobbled me a little is the (apparent) inability to directly automate this by assigning the action to a keyboard shortcut. Fortunately, it turns out that writing VSCode extensions is reasonably straightforward. So, it is with great fanfare that I announce [GHCi Helper][ghci-helper]. This simple extension adds the following two commands:

* `ghciHelperStart`: Creates a terminal and runs `stack ghci` in it
* `ghciHelperReload`: Sends `:reload` and `:main` commands to the terminal opened with the `ghciHelperStart` command

I can now bind a keyboard shortcut (I'm currently using `F7`) to the second command and I have my rapid reload/rerun development cycle.

[ghci-helper]: https://marketplace.visualstudio.com/items?itemName=rcook.ghci-helper
[vscode]: https://code.visualstudio.com/
