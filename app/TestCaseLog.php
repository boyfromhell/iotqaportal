<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCaseLog extends Model
{
    protected $fillable = [
        'action',
        'sequence_id',
        'http_response',
        'wait_time',
        'status'    
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
