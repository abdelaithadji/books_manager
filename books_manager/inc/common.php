<?php

/**
 * Common variables used by the GetSimple News Manager Plugin.
 */


# path definitions
define('BMBOOKPATH', GSDATAPATH  . 'books/');
define('BMBACKUPPATH', GSBACKUPSPATH  . 'books/');
define('BMDATAPATH', GSDATAOTHERPATH  . 'books_manager/');
define('BMINCPATH', GSPLUGINPATH . 'books_manager/inc/');
define('BMLANGPATH', GSPLUGINPATH . 'books_manager/lang/');
define('BMTEMPLATEPATH', GSPLUGINPATH . 'books_manager/template/');


# file definitions
define('BMSETTINGS', BMDATAPATH . 'settings.xml');
define('BMBOOKCACHE', BMDATAPATH . 'books.xml');


# includes
require_once(BMINCPATH . 'functions.php');
require_once(BMINCPATH . 'settings.php');
require_once(BMINCPATH . 'cache.php');
require_once(BMINCPATH . 'admin.php');
require_once(BMINCPATH . 'books.php');
require_once(BMINCPATH . 'site.php');
require_once(BMINCPATH . 'sidebar.php');


# load settings
$data = @getXML(BMSETTINGS);
$BMPAGEURL       = isset($data->page_url) ? $data->page_url : 'index';
$BMPRETTYURLS    = isset($data->pretty_urls) ? $data->pretty_urls : '';
$BMLANG          = isset($data->language) ? $data->language : 'en_US';
$BMSHOWEXCERPT   = isset($data->show_excerpt) ? $data->show_excerpt : '';
$BMEXCERPTLENGTH = isset($data->excerpt_length) ? $data->excerpt_length : '350';
$BMBOOKSPERPAGE  = isset($data->books_per_page) ? $data->books_per_page : '8';
$BMRECENTBOOKS   = isset($data->recent_books) ? $data->recent_books : '5';


?>
