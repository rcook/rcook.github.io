<?php

set_error_handler(function($severity, $message, $fileName, $lineNumber) {
  throw new ErrorException($message, 0, $severity, $fileName, $lineNumber);
});

require_once realpath(__DIR__ . '/../classes/ClassAutoloader.class.php');
new ClassAutoloader(array('classes'));

if ($_SERVER['REQUEST_URI'] === '/') {
  require realpath(__DIR__ . '/../templates/index.template.php');
  die;
}

if (preg_match('/^\/kb(?P<id>\d+)\/$/', $_SERVER['REQUEST_URI'], $matches) === 1) {
  $id = (int)$matches['id'];
  require realpath(__DIR__ . '/../templates/details.template.php');
  die;
}

if (preg_match('/^\/kb(?P<id>\d+)\/(?P<resourceName>.+)$/', $_SERVER['REQUEST_URI'], $matches) === 1) {
  $id = (int)$matches['id'];
  $resourceName = $matches['resourceName'];
  require realpath(__DIR__ . '/../templates/resource.template.php');
  die;
}

header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');

