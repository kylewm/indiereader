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

    $app->get('/docs/?', function($format = 'html') use ($app) {

        $res = $app->response();

        ob_start();
        render('docs', array(
            'title'       => 'Docs',
            'meta'        => '',
            'authorizing' => false
        ));
        $html = ob_get_clean();
        $res->body($html);

    });

