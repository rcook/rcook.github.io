<?php

final class ClassAutoloader {
  private $dirs;

  public final function __construct($dirs) {
    $this->rootDir = realpath(__DIR__ . '/..');
    $this->dirs = $dirs;
    spl_autoload_register(array($this, 'loadClass'));
  }

  private final function loadClass($className) {
    $classRelativePath = str_replace('\\', '/', $className);
    foreach ($this->dirs as $dir) {
      $classPath = realpath("$this->rootDir/$dir/$classRelativePath.class.php");
      if ($classPath !== false) {
        require_once $classPath;
        break;
      }
    }
  }
}
