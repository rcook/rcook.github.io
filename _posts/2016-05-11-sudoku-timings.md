---
layout: post
title: Sudoku timings
created: 2016-05-11 09:27:00 -0700
tags:
- Tableau
- Haskell
- Concurrency
---
Get the [code][github] and check out the [viz][viz]:

<script type='text/javascript' src='https://public.tableau.com/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1004px; height: 869px;'><noscript><a href='#'><img alt='Dashboard ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Su&#47;Sudokutimings&#47;Dashboard&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz' width='1004' height='869' style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='site_root' value='' /><param name='name' value='Sudokutimings&#47;Dashboard' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Su&#47;Sudokutimings&#47;Dashboard&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='showTabs' value='y' /></object></div>

`sudoku1`, `sudoku2` etc. are implementations of a Sudoku solver using various
degrees and styles of parallelism, where `sudoku1` is the "reference" (i.e.
completely sequential) implementation. Elapsed times are given in seconds while
"speedup" is the ratio of a the reference elapsed time to a given
implementation's elapsed time.

Code is based on the examples from [Simon Marlow's][parconc] book.

[github]: https://github.com/rcook/sudoku-solver
[parconc]: https://github.com/simonmar/parconc-examples
[viz]: https://public.tableau.com/views/Sudokutimings/Dashboard?:embed=y&:display_count=yes&:showTabs=y
