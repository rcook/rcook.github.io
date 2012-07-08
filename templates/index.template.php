<?php

require_once realpath(__DIR__ . '/../classes/Collection.class.php');

$collection = new Collection;
$articles = $collection->getArticles();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Richard's KnowledgeBase</title>
</head>
<body>
<h1>Richard's KnowledgeBase</h1>
<?
if (count($articles) > 0) {
  echo '<ul>';
  foreach ($articles as $article) {
    echo '<li><a href="/' . sprintf('kb%03d', $article->getId()) . '">' . sprintf('KB%03d', $article->getId()) . '&mdash;' . htmlspecialchars($article->getTitle()) . '</a></li>';
  }
  echo '</ul>';
}
else {
  echo '<p>No articles.</p>';
}
?>
</body>
</html>

