<div class="narrow">

  <?= partial('partials/header') ?>

  <h2>Subscription List</h2>
  <p>Enter the URL to your list of subscriptions. This should be a page on your website marked up with the <a href="/docs">proper microformats</a>.</p>

  <form class="form-inline" role="form" id="subscription_form">
    <div class="form-group">
      <label class="sr-only" for="subscriptions_url">Subscription List</label>
        <input value="<?= $this->subscriptions_url ?>" type="url" class="form-control" id="subscriptions_url" placeholder="URL to your Subscription List">
    </div>
    <button type="button" class="btn btn-default" id="subscription_save">Save</button>
  </form>

  <div id="results">

  </div>

</div>
<script type="text/javascript">
$(function(){
  $("#subscription_save").click(function(){
    $.post("/settings/save", {
      subscriptions_url: $("#subscriptions_url").val()
    }, function(data){
      console.log(data);
    });
  });
});
</script>