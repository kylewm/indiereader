<?php


$app->get('/settings/?', function($format = 'html') use ($app) {
  if($user=require_login($app)) {
    $res = $app->response();

    ob_start();
    render('settings', array(
        'title'       => 'Settings',
        'meta'        => '',
        'subscriptions_url' => $user->subscriptions_url
    ));
    $html = ob_get_clean();
    $res->body($html);
  } else {
    $app->redirect('/', 301);
  }
});

$app->post('/settings/save', function() use($app) {
  if($user=require_login($app)) {
    $params = $app->request()->params();

    $user->subscriptions_url = $params['subscriptions_url'];
    $user->save();

    $app->response()->body(json_encode(array(
      'result' => 'ok'
    )));
  } else {
    $app->response()->body(json_encode(array(
      'error' => 'unauthorized'
    )));
  }
});

