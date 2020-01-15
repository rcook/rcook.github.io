# Richard's blog

## Preview locally

```bash
gem install bundler
bundle install
bundle exec rake preview
```

In order to rebuild the site quickly, this will only render the five most recent posts. To render all posts, set the `JEKYLL_ALL_POSTS` environment variable to `1`:

```bash
JEKYLL_ALL_POSTS=1 bundle exec rake preview
```

You can also set the number of posts to render by setting the `JEKYLL_LIMIT_POSTS` environment variable:

```bash
JEKYLL_LIMIT_POSTS=20 bundle exec rake preview
```

Run tests:

```bash
bundle exec rake test
```

## Acknowledgements

* [Noita][1]
* [Michael Lanyon's blog][2]
* [jekyll-rss-feeds][3]

## Licence

All content under `_posts` and `assets` is copyright Richard Cook and cannot be
reused without explicit permission. All other content is released under the MIT
licence and is copyright of its respective owners.

[1]: https://github.com/penibelst/jekyll-noita
[2]: http://blog.lanyonm.org/
[3]: https://github.com/snaptortoise/jekyll-rss-feeds/

