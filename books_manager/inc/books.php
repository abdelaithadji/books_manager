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

/*******************************************************
 * @function bm_save_book
 * @action write $_POST data to xml file
 */
function bm_save_book() {
  # create a backup if necessary
  if (isset($_POST['current-slug'])) {
    $file = $_POST['current-slug'] . '.xml';
    @rename(BMBOOKPATH . $file, BMBACKUPPATH . $file);
  }
  # empty titles are not allowed
  if (empty($_POST['book-title']))
    $_POST['book-title'] = '[No Title]';
  # set initial slug and filename
  if (!empty($_POST['book-slug']))
    $slug = bm_create_slug($_POST['book-slug']);
  else
    $slug = bm_create_slug($_POST['book-title']);
  $file = BMBOOKPATH . "$slug.xml";
  # do not overwrite other books
  if (file_exists($file)) {
    $count = 1;
    $file = BMBOOKPATH . "$slug-$count.xml";
    while (file_exists($file))
      $file = BMBOOKPATH . "$slug-" . ++$count . '.xml';
    $slug = basename($file, '.xml');
  }
  # create undo target if there's a backup available
  if (isset($_POST['current-slug']))
    $backup = $slug . ':' . $_POST['current-slug'];
  # collect $_POST data
  
  $title     = safe_slash_html($_POST['book-title']);
  $timestamp = strtotime($_POST['book-date'] . ' ' . $_POST['book-time']);
  $date      = $timestamp ? date('r', $timestamp) : date('r');
  $tags      = str_replace(array(' ', ',,'), array('', ','), safe_slash_html($_POST['book-tags']));
  $private   = isset($_POST['book-private']) ? 'Y' : '';
  $content   = safe_slash_html($_POST['book-content']);
  # create xml object
  $xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');
  $obj = $xml->addChild('title');
  $obj->addCData($title);
  $obj = $xml->addChild('date');
  $obj->addCData($date);
  $obj = $xml->addChild('tags');
  $obj->addCData($tags);
  $obj = $xml->addChild('private');
  $obj->addCData($private);
  $obj = $xml->addChild('content');
  $obj->addCData($content);
  # write data to file
  if (@XMLsave($xml, $file) && bm_update_cache())
   bm_display_message(i18n_r('books_manager/SUCCESS_SAVE'), false, @$backup);
    
  else
    bm_display_message(i18n_r('books_manager/SUCCESS_SAVE'), false, @$backup);
    
}




/*******************************************************
 * @function bm_delete_book
 * @param $slug - book slug
 * @action deletes the requested book
 */
function bm_delete_book($slug) {
  
  $file = "$slug.xml";
  if (file_exists(BMBOOKPATH . $file)) {
    if (rename(BMBOOKPATH . $file, BMBACKUPPATH . $file) && bm_update_cache())
      bm_display_message(i18n_r('books_manager/SUCCESS_DELETE'), false, $slug);
    else
      bm_display_message(i18n_r('books_manager/ERROR_DELETE'), true);
  }
}


/*******************************************************
 * @function bm_restore_book
 * @param $target - string containing target(s)
 * @action restores a backup of the requested book
 */
function bm_restore_book($backup) {
  if (strpos($backup, ':')) {
    # revert to the previous version of a book
    list($current, $backup) = explode(':', $backup);
    $current .= '.xml';
    $backup .= '.xml';
    if (file_exists(BMBOOKPATH . $current) && file_exists(BMBACKUPPATH . $backup))
      $status = unlink(BMBOOKPATH . $current) &&
                rename(BMBACKUPPATH . $backup, BMBOOKPATH . $backup) &&
                bm_update_cache();
  } else {
    # restore the deleted book
    $backup .= '.xml';
    if (file_exists(BMBACKUPPATH . $backup))
      $status = rename(BMBACKUPPATH . $backup, BMBOOKPATH . $backup) &&
                bm_update_cache();
  }
  if (@$status)
    bm_display_message(i18n_r('books_manager/SUCCESS_RESTORE'));
  else
    bm_display_message(i18n_r('books_manager/ERROR_RESTORE'), true);
}


?>
