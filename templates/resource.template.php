<?php

require_once realpath(__DIR__ . '/../classes/Collection.class.php');

$metadata = MetadataReader::readMetadata($id);
if (!in_array($resourceName, $metadata['resources'])) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  die;
}

header('Content-Type: image/png');
echo file_get_contents(realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/' . $resourceName));

