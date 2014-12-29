---
layout: post
title: Caching `nil` values with Dalli in Ruby on Rails
created: 2013-07-22 22:54:38 -0700
tags:
- Ruby
- Ruby on Rails
---
Here's a monkeypatch for `ActiveSupport::Cache::DalliStore` to allow caching of
`nil` using the null object pattern:

{% gist 6057142 %}

