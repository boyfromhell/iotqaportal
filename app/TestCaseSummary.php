<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCaseSummary extends Model
{
    public function testCaseLogs()
    {
        return $this->hasMany(TestCaseLog::class);
    }

    public function testCase()
    {
        return $this->belongsTo(TestCase::class);
    }
}
