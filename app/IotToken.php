<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IotToken extends Model
{
    protected $fillable = [
        'access_token',
        'jwt_token',
        'expires_at',
        'iot_user_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
