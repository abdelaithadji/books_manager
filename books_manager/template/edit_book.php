<?php

/**
 * Books Manager edit book template
 */

?>

<h3 class="floated">
  <?php
  if (empty($data))
    i18n('books_manager/NEW_BOOK');
    
  else
    i18n('books_manager/EDIT_BOOK');
    
  ?>
</h3>
<div class="edit-nav" >
  <?php
  if (file_exists($file) && $private == '') {
    $url = bm_get_url('book') . $slug;
    ?>
    <a href="<?php echo $url; ?>" target="_blank">
      <?php i18n('books_manager/VIEW_BOOK'); ?>
     
    </a>
    <?php
  }
  ?>
  <a href="#" id="metadata_toggle">
   <?php i18n('books_manager/BOOK_OPTIONS'); ?>

  </a>
  <div class="clear"></div>
</div>
<form class="largeform" id="edit" action="load.php?id=books_manager" method="post" accept-charset="utf-8">
  <?php
  if (!empty($slug))
    echo "<p><input name=\"current-slug\" type=\"hidden\" value=\"$slug\" /></p>";
  ?>
  <p>
    <input class="text title required" name="book-title" id="book-title" type="text" value="<?php echo $title; ?>" placeholder="<?php i18n('books_manager/BOOK_TITLE'); ?>" />
  </p>
  <div style="display:none;" id="metadata_window">
    <div class="leftopt">
      <p>
        <label for="book-slug"><?php i18n('books_manager/BOOK_SLUG'); ?> :</label>
        <input class="text short" id="book-slug" name="book-slug" type="text" value="<?php echo $slug; ?>" />
      </p>
      <p>
        <label for="book-date"><?php i18n('books_manager/BOOK_DATE'); ?>:</label>
        <input class="text short" id="book-date" name="book-date" type="text" value="<?php echo $date; ?>" />
      </p>
      <p class="inline" id="book-private-wrap">
        <label for="book-private"><?php i18n('books_manager/BOOK_PRIVATE'); ?></label>
        &nbsp;&nbsp;
        <input type="checkbox" id="book-private" name="book-private" <?php echo $private; ?> />
      </p>
    </div>
    <div class="rightopt">
      <p>
        <label for="book-tags"><?php i18n('books_manager/BOOK_TAGS'); ?>:</label>
        <input class="text short" id="book-tags" name="book-tags" type="text" value="<?php echo $tags; ?>" />
      </p>
      <p>
        <label for="book-time"><?php i18n('books_manager/BOOK_TIME'); ?>:</label>
        <input class="text short" id="book-time" name="book-time" type="text" value="<?php echo $time; ?>" />
      </p>
    </div>
    <div class="clear"></div>
  </div>
  <p>
    <textarea name="book-content"><?php echo $content; ?></textarea>
  </p>
  <p>
    <input name="book" type="submit" class="submit" value="<?php i18n('books_manager/SAVE_BOOK'); ?>" />
    &nbsp;&nbsp;<?php 'books_manager' ?>&nbsp;&nbsp;
    <a href="load.php?id=books_manager&cancel" class="cancel"><?php i18n('books_manager/CANCEL'); ?></a>
    <?php
    if (file_exists($file)) {
      ?>
     
      <a href="load.php?id=books_manager&delete=<?php echo $slug; ?>" class="cancel">
        <?php i18n('books_manager/DELETE'); ?> <?php 'books_manager' ?>
      </a>
      <?php
    }
    ?>
  </p>
</form>

<script>
  $(document).ready(function(){
    $.validator.addMethod("time", function(value, element) {
        return this.optional(element) || /^([01]?[0-9]|2[0-3]):[0-5][0-9]/.test(value);
    },
    "Please enter a valid time.")

    $("#edit").validate({
      errorClass: "invalid",
      rules: {
        "book-date": { date: true },
        "book-time": { time: true }
      }
    })

    $("#book-title").focus();
  });
</script>
