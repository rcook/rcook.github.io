---
layout: post
title: Setting up Haskell dev environment
created: 2018-12-16 08:00:00 -0800
tags:
- Haskell
- Stack
---
In my [usethetypes][usethetypes] videos, I demonstrate how to use [Intero][usethetypes-intero] and [ghcid][usethetypes-ghcid] with VSCode. However, I always forget the magical commands to run. I summarize them here:

```bash
stack build intero
stack build --copy-compiler-tool ghcid
```

[usethetypes]: https://usethetypes.com
[usethetypes-ghcid]: https://usethetypes.com/videos/004-rapid-dev-ghcid
[usethetypes-intero]: https://usethetypes.com/videos/001-vscode-intero
