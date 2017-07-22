---
layout: post
title: My Haskell test workflow
created: 2017-07-22 10:03:00 -0600
tags:
- Haskell
- Test
- Elm
---
As the volume of [Haskell][haskell] code I churn out steadily increases and as I've spend more time figuring out the best way to teach Haskell programming and the Haskell programming workflow to people new to the language, I've become aware of some of the shortcomings of my process. Furthermore, as I've started to play more and more with [Elm][elm-lang], whenever I have returned to Haskell, I have become more and more jealous of the rapid turnaround possible with Elm: Elm's rapid edit-build-run cycle is a thing of joy and I've found Haskell's process to be slower and slower every time I've gone back to it.

My current experimentation is on the topic of full-stack web applications with Elm on the frontend and Haskell (using [Servant]) on the backend. Therefore, I figured it was time to streamline my Haskell process so that I don't dread it every time I need to do any backend work. I will briefly describe my current workflow.

Note that this is heavily influenced by [Oskar Wickstr&ouml;m][wickstrom]'s model, with a few small differences given my differing setup:

* Editor: [Visual Studio Code][vscode]
* Build tool: [Stack][stack]
* Application source directory: `src`
* Test source directory: `test`
* Test framework: [Hspec][hspec]

Here is my step-by-step process, assuming my project is named `MyProject` and my root test spec is in the module `MyProject.Spec`:

1. Open editor in Haskell project's directory:
```
code .
```
2. Open embedded terminal using `Ctrl+Backtick`
3. Launch GHCi loading all sources in interpreted mode:
```
stack exec -- ghci -isrc -itest MyProject.Spec
```
4. Run specs from within GHCi:
```
hspec spec
```

At this point, all my tests should be passing if I have not made any code changes yet. Now I can add new specs and edit my application sources to my heart's content. At each iteration, I reload my modules and rerun the specs from within GHCi as follows:

```
:reload
hspec spec
```

Since I'm really lazy, I even have a custom `:spec` command defined in my `ghci.conf` file as follows:

```
:def spec \_ -> return ":reload\nhspec spec"
```

Oskar's setup uses [tmux][tmux] to send keypresses from one pane to another. This is pretty nice. I would guess that it would be possible to set up a keyboard shortcut or macro within Code to achieve similar behaviour. If I ever get round to doing this, I will report back!

This same rapid turnaround cycle for specs can also be used to quickly iteration on the application itself. In my case, I run `:reload` followed by `main` to recompile and rerun by Servant backend. I can interrupt by server at any point using `Ctrl+C` from within GHCi and reload and rerun again.

[elm-lang]: http://elm-lang.org/
[haskell]: http://haskell.org/
[hspec]: https://hspec.github.io/
[servant]: http://hackage.haskell.org/package/servant
[stack]: https://haskellstack.org/
[tmux]: https://tmux.github.io/
[vscode]: https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwj895a8pJ3VAhUP32MKHeAWC8AQFggmMAA&url=https%3A%2F%2Fcode.visualstudio.com%2F&usg=AFQjCNFJKyN71_pTGlo3tbjTpAWVghKtHg
[wickstrom]: https://wickstrom.tech/programming/2016/04/19/a-faster-test-workflow-for-haskell.html
