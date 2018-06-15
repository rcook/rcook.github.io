---
layout: post
title: Simple Elm app with Google authentication via ports
created: 2018-06-15 14:15:00 -0700
tags:
- Elm
- Google
---
Here's my first real use of [ports][ports] in an [Elm][elm] application. It'll be light on the commentary, heavy on code.

### Overview

This example will use the [Google API client for JavaScript][google-api-javascript] to perform OAuth2 authentication using a user's Google credentials. This will integrate into an Elm application using ports. Specifically:

* We'll define some _outgoing_ ports in order to call JavaScript functions from Elm
* We'll define some _incoming_ ports to take callbacks from JavaScript into Elm
* These will be defined in [`Interop.elm`][interop-elm]

There'll be a small amount of JavaScript glue code in [`index.js`][index-js] which will take care of marshalling the ports to and from JavaScript functions.

On the Elm side of things, the application will provide the bare minimum components to display the results of these calls via the ports mechanism to the user.

Note that I use the following packages/tools in this project:

* [NoRedInk/elm-decode-pipeline][elm-decode-pipeline]: This simplifies decoding of JSON data structures from ports
* [elm-live][elm-live]: This application combines HTML, JavaScript and Elm components which the standard Elm development server, [elm-reactor][elm-reactor], only barely copes with after some cajoling

#### `.gitignore`

* Ignore some generated files
* Ignore assets such as the Google API client ID and [jQuery][jquery]

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 .gitignore %}

#### `elm-package.json`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 elm-package.json %}

#### `index.html`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 index.html %}

#### `index.js`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 index.js %}

#### `Interop.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Interop.elm %}

#### `Main.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Main.elm %}

#### `Makefile`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Makefile %}

#### `Model.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Model.elm %}

#### `Msg.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Msg.elm %}

#### `Subscriptions.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Subscriptions.elm %}

#### `Update.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Update.elm %}

#### `View.elm`

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 View.elm %}

### Repository

Check out the [full repository][repo].

[elm]: https://elm-lang.org/
[elm-decode-pipeline]: http://package.elm-lang.org/packages/NoRedInk/elm-decode-pipeline/3.0.0
[elm-live]: https://github.com/architectcodes/elm-live
[elm-reactor]: https://github.com/elm-lang/elm-reactor
[google-api-javascript]: https://developers.google.com/api-client-library/javascript/
[index-js]: https://gist.github.com/rcook/f10afe19d18b67ba1abbaaa1763ad1e3/#file-index-js
[interop-elm]: https://gist.github.com/rcook/f10afe19d18b67ba1abbaaa1763ad1e3/#file-interop-elm
[jquery]: https://jquery.com/
[ports]: https://guide.elm-lang.org/interop/javascript.html
[repo]: https://gist.github.com/rcook/f10afe19d18b67ba1abbaaa1763ad1e3/
