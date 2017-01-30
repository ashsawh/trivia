<?php

namespace Trivia;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Predis\Client;

require '../../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$container = new \Slim\Container;

$container['settings']['db'] = [
    'driver' => 'mysql',
    'host' => 'mysql',
    'database' => 'trivia',
    'username' => 'trivia_user',
    'password' => 'password',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];

$container['settings']['cdb'] = [
    'host' => 'redis'
];

$container['settings']['displayErrorDetails'] = true;
$container['settings']['addContentLengthHeader'] = false;

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['cdb'] = function ($container) {
    return new Client($container['settings']['cdb']);
};

$app = new \Slim\App($container);

$app->post('/api/v1/games', 'App\Controllers\Games:store');

$app->group('/api/v1/games/{gamesId}', function () {
    $this->get('', 'App\Controllers\Games:retrieve');
    $this->post('', 'App\Controllers\Games:store');
    $this->patch('', 'App\Controllers\Games:modify');
    $this->delete('', 'App\Controllers\Games:remove');
});

$app->run();