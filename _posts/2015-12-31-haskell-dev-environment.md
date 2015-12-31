---
layout: post
title: Haskell development environment
created: 2015-12-31 13:13:00 -0800
tags:
- Haskell
---
### Install Stack

See [1].

### Test Stack

{% highlight bash %}
$ mkdir src
$ cd src
$ stack new hello-world simple
$ stack build
$ stack exec hello-world
{% endhighlight %}

### Add Stack binaries to `PATH`

{% highlight bash %}
$ cd ~
$ stack setup
$ stack path | grep ghc-paths
$ stack path | grep local-bin-path
{% endhighlight %}

Add the `ghc-paths` and `local-bin-path` values to `PATH` in `.bashrc`. For
example:

{% highlight bash %}
export PATH=/home/rcook/.stack/programs/x86_64-linux/ghc-7.10.2/bin:/home/rcook/.local/bin:$PATH
{% endhighlight %}

### Set up Haskell tools

{% highlight bash %}
$ cd ~
$ stack install hdevtools
$ stack install hlint
$ stack install cabal-helper ghc-mod
$ stack install hoogle
$ hoogle data
{% endhighlight %}

### Set up vim

From [2], [3], [4] and [5]:

{% highlight bash %}
$ mkdir -p ~/.vim/autoload ~/.vim/bundle ~/.vim/swap
$ curl -LSso ~/.vim/autoload/pathogen.vim https://tpo.pe/pathogen.vim
$ cd ~/.vim/bundle
$ git clone https://github.com/scrooloose/syntastic.git
$ git clone https://github.com/bitc/vim-hdevtools.git
$ git clone https://github.com/eagletmt/neco-ghc.git
{% endhighlight %}

[1]: http://docs.haskellstack.org/en/stable/install_and_upgrade.html#ubuntu
[2]: https://github.com/tpope/vim-pathogen
[3]: https://github.com/scrooloose/syntastic
[4]: https://github.com/bitc/vim-hdevtools
[5]: https://github.com/eagletmt/neco-ghc.git

