<?php
use SlimSession\Helper;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Illuminate\Database\Capsule\Manager;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Libraries\CookieHelper;
use EasyWeChat\Factory;

// view renderer
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $view     = new Twig($settings['templatePath'], [
        'cache' => $settings['templateCachePath'],
        'debug' => 'auto_reload',
    ]);
    $view->addExtension(new TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));
    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/*
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $c['logger']->error($exception);
        return $c['response']->withStatus(500)
                             ->withHeader('Content-Type', 'text/html')
                             ->write('Something went wrong!');
    };
};
$container['phpErrorHandler'] = function ($c) {
    return function ($request, $response, $error) use ($c) {
        $c['logger']->error($error);
        return $c['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    };
};
*/

$container['session'] = function ($c) {
    return new Helper;
};

$container['cookie'] = function ($c) {
    return new CookieHelper;
};

//database
$capsule = new Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function ($c) use ($capsule){
    return $capsule;
};

//wechat
$wechat = require __DIR__ . '/../configs/wechat.php';
$container['wechat_open'] = Factory::openPlatform($wechat);
