---
layout: post
title: Mercurial automatic forward porting script
created: 2013-07-23 11:11:34 -0700
tags:
- Ruby
- Ruby on Rails
- Mercurial
---
This implements the [Mercurial standard branching
strategy](http://mercurial.selenic.com/wiki/StandardBranching):

{% gist 6064683 %}

Eventually, I intend to have this script run automatically as part of a hook.

