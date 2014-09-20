<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Optional sidebar functions for the GetSimple Books Manager Plugin.
 */


/*******************************************************
 * @function bm_list_recent
 * @action print a list with the latest books (titles only)
 */
function bm_list_recent() {
  global $BMRECENTBOOKS;
  $books = bm_get_books();
  if (!empty($books)) {
    echo '<ul>';
    $books = array_slice($books, 0, $BMRECENTBOOKS, true);
    foreach ($books as $book) {
      $url = bm_get_url('book') . $book->slug;
      $title = strip_tags(strip_decode($book->title));
      echo "<li><a href=\"$url\">$title</a></li>";
    }
    echo '</ul>';
  }
}


/*******************************************************
 * @function bm_list_archives
 * @action print a list of archives ordered by month
 */
function bm_list_archives() {
  $archives = array_keys(bm_get_archives());
  if (!empty($archives)) {
    echo '<ul>';
    foreach ($archives as $archive) {
      list($y, $m) = str_split($archive, 4);
      $title = bm_get_date('%B %Y', mktime(0, 0, 0, $m, 1, $y));
      $url = bm_get_url('archive') . $archive;
      echo "<li><a href=\"$url\">$title</a></li>";
    }
    echo '</ul>';
  }
}


/*******************************************************
 * @function bm_list_tags
 * @action print unique tags, popular tags are bigger.
 */
function bm_list_tags() {
  $tags = array();
  foreach (bm_get_tags() as $tag=>$books)
    $tags[$tag] = count($books);
  if (!empty($tags)) {
    $min = min($tags);
    $max = max($tags);
    foreach ($tags as $tag=>$count) {
      $url = bm_get_url('tag') . $tag;
      if ($min < $max && $count/$max > 0.5)
        echo "<a class=\"large\" href=\"$url\">$tag</a> ";
      else
        echo "<a href=\"$url\">$tag</a> ";
    }
  }
}


/*******************************************************
 * @function bm_search
 * @action provide form to search books by keyword(s)
 */
function bm_search() {
  $url = bm_get_url();
  ?>
  <form id="search" action="<?php echo $url; ?>" method="post">
    <input type="text" class="text" name="keywords" />
    <input type="submit" class="submit" name="search" value="<?php i18n('books_manager/SEARCH'); ?>" />
  </form>
  <?php
}


?>
