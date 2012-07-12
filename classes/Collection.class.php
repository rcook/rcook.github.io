<?php

final class MetadataReader {
  public static function readMetadata($id) {
    $manifestPath = realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/manifest.json');
    $metadata = json_decode(file_get_contents($manifestPath), true);
    $metadata['id'] = $id;
    return $metadata;
  }

  private final function __construct() {}
}

final class Article {
  private $metadata;

  public final function __construct($metadata) {
    $this->metadata = $metadata;
  }

  public final function getId() {
    return $this->metadata['id'];
  }

  public final function getTitle() {
    return $this->metadata['title'];
  }

  public final function getMetadata() {
    return $this->metadata;
  }
}

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

