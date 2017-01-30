<?php

namespace App\Library\Contracts;

interface IQueueWorker {
    public function listen();
}