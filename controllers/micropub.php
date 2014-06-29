<?php

$app->post('/micropub/bookmark', function() use($app){
  if($user=require_login($app)) {
    $params = $app->request()->params();

    // Now send to the micropub endpoint
    $r = micropub_post($user->micropub_endpoint, $params, $user->micropub_access_token);
    $response = $r['response'];

    // Check the response and look for a "Location" header containing the URL
    if($response && preg_match('/Location: (.+)/', $response, $match)) {
      $location = $match[1];
      $user->micropub_success = 1;
    } else {
      $location = false;
    }

    $user->save();

    $app->response()['Content-Type'] = 'application/json';
    $app->response()->body(json_encode(array(
      'response' => htmlspecialchars($response),
      'location' => $location,
      'error' => $r['error'],
      'curlinfo' => $r['curlinfo']
    )));
  }
});

