<?php

namespace App\Http\Controllers;


use App\Http\Middleware\IoTAPIAuth;
use App\Jobs\RunDeviceTestJob;
use App\TestCase;


class SequenceController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware(IoTAPIAuth::class);
//    }

    public function runTest($testCaseId)
    {
//        $tokens = IotCredential::getTokens();

//        dd($testCaseId);
        $testCase = TestCase::with('sequences')->find($testCaseId);
//        event(new RunTestCase($testCase));

        $job = (new RunDeviceTestJob($testCase))->delay(now()->addSeconds(1));;

        $this->dispatch($job);
        return 'Done';
    }
}
