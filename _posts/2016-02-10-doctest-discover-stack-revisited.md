---
layout: post
title: Using doctest-discover with Stack revisited
created: 2016-02-06 22:00:00 -0800
tags:
- Haskell
- Stack
- GitHub
---
*This is follow-up to [this post][1]*

[A fellow Haskeller][2] asked the [following question][3]:

> Hi,
>
> I followed your blog-post but without success in a relative simple project, so
> I peeked into this project to figure some differences out. But you removed the
> dependency to doctest-discover in 7ccdf59. Can you elaborate why, maybe in a
> follow up or update?:) Just out of curiosity. I think I will try your current
> approach, too.
>
> Greetings & Thanks

I responded to his question and thought I'd be worth repeating my answer here:

> @MaxDaten: Thanks for pointing out this discrepancy. I found and used
> doctest-discover (which I still think is an excellent package) while writing
> the blog post and then decided to take a slightly different approach a few
> days later. The main motivation behind this was to get the project building
> with Travis-CI. Since doctest-discover is not yet in Stackage, I ran into
> problems with this (see failed build, for example). Without this non-Stackage
> dependency, the project builds reliably in Travis-CI (see successful build).
>
> I have suggested to the owner of doctest-discover that he add it to the
> Stackage repository, but I don't think he is strongly motivated to do so (see
> thread). I also tried to get the Travis-CI build working using extra-deps in
> my stack.yaml configuration, but I ran out of patience. I'm sure this is
> possible and might try it again some time in the future.
>
> For the time being, I've tagged the revision immediately before 7ccdf59 and
> updated the blog post to reference this tag instead of HEAD. Some time soon
> I'll write a follow-up post mentioning this.
>
> If you're still having issues, please let me know what build or test failures
> you're seeing and maybe I can help point you in the right direction.

I hope that's useful to someone!

[1]: {% post_url 2016-01-06-doctest-discover-stack %}
[2]: https://github.com/MaxDaten
[3]: https://github.com/rcook/github-api-haskell/issues/1
