<?php

namespace App\Validators;

use App\Library\AValidator;

use Respect\Validation\Validator as v;

class Games extends AValidator
{
    public function user_id()
    {
        return v::numeric();
    }

    public function state()
    {
        return v::optional(v::boolVal());
    }

    public function score()
    {
        return v::optional(v::numeric());
    }

    public function id()
    {
        return v::numeric();
    }
}