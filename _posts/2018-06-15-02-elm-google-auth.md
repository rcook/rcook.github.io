---
layout: post
title: Simple Elm app with Google authentication via ports
created: 2018-06-15 14:15:00 -0700
tags:
- Elm
- Google
---
Here's my first real use of [ports][ports] in an [Elm][elm] application. It'll be light on the commentary, heavy on code.

### `.gitignore`

* Ignore some generated files
* Ignore assets such as the Google API client ID and [jQuery][jquery]

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 .gitignore %}

### `elm-package.json`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 elm-package.json %}

### `index.html`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 index.html %}

### `index.js`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 index.js %}

### `Interop.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Interop.elm %}

### `Main.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Main.elm %}

### `Makefile`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Makefile %}

### `Model.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Model.elm %}

### `Msg.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Msg.elm %}

### `Subscriptions.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Subscriptions.elm %}

### `Update.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Update.elm %}

### `View.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 View.elm %}

### Repository

Check out the [full repository][repo].

[elm]: https://elm-lang.org/
[jquery]: https://jquery.com/
[ports]: https://guide.elm-lang.org/interop/javascript.html
[repo]: https://gist.github.com/rcook/f10afe19d18b67ba1abbaaa1763ad1e3/
