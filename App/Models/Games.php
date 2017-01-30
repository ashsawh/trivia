<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    protected $fillable = [
        'user_id',
        'score',
        'state'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}