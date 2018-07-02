---
layout: post
title: Page display mode in hello.js and YNAB
created: 2018-07-02 09:15:00 -0700
tags:
- HTML
- JavaScript
- hello.js
- OAuth
- YNAB
---
My wife, [Katy][bigredabacus], is a big fan of [YNAB][ynab] and consequently we've started writing an app for it. I get to do all the fun parts like figuring out the authentication/authorization.

Plumbing in OAuth2 support has always been tricky and adding support for multiple OAuth providers has, at least in my case, always led to a bunch of ugly code. Fortunately, I recently discovered [hello.js][hello-js] which takes away much of the pain.

In the specific case of my application, I want to require the user to sign in on initial page load. I wanted to do this using the standard popup. However, this, of course, proves to be impossible in the presence of popup blockers (see [my bug report][bug-report] and various [StackOverflow discussions][stackoverflow]. Fortunately, there is the "page" display mode provided by the [`hello.login`][hello-login] method which works pretty well. I'd like to share my simple demo app with you today.

My application consists of a landing page `index.html`:

{% gist 360f788a00f66194269d1efb42de3f80 index.html %}

All this does is provide a link to the "dashboard" which is defined in `dashboard.html` which is where the meat of the application lives:

{% gist 360f788a00f66194269d1efb42de3f80 dashboard.html %}

The dashboard has the following things of note:

* Includes `<script>` tags to load [jQuery][jquery], hello.js and my own `hello-ynab.js` script (described below)
* Defines a simple module `Auth` which encapsulates a handful of hello.js methods
* A "sign-out" button which is enabled when the user is signed in and which simply signs the user out and redirects back to `index.html`

Finally, I provide my own custom hello.js module to provide basic support for YNAB:

{% gist 360f788a00f66194269d1efb42de3f80 hello-ynab.js %}

Once this module is fleshed out a little more, I hope to contribute it back to the hello.js project.

The code repository also includes copies of `jquery.min.js` and `hello.js` and so should be a fully working demo app. To run it locally, you'll need to do the following:

* Clone the repository from `https://gist.github.com/360f788a00f66194269d1efb42de3f80.git`
* [Obtain a YNAB client ID][ynab]
* Replace `REDACTED` in `dashboard.html` with this client ID
* Run a simple web server in the repository's directory, e.g. `python -m SimpleHTTPServer 3000`

Note that YNAB requires an HTTPS redirect URI, so you'll probably end up having to set up an Nginx reverse proxy to slap some TLS on top of your simple web server. Here's a simple Nginx configuration file demonstrating roughly how you might do this:

{% gist 360f788a00f66194269d1efb42de3f80 nginx.conf %}

Enjoy!

[bigredabacus]: https://bigredabacus.com/
[bug-report]: https://github.com/MrSwitch/hello.js/issues/564
[hello-login]: https://adodson.com/hello.js/#hellologin
[hello-js]: https://adodson.com/hello.js/
[jquery]: https://jquery.com/
[stackoverflow]: https://stackoverflow.com/questions/2587677/avoid-browser-popup-blockers
[ynab]: https://ynab.com/
