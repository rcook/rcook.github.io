require 'rake'

desc 'Preview the site with Jekyll'
task :preview do
  sh 'bundle exec jekyll serve --limit_posts 5 --incremental --watch --drafts --host=0.0.0.0'
end

desc 'Test the site with Proofer'
task :test do
  require 'html-proofer'
  sh 'bundle exec jekyll build --trace'
  HTMLProofer.check_directory('./_site').run
end
