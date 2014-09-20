<?php
/*
Plugin Name: Hello World
Description: Echos "Hello World" in footer of theme
Version: 1.0
Author: Chris Cagle
Author URI: http://www.cagintranet.com/
*/
 
# get correct id for plugin
$thisfile=basename(__FILE__, ".php");
 
# register plugin
register_plugin(
	$thisfile, //Plugin id
	'Books Manager', 	//Plugin name
	'1.0', 		//Plugin version
	'Abdellah Ait Hadji',  //Plugin author
	'http://www.abdelaithadji.com/', //author website
	'Finds email addresses in content and components and "hides" them', //Plugin description
	'pages', //page type - on which admin tab to display
	'bm_admin'  //main function (administration)
);
 
# hooks
add_filter('content', 'bm_show');
 
# add a link in the admin tab 'theme'
add_action('pages-sidebar', 'createSideMenu', array($thisfile, 'Books Manager')); 

# includes
require_once('books_manager/inc/common.php');

# language
i18n_merge('books_manager') || i18n_merge('books_manager', 'en_US');

# functions
function bm_admin() {
  
	 if (nm_env_check()) {
    # book management
    if (isset($_GET['edit'])) {
      
      bm_edit_book($_GET['edit']);
    } elseif (isset($_POST['book'])) {
      bm_save_book();
      bm_admin_panel();
    } elseif (isset($_GET['delete'])) {

      bm_delete_book($_GET['delete']);
      bm_admin_panel();
    } elseif (isset($_GET['restore'])) {
      bm_restore_book($_GET['restore']);
      bm_admin_panel();
    # settings management
    } elseif (isset($_GET['settings'])) {
      bm_edit_settings();
    } elseif (isset($_POST['settings'])) {
      bm_save_settings();
      bm_admin_panel();
    } elseif (isset($_GET['htaccess'])) {
      bm_generate_htaccess();
    } else {
      bm_admin_panel();
    }
  }
}
 
function bm_show() {
	global $BMPAGEURL;
	$url = strval(get_page_slug(false));
    if ($url == $BMPAGEURL) {
     	 $content = '';
	    if (isset($_GET['page'])) {
	      $index = $_GET['page'];
	      bm_show_page($index);
	    } else {
	      bm_show_page();
	    }
   }
   return $content;
	//echo '<p>I like to echo "Hello World" in the footers of all themes.</p>';
}
?>