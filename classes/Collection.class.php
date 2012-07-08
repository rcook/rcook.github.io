<?php

final class Article {
  private $id;
  private $title;

  public final function __construct($id, $title) {
    $this->id = $id;
    $this->title = $title;
  }

  public final function getId() {
    return $this->id;
  }

  public final function getTitle() {
    return $this->title;
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
          $metadata = self::getMetadata($id);
          $this->articles[$id] = new Article($id, $metadata['title']);
        }
      }
      closedir($handle);
    }
  }

  private static function getMetadata($id) {
    $metadata = array();
    $handle = fopen(realpath(__DIR__ . '/../content/' . sprintf('kb%03d', $id) . '/metadata.txt'), 'rt');
    $title = fgets($handle);
    $metadata['title'] = $title;
    fclose($handle);
    return $metadata;
  }
}

