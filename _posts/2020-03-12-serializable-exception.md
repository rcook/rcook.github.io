---
layout: post
title: Example of a serializable exception in C#
created: 2020-03-12 09:56:00 -0800
tags:
- C#
- Programming
---
I'm just saving this here for future reference: here's an example of a serializable exception in C#:

{% gist 99785b845116686a7250a6770f41d115 XmlValidationException.cs %}

Some things of note:

* It has a `[Serializable]` attribute
* It implements a deserializing constructor `XmlValidationException(SerializationInfo, StreamingContext)`
* It overrides `GetObjectData(SerializationInfo, StreamingContext)`

Also included is a battery of unit tests to verify that the class really does serialize and deserialize itself properly:

{% gist 99785b845116686a7250a6770f41d115 XmlValidationExceptionTests.cs %}
