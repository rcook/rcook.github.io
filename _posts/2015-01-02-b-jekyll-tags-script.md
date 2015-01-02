---
layout: post
title: Dump tags in Jekyll static web site
description: "I thought I'd turn my hand to extracting metadata from my Jekyll-based static blog"
created: 2015-01-02 09:15:00 -0800
tags:
- Jekyll
- Ruby
---
In order to maintain an orderly blog, it's important to know what tags are
defined, in order to avoid misspellings, inconsistent capitalization etc. This
turns out to be fairly straightforward:

{% gist bbba3f7a6876ae989931 %}

This script reads the current Jekyll web site and dumps out an alphabetized list
of tags. This is all done without regenerating the site, which is exactly what I
wanted.

