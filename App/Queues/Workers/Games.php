<?php
namespace App\Queues\Workers;

use App\Library\AQueueWorker;
use App\Services\Games as GamesService;
use App\Validators\Games as GamesValidation;
use Predis\Client;

require_once '../../../vendor/autoload.php';

class Games extends AQueueWorker
{
    const QUEUE = "storeGame";

    public function store()
    {
        $this->service->store($this->payload);
    }
}


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

$container['settings']['displayErrorDetails'] = true;
$container['settings']['addContentLengthHeader'] = false;

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$a = new GamesService();
$a->addValidator(new GamesValidation());
$a->addCache(new Client(array('host' => 'redis')));
$a->addDabatase($capsule);

$b = new Games($a);
$b->listen('storeGame');