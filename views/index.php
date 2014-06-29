<div class="narrow">
  <?= partial('partials/header') ?>

<?php
foreach($this->entries as $entry) {
  echo partial('partials/entry-in-list', [
    'post_id' => $entry->id,
    'author_name' => $entry->author_name,
    'author_url' => $entry->author_url,
    'author_photo' => $entry->author_photo,
    'url' => $entry->url,
    'published' => $entry->published,
    'content' => $entry->content,
  ]);
}

?>
</div>
<script type="text/javascript">
$(function(){
  $('.entry .bookmark').click(function(){
    var post_id = $(this).data('post-id');

    $.post("/micropub/post", {
      post_id: post_id,
      h: 'entry',
      'bookmark-of': $(this).data('url')
    }, function(data) { 
      console.log(data);
      if(data.location) {
        $("#entry_"+post_id+" .status").html('<div class="bs-callout bs-callout-success"><a href="'+data.location+'">Bookmarked!</a></div>');
      } else {
        $("#entry_"+post_id+" .status").html('<div class="bs-callout bs-callout-danger">There was a problem! Your Micropub endpoint returned: <pre>'+data.response+'</pre></div>');
      }
    });
    return false;
  });

  $('.entry .reply').click(function(){
    var post_id = $(this).data('post-id');
    $("#entry_"+post_id+" .status").html('<textarea class="reply-content form-control" style="height: 4em;"></textarea><br><input type="button" value="Reply" class="btn btn-success save" data-post-id="'+post_id+'">');
    $("#entry_"+post_id+" .status textarea").focus();
    bind_reply();
  });

});

function bind_reply() {
  $('.entry .save').unbind('click').click(function(){
    var post_id = $(this).data('post-id');

    $.post("/micropub/post", {
      post_id: post_id,
      h: 'entry',
      'in-reply-to': $(this).data('url'),
      content: $("#entry_"+post_id+" .reply-content").val()
    }, function(data) { 
      if(data.location) {
        $("#entry_"+data.post_id+" .status").html('<div class="bs-callout bs-callout-success"><a href="'+data.location+'">Bookmarked!</a></div>');
      } else {
        $("#entry_"+data.post_id+" .status").html('<div class="bs-callout bs-callout-danger">There was a problem! Your Micropub endpoint returned: <pre>'+data.response+'</pre></div>');
      }
    });
    return false;
  });
}
</script>