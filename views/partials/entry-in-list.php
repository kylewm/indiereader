<div class="entry" id="entry_<?= $this->post_id ?>">
  <div class="minicard author">
    <div style="position: relative; width: 48px; height: 48px; float: left; margin-right: 6px;">
      <img class="author_photo" src="<?= $this->author_photo ?>" alt="<?= $this->author_name ?>" width="48">
    </div>
    <a href="<?= $this->author_url ?>" class="author_url"><?= friendly_url($this->author_url) ?></a>
    <a href="<?= $this->author_url ?>" class="author_name"><?= $this->author_name ?></a>
  </div>
  <div class="content"><?= $this->content ?></div>
  <div class="actions">
    <a href="#" class="bookmark" data-post-id="<?= $this->post_id ?>" data-url="<?= $this->url ?>"><i class="fa fa-star"></i> Bookmark</a>
    <a href="#" class="reply" data-post-id="<?= $this->post_id ?>" data-url="<?= $this->url ?>"><i class="fa fa-mail-reply"></i> Reply</a>
  </div>
  <div class="meta">
    <a href="<?= $this->url ?>" class="url"><?= date('l, M j, Y g:ia', strtotime($this->published)) ?></a>
  </div>
  <div class="status"></div>
</div>