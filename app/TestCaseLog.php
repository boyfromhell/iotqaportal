<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCaseLog extends Model
{
    protected $fillable = [
        'action',
        'test_case_summary_id',
        'sequence_id',
        'response',
        'status',
        'wait_time'
    ];

    public function testCaseSummary()
    {
        return $this->belongsTo(TestCaseSummary::class);
    }

    public function sequence()
    {
        return $this->belongsTo(Sequence::class);
    }
}
