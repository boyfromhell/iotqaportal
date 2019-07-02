<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $casts = [
        'created_at'=>'datetime'
    ];
}
