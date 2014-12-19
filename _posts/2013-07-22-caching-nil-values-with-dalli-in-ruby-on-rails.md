---
layout: post
title: Caching nil values with Dalli in Ruby on Rails
created: 1374558878
categories:
- !binary |-
  cnVieQ==
- !binary |-
  cnVieSBvbiByYWlscw==
---
Here's a monkeypatch for `ActiveSupport::Cache::DalliStore` to allow caching of nil using null object pattern:

[gist:6057142]
