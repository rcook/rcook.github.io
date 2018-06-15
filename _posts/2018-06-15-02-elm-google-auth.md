---
layout: post
title: Simple Elm app with Google authentication via ports
created: 2018-06-15 14:15:00 -0700
tags:
- Elm
- Google
- JavaScript
- Promise
- jQuery
- Ports
- Interoperability
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
* [elm-live][elm-live]: This application combines HTML, JavaScript and Elm components which the standard Elm development server, [elm-reactor][elm-reactor], only barely copes with after some cajoling: elm-live does a good job of handling something closer to real apps and has live reloading too!

The application can be run by typing `make` at the command line:

* Downloads jQuery locally
* Runs the app using elm-live

#### `.gitignore`

* Ignores some generated files
* Ignores assets such as the Google API client ID and [jQuery][jquery]

You'll need to create your `google-api-client-id.txt` file by grabbing your Google API client ID after consulting the following resources:
    * [Creating and managing projects][create-google-api-project]
    * [Setting up OAuth 2.0][set-up-oauth2]

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 .gitignore %}

#### `elm-package.json`

* Defines package metadata including description and Git repo
* Defines dependencies

This file is typically updated using the [`elm-package`][elm-package] command.

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 elm-package.json %}

#### `index.html`

* Includes scripts including jQuery, Elm compiler output and application JavaScript
* Contains empty `<body>` element where Elm application is rendered

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 index.html %}

#### `index.js`

This is the main JavaScript application code:

* Uses strict mode using `"use strict";` because you should always do this!
* Stubs out Elm port endpoints in order to produce useful runtime errors if ports with no subscriptions are called
* Wraps some things like loading scripts in JavaScript [promises][javascript-promise] to make them easier and more elegant to compose
* Subscribes to Google authentication callbacks and hooks them up to Elm subscriptions via ports

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 index.js %}

#### `Interop.elm`

* Defines the outgoing and incoming ports

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Interop.elm %}

#### `Main.elm`

* Defines standard Elm `main` function

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Main.elm %}

#### `Makefile`

* Downloads jQuery
* Runs the app

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Makefile %}

#### `Model.elm`

* Defines simple data model
* Tracks authentication data supplied via ports
* Defines a simple `message` field for displaying error messages to the user

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Model.elm %}

#### `Msg.elm`

* Defines the Elm `Msg` type
* `NativeError` is used to report errors back from JavaScript
* `AuthStateChanged` is fired whenever the user signs in or out
* `SignInClicked` is triggered when the user clicks the sign-in button
* `SignOutClicked` is triggered when the user clicks the sign-out button

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Msg.elm %}

#### `Subscriptions.elm`

* Handles incoming port calls from JavaScript
* Decodes the different payloads using elm-decode-pipeline

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Subscriptions.elm %}

#### `Update.elm`

* Defines the standard `update` function for updating the state of the app

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 Update.elm %}

#### `View.elm`

* Renders a simple view that displays the state of the app

{% gist f10afe19d18b67ba1abbaaa1763ad1e3 View.elm %}

### Repository

Check out the full project [here][repo].

[create-google-api-project]: https://cloud.google.com/resource-manager/docs/creating-managing-projects
[elm]: https://elm-lang.org/
[elm-decode-pipeline]: http://package.elm-lang.org/packages/NoRedInk/elm-decode-pipeline/3.0.0
[elm-live]: https://github.com/architectcodes/elm-live
[elm-package]: https://github.com/elm-lang/elm-package
[elm-reactor]: https://github.com/elm-lang/elm-reactor
[google-api-javascript]: https://developers.google.com/api-client-library/javascript/
[index-js]: https://gist.github.com/rcook/f10afe19d18b67ba1abbaaa1763ad1e3/#file-index-js
[interop-elm]: https://gist.github.com/rcook/f10afe19d18b67ba1abbaaa1763ad1e3/#file-interop-elm
[javascript-promise]: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise
[jquery]: https://jquery.com/
[ports]: https://guide.elm-lang.org/interop/javascript.html
[repo]: https://gist.github.com/rcook/f10afe19d18b67ba1abbaaa1763ad1e3/
[set-up-oauth2]: https://support.google.com/cloud/answer/6158849?hl=en
