<?php

function getSection($content, $sectionName) {
  $beginMarker = '<!-- begin:' . $sectionName . ' -->';
  $endMarker = '<!-- end:' . $sectionName . ' -->';
  $beginIndex = strpos($content, $beginMarker);
  if ($beginIndex === false) {
    throw new Exception();
  }
  $endIndex = strpos($content, $endMarker);
  if ($endIndex === false) {
    throw new Exception();
  }

  $sectionLength = $endIndex - $beginIndex - strlen($beginMarker);
  $sectionContent = substr($content, $beginIndex + strlen($beginMarker), $sectionLength);
  return $sectionContent;
}

$contentPath = realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/index.htm');
if ($contentPath === false) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  die;
}

$metadata = MetadataReader::readMetadata($id);

$content = file_get_contents($contentPath);
$headContent = getSection($content, 'head');
$bodyContent = getSection($content, 'body');

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= sprintf('KB%03d', $metadata['id']) ?></title>
  <link rel="stylesheet" href="/static/style/default.css">
  <?= $headContent ?>
</head>
<body>
<div class="banner">
<?= sprintf('KB%03d', $metadata['id']) ?>&mdash;<?= htmlspecialchars($metadata['title']) ?></h1>
</div>
<ul>
  <li><a href="/">Return to KnowledgeBase index</a></li>
</ul>
<?= $bodyContent ?>
</body>
</html>

