---
layout: post
title: Getting DHCP configuration information from Windows Store apps
created: 2013-04-22 06:26:38 -0700
categories:
- !binary |-
  d2luZG93cyBzdG9yZQ==
- !binary |-
  aW50ZXJvcA==
- !binary |-
  YyM=
---
I was recently asked via an e-mail from a user of my [Lanscan](http://lanscan.rcook.org/) app how to obtain DHCP information from a Windows Store app.

Fortunately, `DhcpRequestParams` and related Win32 APIs are part of the Windows Store partition of the Win32 API and so are callable from C#-based Windows Store apps (and probably other places too).

Here are Gists of the relevant p/invoke and interop declarations you'll need in order to call these functions from your C# programs:

* Native methods: [gist:8603834:NativeMethods.cs]
* `DHCPCAPI_IP_ADDRESS`: [gist:8603834:DHCPCAPI_IP_ADDRESS.cs]
* `DHCPCAPI_PARAMS`: [gist:8603834:DHCPCAPI_PARAMS.cs]
* `DHCPCAPI_PARAMS_ARRAY`: [gist:8603834:DHCPCAPI_PARAMS_ARRAY.cs]
* `DHCPCAPI_REQUEST`: [gist:8603834:DHCPCAPI_REQUEST.cs]
* `OPTION`: [gist:8603834:OPTION.cs]

