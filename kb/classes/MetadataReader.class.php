<?php

final class MetadataReader {
  public static function readFromManifest($fileName) {
    $json = file_get_contents($fileName);
    $metadata = json_decode($json, true);
    if (is_null($metadata)) {
      return false;
    }
    return $metadata;
  }

  private final function __construct() {}
}

