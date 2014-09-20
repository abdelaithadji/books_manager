<?php

/**
 * Books Manager English language file by Abdellah Ait hadji
 */


$i18n = array(

# general
"PLUGIN_NAME"         =>  "Books Manager",

# error messages
"ERROR_ENV"           =>  "There was an error accessing the data folders. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",
"ERROR_SAVE"          =>  "<b>Error:</b> Unable to save your changes. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",
"ERROR_DELETE"        =>  "<b>Error:</b> Unable to delete the book. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",
"ERROR_RESTORE"       =>  "<b>Error:</b> Unable to restore the book. <em>CHMOD 777</em> the folders /data, /backups and their sub-folders and retry.",

# success messages
"SUCCESS_SAVE"        =>  "Your changes have been saved.",
"SUCCESS_DELETE"      =>  "The book has been deleted.",
"SUCCESS_RESTORE"     =>  "The book has been restored.",

# other messages
"UPDATE_HTACCESS"     =>  "<b>Note:</b> You probably have to update your <a href=\"load.php?id=news_manager&htaccess\">.htaccess</a> file!",

# admin button (top-right)
"SETTINGS"            =>  "Settings",
"NEW_BOOK"            =>  "Create New Book",

# admin panel
"BOOK_TITLE"          =>  "Book Title",
"DATE"                =>  "Date",
"EDIT_BOOK"           =>  "Edit Book",
"VIEW_BOOK"           =>  "View Book",
"DELETE_BOOK"         =>  "Delete Book",
"BOOKS"               =>  "book(s)",

# edit settings
"BM_SETTINGS"         =>  "Books Manager Settings",
"DOCUMENTATION"       =>  "For more information on these settings, visit the <a href=\"#\" target=\"_blank\">documentation page</a>.",
"PAGE_URL"            =>  "Page to display books",
"LANGUAGE"            =>  "Language used on News Page",
"SHOW_BOOKS_AS"       =>  "Books on News Page are shown as",
"FULL_TEXT"           =>  "Full Text",
"EXCERPT"             =>  "Excerpt",
"PRETTY_URLS"         =>  "Use Fancy URLs for books, archives, etc.",
"PRETTY_URLS_NOTE"    =>  "If you have Fancy URLs enabled, you might have to update your .htaccess file after saving these settings.",
"EXCERPT_LENGTH"      =>  "Excerpt length (characters)",
"BOOKS_PER_PAGE"      =>  "Number of books on News Page",
"RECENT_BOOKS"        =>  "Number of recent books (in sidebar)",

# edit post
"BOOK_OPTIONS"        =>  "Post Options",
"BOOK_SLUG"           =>  "Slug/URL",
"BOOK_TAGS"           =>  "Tags (separate tags with commas)",
"BOOK_DATE"           =>  "Publish date (<i>mm/dd/yyyy</i>)",
"BOOK_TIME"           =>  "Publish time (<i>hh:mm</i>)",
"BOOK_PRIVATE"        =>  "Book is private",
"LAST_SAVED"          =>  "Last Saved",

# htaccess
"HTACCESS_HELP"       =>  "To enable Fancy URLs for books, archives, etc., replace the contents of your <code>.htaccess</code> file with the lines below.",
"GO_BACK_WHEN_DONE"   =>  "When you are done with this page, click the button below to go back to the main panel.",

# save/cancel/delete
"SAVE_SETTINGS"       =>  "Save Settings",
"SAVE_BOOK"           =>  "Save Book",
"FINISHED"            =>  "Finished",
"CANCEL"              =>  "Cancel",
"DELETE"              =>  "Delete",
"OR"                  =>  "or",

# front-end/site
"FOUND"               =>  "The following books have been found:",
"NOT_FOUND"           =>  "Sorry, your search returned no hits.",
"NOT_EXIST"           =>  "The requested book does not exist.",
"NO_POSTS"            =>  "No books have been found.",
"PUBLISHED"           =>  "Published on",
"TAGS"                =>  "Tags",
"OLDER_BOOKS"         =>  "Older Books",
"NEWER_BOOKS"         =>  "Newer Books",
"SEARCH"              =>  "Search",
"GO_BACK"             =>  "Go back to the previous page",

# date settings
"DATE_FORMAT"         =>  "%b %e, %Y"

);

?>
