<?php

<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Books Manager book management functions.
 */


/*******************************************************
 * @function bm_edit_book
 * @param $slug - book slug
 * @action edit or create books
 */
function bm_edit_book($slug) {
  $file = BMBOOKPATH . "$slug.xml";
  # get book data, if it exists
  $data    = @getXML($file);
  $title   = @stripslashes($data->title);
  $date    = !empty($data) ? date('m/d/Y', strtotime($data->date)) : '';
  $time    = !empty($data) ? date('H:i', strtotime($data->date)) : '';
  $tags    = @str_replace(',', ', ', ($data->tags));
  $private = @$data->private != '' ? 'checked' : '';
  $content = @stripslashes($data->content);
  # show edit book form
  include(BMTEMPLATEPATH . 'edit_book.php');
  if (file_exists($file)) {
    $mtime = date(i18n_r('DATE_AND_TIME_FORMAT'), filemtime($file));
    echo '<small>' . i18n_r('books_manager/LAST_SAVED') . ": $mtime</small>";
  }
  include(BMTEMPLATEPATH . 'ckeditor.php');
}
?>


?>