<?php
namespace App\Library;

use App\Library\Contracts\IValidator;
use App\Library\Contracts\IService;
use Interop\Container\ContainerInterface;
use Predis\Client;
use Illuminate\Database\Capsule\Manager as Db;

abstract class AService implements IService
{
    protected $validator;
    protected $cache;
    protected $db;

    public function addValidator(IValidator $validator)
    {
        $this->validator = $validator;
    }

    public function addCache(Client $cache)
    {
        $this->cache = $cache;
    }

    public function addDabatase(Db $db)
    {
        $this->db = $db;
    }
}