---
layout: post
title: Setting up e-mail forwarding for your entire domain in Dreamhost
created: 2010-08-10 07:52:50 -0700
tags:
- E-mail
- Dreamhost
---
## Overview

These instructions assume that you would like to set up "catch-all" forwarding,
that is you would like mail sent to any e-mail address in your domain to go to
some real e-mail address that is outside the domain and most likely managed by a
third-party web-based e-mail provider such as Gmail, Yahoo! or Hotmail. To
achieve this we need to set up two forwards per domain. The first sets up a
single e-mail address within the domain to forward to your real e-mail address
and the second sets up a "catch-all" e-mail address to forward mail to every
other address to the single e-mail address within the domain. Note that this
scheme was developed to work around the fact that Dreamhost will _not_ allow
direct forwarding from a catch-all e-mail address to another e-mail address that
is not hosted by Dreamhost.

We will assume the following values for the step-by-step instructions:

* Your domain: `yourdomain.com`
* The single forwarding e-mail address within the domain: `info@yourdomain.com`
* Your real e-mail address outside the domain to which all mail is ultimately
forwarded: `me@gmail.com`

## Step-by-step instructions

* Log in to your Dreamhost account [control
panel](https://panel.dreamhost.com/).
* From the navigation panel click on the big `Email` button
[[screenshot]]({{ site.url }}/assets/2010-08-10-setting-up-e-mail-forwarding-for-your-entire-domain-in-dreamhost/1.jpg).
* Create the single e-mail address to forward to your real e-mail address:
  * Click on `Create New Email Address` link
[[screenshot]]({{ site.url }}/assets/2010-08-10-setting-up-e-mail-forwarding-for-your-entire-domain-in-dreamhost/2.jpg).
  * Scroll down until the `Forward-Only Email` section is visible
[[screenshot]]({{ site.url }}/assets/2010-08-10-setting-up-e-mail-forwarding-for-your-entire-domain-in-dreamhost/3.jpg).
  * Enter an e-mail address field by selecting the domain name and entering a
value in the `Email Address` field, e.g. `info`.
[[screenshot]]({{ site.url }}/assets/2010-08-10-setting-up-e-mail-forwarding-for-your-entire-domain-in-dreamhost/3.jpg).
  * In the `List all email addresses to forward to, one per line` field enter
your _real_ e-mail address, e.g. `me@gmail.com` etc.
  * Click the `Forward to These Addresses!` button to create the forwarding.
* Create the catch-all e-mail address to catch all other e-mail for your domain:
  * Click on `Create New Email Address` link
[[screenshot]]({{ site.url }}/assets/2010-08-10-setting-up-e-mail-forwarding-for-your-entire-domain-in-dreamhost/2.jpg).
  * Scroll down until the `Forward-Only Email` section is visible
[[screenshot]]({{ site.url }}/assets/2010-08-10-setting-up-e-mail-forwarding-for-your-entire-domain-in-dreamhost/3.jpg).
  * Enter `catch-all` in the `Email Address` field.
[[screenshot]]({{ site.url }}/assets/2010-08-10-setting-up-e-mail-forwarding-for-your-entire-domain-in-dreamhost/3.jpg).
  * In the `List all email addresses to forward to, one per line` field enter
the `info@yourdomain.com` address created previously.
  * Click the `Forward to These Addresses!` button to create the forwarding.
* All done!

It will take some time for the changes to take effect, but once the changes are
in place all e-mail sent to any address in your domain will forward to the
e-mail address `me@gmail.com`.
