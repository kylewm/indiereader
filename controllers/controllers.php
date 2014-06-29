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

    $app->get('/test', function($format = 'html') use ($app) {
        $res = $app->response();

        $url = 'http://notenoughneon.com/p/201406032340';
        $entry = new Microformat\Entry();
        $entry->loadFromUrl($url, $url);
        ob_start();
        render('test', array(
            'entry'       => $entry,
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

