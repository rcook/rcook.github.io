require 'rake'
require 'shellwords'

desc 'Preview the site with Jekyll'
task :preview do
  if ENV['JEKYLL_ALL_POSTS'] == '1'
    limit = []
  elsif ENV.include?('JEKYLL_LIMIT_POSTS')
    limit = ['--limit_posts', ENV['JEKYLL_LIMIT_POSTS']]
  else
    limit = ['--limit_posts', '5']
  end

  sh [
    'bundle',
    'exec',
    'jekyll',
    'serve',
    limit,
    '--incremental',
    '--watch',
    '--drafts',
    '--host', '0.0.0.0'
  ].flatten.shelljoin
end

desc 'Test the site with Proofer'
task :test do
  require 'html-proofer'
  sh 'bundle exec jekyll build --trace'
  HTMLProofer.check_directory('./_site').run
end
