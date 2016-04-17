#!/usr/bin/php
<?php

require __DIR__ . '/vendor/autoload.php';

$loop   = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http   = new React\Http\Server($socket);

/**
 * @var $request \React\Http\Request
 * @var $response \React\Http\Response
 */
$http->on('request', function ($request, $response) {
    $resp = ReactOAuth\ReactOAuth::handle($request);

    $response->writeHead($resp->getStatusCode(), $resp->getHeaders());
    $response->end($resp->getBody());
});

$socket->listen(1337);
$loop->run();