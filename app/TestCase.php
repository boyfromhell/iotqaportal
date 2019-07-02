<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class TestCase extends Model
{

    use Actionable;

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
