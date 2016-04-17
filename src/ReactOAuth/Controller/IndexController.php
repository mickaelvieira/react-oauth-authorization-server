<?php

namespace ReactOAuth\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class IndexController
 */
final class IndexController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write('<h1>Hello, World!</h1>');
        
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function auth(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write('<h1>Trying to authenticate?</h1>');
        return $response;
    }
}
