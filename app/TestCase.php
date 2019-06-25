<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    public function sequences()
    {
        return $this->hasMany(Sequence::class);
    }
}
