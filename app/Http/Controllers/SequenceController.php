<?php

namespace App\Http\Controllers;


use App\Jobs\RunDeviceTestJob;
use App\TestCase;


class SequenceController extends Controller
{

    public function runTest($testCaseId)
    {
//        $tokens = IotCredential::getTokens();

//        dd($testCaseId);
        $testCase = TestCase::with('sequences')->find($testCaseId);
//        event(new RunTestCase($testCase));

        dispatch($testCase)->delay(now()->addSeconds(1));

        return 'Done';
    }
}
