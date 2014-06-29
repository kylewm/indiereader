<div class="<? echo $this->getRootClass() ?>">
    <div class="blog-post">
<? if ($this->isArticle()) { ?>
        <h2 class="blog-post-title p-name"><? echo $this->name ?></h2>
<? } ?>
<? require("meta.php") ?>
        <div class="<? echo $this->getContentClass() ?>"><? echo $this->contentHtml ?></div>
    </div>
</div>

