<?php

    $app->get('/', function ($format = 'html') use ($app) {
        $res = $app->response();

        ob_start();
        render('index', array(
            'title'       => 'IndieReader',
            'meta'        => '',
        ));
        $html = ob_get_clean();
        $res->body($html);
    });

    $app->get('/test', function($format = 'html') use ($app) {
        $res = $app->response();

        $entry = new Microformat\Entry();
        $entry->loadFromUrl('http://notenoughneon.com/p/201406032340');
        ob_start();
        render('test', array(
            'title'       => 'Test',
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
        ));
        $html = ob_get_clean();
        $res->body($html);

    });

