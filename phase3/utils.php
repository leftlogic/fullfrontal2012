<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once(ROOT . '/mustache.php');
require_once(ROOT . '/markdown.php');
$mustache = new Mustache;

// $mustache->addHelper('_markdown', function($text) {
//     return Markdown($text);
// });

$cache = array();

function convertMarkdown(&$array) {
  // Credit: http://www.php.net/manual/en/function.array-walk.php#71901
  // var_dump($array);
  foreach ($array as $key => $value) {
    if (is_array($value)) {
      $res[$key] = convertMarkdown($value);
    } else {
      $a = explode('_', $key);
      if (array_pop($a) == 'md') {
        $res[$key] = Markdown($value);
      } else {
        $res[$key] = $value;
      }
    }
  }
  return $res;
}

function renderTemplate($data, $template) {
  global $mustache;
  // TODO validate the file exists - and error handle properly
  if (!isset($cache[$template])) {
    $cache[$template] = file_get_contents(ROOT . $template);
  }

  if (is_string($data)) {
    $data = convertMarkdown(json_decode(file_get_contents(ROOT . $data), true));
  }

  $render = $mustache->render($cache[$template], $data);
  return $render;
}
?>
