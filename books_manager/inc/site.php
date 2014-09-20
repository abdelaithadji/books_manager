<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Books Manager front-end functions.
 */


/*******************************************************
 * @function bm_show_page
 * param $index - page index (pagination)
 * @action show books on news page
 */
function bm_show_page($index=0) {
  global $BMBOOKSPERPAGE, $BMSHOWEXCERPT;
  $books = bm_get_books();
  $pages = array_chunk($books, intval($BMBOOKSPERPAGE), true);
  if (is_numeric($index) && $index >= 0 && $index < sizeof($pages))
    $books = $pages[$index];
  else
    $books = array();
  if (!empty($books)) {
    foreach ($books as $book)
      bm_show_book($book->slug, $BMSHOWEXCERPT == 'Y');
    if (sizeof($pages) > 1)
      bm_show_navigation($index, sizeof($pages));
  } else {
    echo '<p>' . i18n_r('books_manager/NO_BOOKS') . '</p>';
    
  }
}



/*******************************************************
 * @function bm_show_book
 * param $slug book slug
 * param $excerpt - if TRUE, print only a short summary
 * @action show the requested book on front-end news page
 */
function bm_show_book($slug, $excerpt=false) {
  $file = BMBOOKPATH . "$slug.xml";
  $book = @getXML($file);
  if (!empty($book) && $book->private != 'Y') {
    $url     = bm_get_url('book') . $slug;
    $title   = strip_tags(strip_decode($book->title));
    $date    = bm_get_date(i18n_r('books_manager/DATE_FORMAT'), strtotime($book->date));
    $content = strip_decode($book->content);
    if ($excerpt) $content = bm_create_excerpt($content);
    # print book data ?>
    <div class="bm_book">
      <h3 class="bm_book_title">
        <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
      </h3>
      <!--<p class="bm_book_date"><?php //echo i18n_r('news_manager/PUBLISHED') . " $date"; ?></p>-->
      <p class="bm_book_date"><?php echo 'books_manager' . " $date"; ?></p>
      <div class="bm_book_content"><?php echo $content; ?></div>
      <?php
      # print tags, if any
      if (!empty($book->tags)) {
       // echo '<p class="bm_book_meta"><b>' . i18n_r('news_manager/TAGS') . ':</b>';
        echo '<p class="bm_book_meta"><b>' .'books_manager'. ':</b>';
        $tags = explode(',', $book->tags);
        foreach ($tags as $tag) {
          $url = bm_get_url('tag') . $tag;
          echo " <a href=\"$url\">$tag</a>";
        }
        echo '</p>';
      }
      # show "go back" link, if required
      if (strstr($_SERVER['QUERY_STRING'], "book=$slug")) {
        echo '<p class="bm_book_back"><a href="javascript:history.back()">&lt;&lt; ';
        //i18n('news_manager/GO_BACK');
        'books_manager';
        echo '</a></p>';
      }
      ?>
    </div>
    <?php
  } else {
    //echo '<p>' . i18n_r('news_manager/NOT_EXIST') . '</p>';
    echo '<p>' . 'books_manager' . '</p>';
  }
}

/*******************************************************
 * @function bm_show_tag
 * param $id - unique tag id
 * @action show books by tag
 */
function bm_show_tag($tag) {
  $tags = bm_get_tags();
  $books = $tags[$tag];
  foreach ($books as $slug)
    bm_show_book($slug, true);
}


/*******************************************************
 * @function bm_show_navigation
 * param $index - current page index
 * param $total - total number of subpages
 * @action provides links to navigate between subpages
 */
function bm_show_navigation($index, $total) {
  $url = bm_get_url('page');
  echo '<div class="bm_page_nav">';
  if ($index < $total - 1) {
    ?>
    <div class="left">
      <a href="<?php echo $url . ($index+1); ?>">

        &larr;<?php i18n('books_manager/OLDER_BOOKS'); ?>
        
      </a>
    </div>
    <?php
  }
  if ($index > 0) {
    ?>
    <div class="right">
      <a href="<?php echo ($index > 1) ? $url . ($index-1) : substr($url, 0, -6); ?>">
        <?php i18n('books_manager/NEWER_BOOKS'); ?>&rarr;
       
      </a>
    </div>
    <?php
  }
  echo '</div>';
}

?>