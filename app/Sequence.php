<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    public function testCase()
    {
        return $this->belongsTo(TestCase::class);
    }
}
