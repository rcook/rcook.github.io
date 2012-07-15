<?php

define('DEBUG_MODE', true);

set_error_handler(function($severity, $message, $fileName, $lineNumber) {
  throw new ErrorException($message, 0, $severity, $fileName, $lineNumber);
});

if (DEBUG_MODE) {
  register_shutdown_function(function() {
    $errorInfo = error_get_last();
    if (!is_null($errorInfo)) {
      echo '<h1>Fatal error</h1><code><pre>';
      print_r($errorInfo);
      echo '</pre></code></body></html>';
    }
  });

  set_exception_handler(function($exception) {
    echo '<h1>Unhandled exception</h1><code><pre>';
    print_r($exception);
    echo '</pre></code>';
  });
}

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
