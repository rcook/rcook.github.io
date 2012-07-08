<?php

require_once realpath(__DIR__ . '/../classes/Collection.class.php');

$indexPath = realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/index.php');

if ($indexPath === false) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
}
else {
  require $indexPath;
}

