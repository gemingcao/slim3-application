<?php
use Slim\Middleware\Session;
use Slim\Csrf\Guard;

// Application middleware

/*
$container['csrf'] = function ($c) {
    return new Guard();
};
$app->add($container->get('csrf'));
*/

$app->add(new Session([
    'name' => 'wx_session',
    'autorefresh' => true,
    'lifetime' => '24 hour'
]));

/*
$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        return $response->withRedirect((string)$uri, 301);
    }
    return $next($request, $response);
});
*/