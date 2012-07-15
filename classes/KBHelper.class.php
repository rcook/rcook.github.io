<?php

final class KBHelper {
  public static function createArticleManifestFileName($id) {
    $fileName = realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/manifest.json');
    return $fileName;
  }

  public static function readArticleMetadata($id) {
    $fileName = self::createArticleManifestFileName($id);
    if ($fileName === false) {
      return false;
    }

    $metadata = MetadataReader::readFromManifest($fileName);
    if ($metadata === false) {
      return false;
    }

    $metadata['id'] = $id;
    return $metadata;
  }

  private final function __construct() {}
}

