<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Books Manager cache functions.
 */


/*******************************************************
 * @function bm_update_cache
 * @action store frequently accessed book data in cache files
 */
function bm_update_cache() {
  $books = bm_get_cache_data();
  
  return bm_cache_to_xml($books);

}


/*******************************************************
 * @function bm_get_cache_data
 * @return arrays with relevant book data
 */
function bm_get_cache_data() {
  $books = array();
  $files = getFiles(BMBOOKPATH);

  # collect all book data
  foreach ($files as $file) {
    if (isFile($file, BMBOOKPATH, 'xml')) {
      $data = getXML(BMBOOKPATH . $file);

      $time = strtotime($data->date);
      while (array_key_exists($time, $books)) $time++;

      $books[$time]['slug'] = basename($file, '.xml');
      $books[$time]['title'] = strval($data->title);
      $books[$time]['date'] = strval($data->date);
      $books[$time]['tags'] = strval($data->tags);
      $books[$time]['private'] = strval($data->private);

    }
  }

  krsort($books);
  return $books;

}


/*******************************************************
 * @function bm_cache_to_xml
 * @action write book data to xml file
 */
function bm_cache_to_xml($books) {

  $xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><channel></channel>');
  foreach ($books as $book) {
    $item = $xml->addChild('item');
    $elem = $item->addChild('slug');
    $elem->addCData($book['slug']);
    $elem = $item->addChild('title');
    $elem->addCData($book['title']);
    $elem = $item->addChild('date');
    $elem->addCData($book['date']);
    $elem = $item->addChild('tags');
    $elem->addCData($book['tags']);
    $elem = $item->addChild('private');
    $elem->addCData($book['private']);
  }
  
  return @XMLsave($xml, BMBOOKCACHE);

}




?>
