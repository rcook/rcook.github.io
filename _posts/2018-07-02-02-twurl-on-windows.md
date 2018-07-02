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

```bash
twurl "/1.1/search/tweets.json?q=nasa&result_type=popular"
```

Notice how I've surrounded the URL with double quotes: this is necessary since the `&` character has special meaning on most operating systems including Windows.

This command will generate a blob of JSON. You can save this to a file as follows:

```bash
twurl "/1.1/search/tweets.json?q=nasa&result_type=popular" > nasa.json
```

This will create a file named `nasa.json`. You can pretty-print this JSON to the command prompt using a little Ruby script as follows:

```ruby
require 'json'

obj = JSON.parse(File.read('nasa.json'))
puts JSON.pretty_generate(obj)
```

A roughly equivalent Python script would be:

```python
import json

with open("nasa.json", "rt") as f:
    obj = json.loads(f.read())

print(json.dumps(obj, indent=2))
```

Note that this only returns the first 15 tweets. Here's a bigger Python script that will handle the pagination for you:

```python
#!/usr/bin/env python2
import subprocess
import json
import urllib
import urlparse

# twurl must have already been authorized using the "authorize" subcommand
TWURL_COMMAND = ["twurl"]

def make_url(url, qs):
  qs_str = urllib.urlencode(qs)
  return url if len(qs_str) == 0 else "{}?{}".format(url, qs_str)

def search(url, qs):
  statuses = []

  while True:
    full_url = make_url(url, qs)
    command = TWURL_COMMAND + [full_url]
    obj = json.loads(subprocess.check_output(command))

    statuses.extend(obj["statuses"])
    search_metadata = obj["search_metadata"]
    next_results = search_metadata.get("next_results")
    if next_results is None:
      break

    qs = urlparse.parse_qsl(next_results[1:])

  return statuses

statuses = search("/1.1/search/tweets.json", [
  ("q", "nasa"),
  ("result_type", "popular")
])

print(json.dumps(statuses, indent=2))
```

Done for now.

[bigredabacus]: https://bigredabacus.com/
[ruby-installer]: https://github.com/oneclick/rubyinstaller2/releases/download/rubyinstaller-2.4.4-2/rubyinstaller-devkit-2.4.4-2-x64.exe
[search-example]: https://developer.twitter.com/en/docs/tweets/search/api-reference/get-search-tweets.html
[twitter-api-keys]: https://apps.twitter.com/app/15428470/keys
[twurl]: https://github.com/twitter/twurl
