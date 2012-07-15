<?php

final class MetadataReader {
  public static function readMetadata($id) {
    $manifestPath = realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/manifest.json');
    if ($manifestPath === false) {
      return false;
    }

    $metadata = json_decode(file_get_contents($manifestPath), true);
    $metadata['id'] = $id;
    return $metadata;
  }

  private final function __construct() {}
}

