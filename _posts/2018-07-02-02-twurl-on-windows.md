---
layout: post
title: Twurl on Windows
created: 2018-07-02 09:35:00 -0700
tags:
- Twurl
- Twitter
- Windows
---
[Katy][bigredabacus] likes to get her hands on interesting data. Recently, it's been Twitter data among other things. Here are the steps I recently followed to get [Twurl][twurl] working on her Windows laptop.

* Download and install Ruby using [Ruby Installer][ruby-installer]
* Open a Windows command prompt
* Check that Ruby is installed: `ruby --version`
* Check that RubyGems is installed: `gem --version`
* Install [Twurl][twurl]: `gem install twurl`
* Grab your consumer key and consumer secret from [here][twitter-api-keys]
* Authorize Twurl
  * Use your consumer key/secret: `twurl authorize --consumer-key CONSUMER_KEY --consumer-secret CONSUMER_SECRET`
  * Copy and paste the link output by the command into your browser
  * Follow the prompts
  * Click _Authorize app_
  * Copy the 7-digit PIN displayed on the final page
  * Paste the PIN into the command prompt
* Test Twurl: `twurl /1.1/statuses/home_timeline.json`

Next, we can run some Twitter search queries. Here's the [search example][search-example] tweaked a little so it actually works:

{% gist dfb7cbe66db11f66425250f9b6c451fd 0.sh %}

Notice how I've surrounded the URL with double quotes: this is necessary since the `&` character has special meaning on most operating systems including Windows.

This command will generate a blob of JSON. You can save this to a file as follows:

{% gist dfb7cbe66db11f66425250f9b6c451fd 1.sh %}

This will create a file named `nasa.json`. You can pretty-print this JSON to the command prompt using a little Ruby script as follows:

{% gist dfb7cbe66db11f66425250f9b6c451fd read_json.rb %}

A roughly equivalent Python script might be:

{% gist dfb7cbe66db11f66425250f9b6c451fd read_json.py %}

Note that this only returns the first 15 tweets. Here's a bigger Python script that will handle the pagination for you:

{% gist dfb7cbe66db11f66425250f9b6c451fd fetch_all.py %}

Done for now.

[bigredabacus]: https://bigredabacus.com/
[ruby-installer]: https://github.com/oneclick/rubyinstaller2/releases/download/rubyinstaller-2.4.4-2/rubyinstaller-devkit-2.4.4-2-x64.exe
[search-example]: https://developer.twitter.com/en/docs/tweets/search/api-reference/get-search-tweets.html
[twitter-api-keys]: https://apps.twitter.com/app/15428470/keys
[twurl]: https://github.com/twitter/twurl
