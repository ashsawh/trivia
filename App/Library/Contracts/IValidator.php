<?php

namespace App\Library\Contracts;

interface IValidator {
    public function run();
    public function getMessages();
}