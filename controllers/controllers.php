<?php

$app->get('/', function($format='html') use($app) {
  $res = $app->response();


  ob_start();
  render('index', array(
    'title' => 'IndieReader',
    'meta' => ''
  ));
  $html = ob_get_clean();
  $res->body($html);
});