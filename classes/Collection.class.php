<?php

final class MetadataReader {
  public static function readMetadata($id) {
    $metadata = array();
    $handle = fopen(realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/metadata.txt'), 'rt');
    $title = fgets($handle);
    $metadata['id'] = $id;
    $metadata['title'] = $title;
    fclose($handle);
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
    }
  }
}

