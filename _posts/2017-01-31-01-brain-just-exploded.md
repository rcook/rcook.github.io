---
layout: post
title: Brain Just Exploded
created: 2017-01-31 20:35:00 -0800
tags:
- Haskell
---
```
/Users/rcook/src/pansite/app/Main.hs:69:26: error:
    • My brain just exploded
      I can't handle pattern bindings for existential or GADT data constructors.
      Instead, use a case-expression, or do-notation, to unpack the constructor.
    • In the pattern: ToolConfigParser toolConfigParser

      In a pattern binding:
        (ToolConfigParser toolConfigParser)
          = case HashMap.lookup name m of {
```
