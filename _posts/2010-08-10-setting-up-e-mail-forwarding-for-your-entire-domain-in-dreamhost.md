---
layout: post
title: Setting up e-mail forwarding for your entire domain in Dreamhost
created: 2010-08-10 07:52:50 -0700
categories:
- !binary |-
  ZS1tYWls
- !binary |-
  ZHJlYW1ob3N0
---
<h2>Overview</h2>
<p>
  These instructions assume that you would like to set up "catch-all" forwarding, that is you would like mail sent to any e-mail address in your domain to go to some real e-mail address that is outside the domain and most likely managed by a third-party web-based e-mail provider such as Gmail, Yahoo! or Hotmail. To achieve this we need to set up two forwards per domain. The first sets up a single e-mail address within the domain to forward to your real e-mail address and the second sets up a "catch-all" e-mail address to forward mail to every other address to the single e-mail address within the domain. Note that this scheme was developed to work around the fact that Dreamhost will <em>not</em> allow direct forwarding from a catch-all e-mail address to another e-mail address that is not hosted by Dreamhost.
</p>
<p>
  We will assume the following values for the step-by-step instructions:
</p>
<ul>
  <li>Your domain: <tt>yourdomain.com</tt></li>
  <li>The single forwarding e-mail address within the domain: <tt>info@yourdomain.com</tt></li>
  <li>Your real e-mail address outside the domain to which all mail is ultimately forwarded: <tt>me@gmail.com</tt></li>
</ul>
<h2>Step-by-step instructions</h2>
<ul>
  <li>Log in to your Dreamhost account control panel at <tt>https://panel.dreamhost.com/</tt>.</li>
  <li>From the navigation panel click on the big <tt>Email</tt> button [<a href="/sites/default/files/screenshot1.jpg">screenshot</a>].</li>
  <li>Create the single e-mail address to forward to your real e-mail address:<br />
    <ul>
      <li>Click on <tt>Create New Email Address</tt> link [<a href="/sites/default/files/screenshot2.jpg">screenshot</a>].</li>
      <li>Scroll down until the <tt>Forward-Only Email</tt> section is visible [<a href="/sites/default/files/screenshot3.jpg">screenshot</a>].</li>
      <li>Enter an e-mail address field by selecting the domain name and entering a value in the <tt>Email Address</tt> field, e.g. <tt>info</tt>. [<a href="/sites/default/files/screenshot3.jpg">screenshot</a>].</li>
      <li>In the <tt>List all email addresses to forward to, one per line</tt> field enter your <em>real</em> e-mail address, e.g. <tt>me@gmail.com</tt> etc.</li>
      <li>Click the <tt>Forward to These Addresses!</tt> button to create the forwarding.</li>
    </ul>
  </li>
  <li>Create the catch-all e-mail address to catch all other e-mail for your domain:<br />
    <ul>
      <li>Click on <tt>Create New Email Address</tt> link [<a href="/sites/default/files/screenshot2.jpg">screenshot</a>].</li>
      <li>Scroll down until the <tt>Forward-Only Email</tt> section is visible [<a href="/sites/default/files/screenshot3.jpg">screenshot</a>].</li>
      <li>Enter <tt>catch-all</tt> in the <tt>Email Address</tt> field. [<a href="/sites/default/files/screenshot3.jpg">screenshot</a>].</li>
      <li>In the <tt>List all email addresses to forward to, one per line</tt> field enter the <tt>info@yourdomain.com</tt> address created previously.</li>
      <li>Click the <tt>Forward to These Addresses!</tt> button to create the forwarding.</li>
    </ul>
  </li>
  <li>All done!</li>
</ul>
<p>
  It will take some time for the changes to take effect, but once the changes are in place all e-mail sent to any address in your domain will forward to the e-mail address <tt>me@gmail.com</tt>.
</p>

