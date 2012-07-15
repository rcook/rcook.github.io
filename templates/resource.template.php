<?php

$metadata = MetadataReader::readMetadata($id);
if (!array_key_exists($resourceName, $metadata['resources'])) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  die;
}

$mimeType = $metadata['resources'][$resourceName];

header('Content-Type: ' . $mimeType);
readfile(realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/' . $resourceName));

