<div class="narrow">

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

    $.post("/micropub/bookmark", {
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

  });
});
</script>