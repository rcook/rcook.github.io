<?php

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

