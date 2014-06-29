<div class="narrow">

<?php
foreach($this->entries as $entry) {
  echo partial('partials/entry-in-list', [
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
    $.post("/micropub/bookmark", {
      h: 'entry',
      'bookmark-of': $(this).data('url')
    }, function(data) { 
      console.log(data);
    });
  });
  $('.entry .reply').click(function(){

  });
});
</script>