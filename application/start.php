<?php
ini_set('date.timezone', 'Asia/Shanghai');

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

define("APP_ROOT", __DIR__);
define("ASSETS_ROOT", APP_ROOT.'/public/assets');

// Instantiate the app
$settings = require __DIR__ . '/configs/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

// Set up dependencies
require __DIR__ . '/configs/dependencies.php';

$serverParams = $container['request']->getServerParams();
define('SYS_TIME', $serverParams['REQUEST_TIME']);
define('SITE_PROTOCOL', isset($serverParams['SERVER_PORT']) && $serverParams['SERVER_PORT'] == '443' ? 'https://' : 'http://');
$serverport=$serverParams['SERVER_PORT']=='80'?'':':'.$serverParams['SERVER_PORT'];
define('SYS_PATH', SITE_PROTOCOL . $serverParams['SERVER_NAME'].$serverport);
define('APP_URL', SYS_PATH);
define('SELF_URL', $container['request']->getUri());
define('ASSETS_PATH', SYS_PATH.'/assets');
define('DATA_PATH', SYS_PATH.'/data');
define('UPLOAD_PATH', SYS_PATH.'/data/uploads');

$queryParams = $container['request']->getQueryParams();
$container['queryParams'] = $queryParams;
$viewArgs                 = [
    'APP_URL'     => APP_URL,
    'SYS_PATH'    => SYS_PATH,
    'SELF_URL'    => SELF_URL,
    'ASSETS_PATH' => ASSETS_PATH,
    'DATA_PATH'   => DATA_PATH,
    'args'        => $queryParams,
];

$container['view']['viewArgs'] = $viewArgs;
$container['view']['twig']     = $container['view']->getEnvironment();

foreach ($container['view']['viewArgs'] as $key => $value) {
    $container['view']['twig']->addGlobal($key, $value);
}

// Register middleware
require __DIR__ . '/configs/middleware.php';

// Register routes
require __DIR__ . '/configs/routes.php';

// Run app
$app->run();
