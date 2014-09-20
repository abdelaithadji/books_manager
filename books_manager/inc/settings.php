<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Books Manager configuration functions.
 */


/*******************************************************
 * @function bm_env_check
 * @action check plugin environment
 */
function bm_env_check() {
  $env_ok = file_exists(NMBOOKPATH) || bm_create_dir(BMBOOKPATH);
  if ($env_ok && !file_exists(BMBACKUPPATH))
    $env_ok = bm_create_dir(BMBACKUPPATH);
  if ($env_ok && !file_exists(BMDATAPATH)) {
    if ($env_ok = bm_create_dir(BMDATAPATH))
      bm_update_cache();
  }
  if (!$env_ok)
    //echo '<h3>Books Manager</h3><p>' . i18n_r('news_manager/ERROR_ENV') . '</p>';
    echo '<h3>Books Manager</h3><p>' . 'books_manager' . '</p>';
  return $env_ok;
}

/*******************************************************
 * @function bm_edit_settings
 * @action edit plugin configuration settings
 */
function bm_edit_settings() {
  global $PRETTYURLS, $BMPAGEURL, $BMPRETTYURLS, $BMLANG, $BMSHOWEXCERPT,
         $BMEXCERPTLENGTH, $BMBOOKSPERPAGE, $BMRECENTBOOKS;
  include(BMTEMPLATEPATH . 'edit_settings.php');
}