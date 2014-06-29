<div class="narrow">

<?= partial('partials/header') ?>

  <h2>Creating the Subscription List</h2>


  <pre><?= htmlspecialchars(<<<'EOT'
<div class="h-feed">
  <h2 class="p-name">Subscription</h2>
  <ul>
    <li class="h-entry">
      <a href="http://aaronparecki.com/" class="u-feed">Aaron Parecki</a>
    </li>
    <li class="h-entry">
      <a href="http://werd.io/" class="u-feed">Ben Werdmüller</a>
    </li>
    <li class="h-entry">
      <a href="http://waterpigs.co.uk/" class="u-feed">Barnaby Walters</a>
    </li>
    <li class="h-entry">
      <a href="http://tantek.com/" class="u-feed">Tantek Çelik</a>
    </li>
    <li class="h-entry">
      <a href="http://notenoughneon.com/" class="u-feed">Emma Kuo</a>
    </li>
  </ul>
</div>
EOT
) ?></pre>

</div>