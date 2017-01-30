<?php

namespace App\Library\Contracts;

use Predis\Client;
use Illuminate\Database\Capsule\Manager as Db;

interface IService {
    public function addValidator(IValidator $validator);
    public function addCache(Client $cache);
    public function addDabatase(Db $db);
}