---
layout: post
title: Yesod and Hakyll together (part 1)
created: 2016-03-16 08:00:00 -0800
tags:
- Haskell
- Yesod
- Hakyll
- Keter
- Apache
---
I currently use [Yesod][yesod] along with [Keter][keter] for the
[seattlehaskell.org][seahug] web site and I'm very pleased with it. The site has
a very small dynamic portion, specifically the bit which queries the [Meetup
API][meetup-api] to list upcoming meetings on the web site's front page.

In order to support future static content, I really want to use a static content
generator and the obvious choice for a Haskell-based and Haskell-themed web site
is [Hakyll][hakyll]. So, the problem is that I would like the dynamic portions
of my web site to use Yesod, the static portions to use Hakyll and, yet, I would
like to keep the two visually consistent. Over the course of a few blog posts, I
will describe the various steps I have taken to make this happen. Note, that I
haven't launched the new variant of the site yet and, so, some of the approaches
I will describe are still experimental.

## Part 1: Apache configuration

I use [Apache][apache] as the front end web server and, so, the first problem is
how to serve such a "blended" web site. I have Keter serving my Yesod
application on port 3000 and I would like all my static content to be presented
under the virtual subdirectory `content`. So, given a domain name of
`mydomain.com`, here are a few examples of the routing that I would like to
configure:

* Routed to Keter/Yesod:
  * `http://mydomain.com/` (dynamic portion of Yesod app)
  * `http://mydomain.com/about` (dynamic portion of Yesod app)
  * `http://mydomain.com/static/css/bootstrap.css` (static portion of Yesod app)
* Routed to Apache's document root:
  * `http://mydomain/content/`
  * `http://mydomain/content/about`
  * `http://mydomain/content/pages/foo`

To achieve this, I use the following Apache configuration:

{% gist 0c6fb198484f05b836d9 apache2.conf %}

This sets up reverse proxing to `http://0.0.0.0:3000/` for all URLs whose root
directory is _not_ `content`. All URLs under `content` are rooted to the
document root. This configuration also does nice URL rewriting so that the
`.html` file name extension is not needed for files that exist in the document
root. Furthermore, if the request does include `.html`, the server will issue an
HTTP 307 redirect to the extensionless URL - thus ensuring one version of truth.

I already have this reverse proxying set up at [seattlehaskell.org][seahug] with
the Keter-hosted [Yesod application][seahug-source] up and running. Currently,
the static content consists of a single ["Hello World"][hello-world] file. This
will eventually be replaced with my Hakyll-generated static content.

[apache]: http://httpd.apache.org/
[hakyll]: https://jaspervdj.be/hakyll/
[hello-world]: http://seattlehaskell.org/content/
[keter]: https://github.com/snoyberg/keter
[meetup-api]: http://www.meetup.com/meetup_api/
[seahug]: http://seattlehaskell.org/
[seahug-source]: https://github.com/seahug/seattlehaskell-org
[yesod]: http://www.yesodweb.com/