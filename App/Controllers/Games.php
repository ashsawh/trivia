<?php
namespace App\Controllers;

use App\Library\AController;

use App\Services\Games as GamesService;

use App\Validators\Games as GamesValidator;

use Interop\Container\ContainerInterface as ContainerInterface;

class Games extends AController
{
    public $service;

    function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
        $this->service = new GamesService($ci);
        $this->service->addValidator(new GamesValidator());
        $this->service->addCache($ci->get('cdb'));
        $this->service->addDabatase($ci->get('db'));
    }

    public function store($req, $res, $args)
    {
        $body = $req->getParsedBody();
        $payload = json_decode($body['payload'], true);
        return $res->withJson($this->service->store($payload));
    }

    public function retrieve($req, $res, $args)
    {
        return $res->withJson($this->service->retrieve($args['gamesId']));
    }

    public function modify($req, $res, $args)
    {
        $body = $req->getParsedBody();
        $payload = json_decode($body['payload'], true);
        return $res->withJson($this->service->modify($payload, $args['gamesId']));
    }

    public function remove($req, $res, $args)
    {
        return $res->withJson($this->service->remove($args['gamesId']));
    }
}