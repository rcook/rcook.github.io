<?php

if ($_SERVER['REQUEST_URI'] === '/') {
  require realpath(__DIR__ . '/../templates/index.template.php');
  die;
}

# TODO: Replace trailing slashes in regular expression with mod_rewrite rules...
if (preg_match('/^\/kb(?P<id>\d+)\/*$/', $_SERVER['REQUEST_URI'], $matches) === 1) {
  $id = (int)$matches['id'];
  require realpath(__DIR__ . '/../templates/details.template.php');
  die;
}

header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
