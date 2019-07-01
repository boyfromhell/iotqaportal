<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $fillable = [

    ];

    public function sequences()
    {
        return $this->hasMany(Sequence::class);
    }

    public function testCaseSummaries()
    {
        return $this->hasMany(TestCaseSummary::class);
    }
}
