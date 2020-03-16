---
layout: post
title: Parsing MSBuild project XML in Rust
created: 2020-03-16 08:52:00 -0700
tags:
- Rust
- Programming
---
Today's post is short and sweet. Today, I figured out how to parse MSBuild project XML files (`.csproj`, `.targets` files etc.) using the Rust [sxd-document][sxd-document] and [sxd-xpath][sxd-xpath] packages. Here it is:

{% gist 01b316d835d99df34111b3e70292d8dc main.rs %}

Or check out the full, buildable project [here][parse-project-xml].

[parse-project-xml]: https://github.com/rcook/parse-project-xml
[sxd-document]: https://github.com/shepmaster/sxd-document
[sxd-xpath]: https://github.com/shepmaster/sxd-xpath
