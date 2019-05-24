<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
