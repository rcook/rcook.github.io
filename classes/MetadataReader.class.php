<?php

final class MetadataReader {
  public static function readFromManifest($fileName) {
    $json = file_get_contents($fileName);
    $metadata = json_decode($json, true);
    return $metadata;
  }

  private final function __construct() {}
}

