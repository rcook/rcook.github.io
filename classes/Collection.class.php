<?php

final class Collection {
  private $articles = null;

  public final function __construct() {
  }

  public final function getArticles() {
    $this->ensureArticles();
    return $this->articles;
  }

  private final function ensureArticles() {
    if ($this->articles === null) {
      $this->articles = array();
      $handle = opendir(realpath(__DIR__ . '/../content'));
      while (($entry = readdir($handle)) !== false) {
        if (preg_match('/^kb(?P<id>\d+)$/', $entry, $matches) === 1) {
          $id = (int)$matches[1];
          $metadata = MetadataReader::readMetadata($id);
          $this->articles[$id] = new Article($metadata);
        }
      }
      closedir($handle);
      ksort($this->articles);
    }
  }
}

