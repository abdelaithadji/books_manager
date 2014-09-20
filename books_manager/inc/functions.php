<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Books Manager general functions.
 */

/*******************************************************
 * @function bm_get_books
 * @param $all if true, include private and future books
 * @return array with books
 */


function bm_get_books($all=false) {

  $now = time();
  $books = array();
  $data = @getXML(BMBOOKCACHE);
  
  
  foreach ($data->item as $item) {
    if ($all || $item->private != 'Y' && strtotime($item->date) < $now)
      $books[] = $item;
  }
  return $books;
}



/*******************************************************
 * @function bm_get_url
 * @return url of front-end bookspage, with optional query
 */
function bm_get_url($query=false) {
  global $SITEURL, $PRETTYURLS, $BMPAGEURL, $BMPRETTYURLS;
  $data = getXML(GSDATAPAGESPATH . $BMPAGEURL . '.xml');
  $url = find_url($BMPAGEURL, $data->parent);
  if ($query) {
    if ($PRETTYURLS == 1 && $BMPRETTYURLS == 'Y')
      $url .= $query . '/';
    elseif ($BMPAGEURL == 'index')
      $url = $SITEURL . "index.php?$query=";
    else
      $url = $SITEURL . "index.php?id=$BMPAGEURL&$query=";
  }
  return $url;
}


/*******************************************************
 * @function bm_create_slug
 * @param $str string
 * @return a url friendly version of $str
 */
function bm_create_slug($str) {
  $str = to7bit($str, 'UTF-8');
  $str = clean_url($str);
  return $str;
}

/*******************************************************
 * @function bm_get_archives
 * @return array with monthly archives (keys) and books (values)
 */
function bm_get_archives() {
  $archives = array();
  $books = bm_get_books();
  foreach ($books as $book) {
    $archive = date('Ym', strtotime($book->date));
    $archives[$archive][] = $book->slug;
  }
  return $archives;
}


/*******************************************************
 * @function bm_get_tags
 * @return array with unique tags (keys) and books (values)
 */
function bm_get_tags() {
  $tags = array();
  $books = bm_get_books();
  foreach ($books as $book) {
    if (!empty($book->tags)) {
      foreach (explode(',', $book->tags) as $tag)
        $tags[$tag][] = $book->slug;
    }
  }
  ksort($tags);
  return $tags;
}


/*******************************************************
 * @function nm_get_languages
 * @return array with language files in NMLANGPATH
 */
function bm_get_languages() {
  $languages = array();
  $files = getFiles(BMLANGPATH);
  foreach ($files as $file) {
    if (isFile($file, BMLANGPATH, 'php')) {
      $lang = basename($file, '.php');
      $languages[$lang] = BMLANGPATH . $file;
    }
  }
  ksort($languages);
  return $languages;
}


/*******************************************************
 * @function bm_get_date
 * @param $format date format
 * @param $timestamp UNIX timestamp
 * @return date formatted according to $NNLANG
 */
function bm_get_date($format, $timestamp) {
  global $BMLANG;
  $locale = setlocale(LC_TIME, null);
  setlocale(LC_TIME, $BMLANG);
  $date = strftime($format, $timestamp);
  setlocale(LC_TIME, $locale);
  return $date;
}


/*******************************************************
 * @function bm_create_dir
 * @param $path full path of the directory
 * @action create the directory $path
 */
function bm_create_dir($path) {
  if (mkdir($path, 0777)) {
    $fh = fopen($path . '.htaccess', 'w');
    fwrite($fh, 'Deny from all');
    fclose($fh);
    return true;
  }
  return false;
}


/*******************************************************
 * @function bm_create_excerpt
 * @param $content the book content
 * @return a truncated version of the book content
 */
function bm_create_excerpt($content) {
  global $BMEXCERPTLENGTH;
  $len = intval($BMEXCERPTLENGTH);
  $content = strip_tags($content);
  if (strlen($content) > $len) {
    if (function_exists('mb_substr'))
      $content = trim(mb_substr($content, 0, $len, 'UTF-8')) . ' [...]';
    else
      $content = trim(substr($content, 0, $len)) . ' [...]';
  }
  return "<p>$content</p>";
}


/*******************************************************
 * @function nm_i18n_merge
 * @action update the $i18n language array
 */
function bm_i18n_merge() {
  global $BMLANG;
  if (isset($BMLANG) && $BMLANG != '') {
    include(BMLANGPATH . "$BMLANG.php");
    $nm_i18n = $i18n;
    global $i18n;
    foreach ($bm_i18n as $code=>$text)
      $i18n['books_manager/' . $code] = $text;
  }
}


/*******************************************************
 * @function bm_sitemap_include
 * @action add books to sitemap.xml
 */
function bm_sitemap_include() {
  global $BMPAGEURL, $page, $xml;
  if (strval($page['url']) == $BMPAGEURL) {
    $books = bm_get_books();
    foreach ($books as $book) {
      $url = bm_get_url('book') . $book->slug;
      $file = BMBOOKPATH . "$book->slug.xml";
      $date = makeIso8601TimeStamp(date("Y-m-d H:i:s", filemtime($file)));
      $item = $xml->addChild('url');
      $item->addChild('loc', $url);
      $item->addChild('lastmod', $date);
      $item->addChild('changefreq', 'monthly');
      $item->addChild('priority', '0.5');
    }
  }
}


/*******************************************************
 * @function bm_header_include
 * @action insert necessary script/style sections into site header
 */
function bm_header_include() {
  ?>
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
  <style>
    .invalid {
      color: #D94136;
      font-size: 11px;
      font-weight: normal;
    }
  </style>
  <?php
}


/*******************************************************
 * @function bm_display_message
 * @param $msg a string containing the message
 * @param $error if true, show as $msg as error, else as update
 * @param $backup when set, include undo link
 * @action display status messages on back-end pages
 */
function bm_display_message($msg, $error=false, $backup=null) {
  if (isset($msg)) {
    
    if (isset($backup))
      $msg .= " <a href=\"load.php?id=books_manager&restore=$backup\">" . i18n_r('UNDO') . '</a>';
    ?>
    <script type="text/javascript">
      $(function() {
        $('div.bodycontent').before('<div class="<?php echo $error ? 'error' : 'updated'; ?>" style="display:block;">'+
          <?php echo json_encode($msg); ?>+'</div>');
        $(".updated, .error").fadeOut(500).fadeIn(500);
      });
    </script>
    <?php
  }
}

?>