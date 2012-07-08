<?php

require_once realpath(__DIR__ . '/../classes/Collection.class.php');

$contentPath = realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/index.php');

if ($contentPath === false) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  die;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= sprintf('KB%03d', $id) ?></title>
</head>
<body>
<h1><?= sprintf('KB%03d', $id) ?></h1>
<ul>
  <li><a href="/">Index</a></li>
</ul>
<?
  require $contentPath;
?>
</body>
</html>

