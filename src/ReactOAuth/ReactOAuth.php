<?php

namespace ReactOAuth;

use ReactOAuth\Controller;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

use React\Http\Request as ReactRequest;

use League\Route\RouteCollection;
use League\Route\Http\Exception as HttpException;

/**
 * Class ReactOAuth
 */
final class ReactOAuth
{
    /**
     * @param \React\Http\Request $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function handle(ReactRequest $request)
    {
        try {
            
            $router = new RouteCollection();
            $router->get('/', [new Controller\IndexController, 'index']);
            $router->get('/auth', [new Controller\IndexController, 'auth']);

            // Build PSR7 request
            // Diactoros does not seem to get the URI info correctly
            // This is a quick workaround
            $psrRequest = ServerRequestFactory::fromGlobals();

            $uri = $psrRequest->getUri();
            $uri = $uri->withPath($request->getPath());
            
            $psrRequest = $psrRequest->withUri($uri->withPath($request->getPath()));

            $response = $router->dispatch($psrRequest, new Response());

        } catch (HttpException $e) {
            $response = self::getRoutingErrorResponse($e);
        }

        return $response;
    }

    /**
     * @param HttpException $e
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function getRoutingErrorResponse(HttpException $e)
    {
        $response = new Response();
        $response->getBody()->write('<h1>'. $e->getStatusCode() . ': ' . $e->getMessage().'</h1>');

        return $response;
    }
}
