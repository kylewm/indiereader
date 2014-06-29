<?php

    $app->get('/', function ($format = 'html') use ($app) {
        $res = $app->response();

        ob_start();
        render('index', array(
            'title'       => 'IndieReader',
            'meta'        => '',
            'authorizing' => false
        ));
        $html = ob_get_clean();
        $res->body($html);
    });

    $app->get('/settings/?', function($format = 'html') use ($app) {

        $res = $app->response();

        ob_start();
        render('settings', array(
            'title'       => 'Settings',
            'meta'        => '',
            'authorizing' => false
        ));
        $html = ob_get_clean();
        $res->body($html);

    });

