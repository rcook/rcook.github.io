---
layout: post
title: Disc usage
created: 2014-07-15 08:29:44 -0700
tags:
- Linux
---
{% highlight bash %}
du -hsc $(\ls -A) | sort -rh | less
{% endhighlight %}

