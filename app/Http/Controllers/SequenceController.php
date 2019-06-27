<?php

namespace App\Http\Controllers;


use App\Http\Middleware\IoTAPIAuth;
use App\Jobs\RunDeviceTestJob;
use App\TestCase;
use Illuminate\Support\Facades\Auth;


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

        $userId = Auth::id();
        $job = (new RunDeviceTestJob($testCase, $userId))->delay(now()->addSeconds(1));;

        $this->dispatch($job);
        session()->flash('success','Added To Queue');
        return redirect()->back();
    }
}
