<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function movieGenres()
    {
        return $this->belongsToMany(MovieGenre::class);
    }
}
