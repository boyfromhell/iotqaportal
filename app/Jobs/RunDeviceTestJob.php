<?php

namespace App\Jobs;

use App\Device;
use App\IotCredential;
use App\TestCase;
use App\TestCaseLog;
use App\TestCaseSummary;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class RunDeviceTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $testCase;
    public $userId;
    public $comment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TestCase $testCase, $userId, $comment)
    {

        $this->testCase = $testCase;
        $this->userId = $userId;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $testCaseSummary = new TestCaseSummary();

        $actionSeries = $this->testCase->sequences;

        $testCaseSummary->comment = $this->comment;
        $testCaseSummary->test_case_id = $this->testCase->id;
        $testCaseSummary->save();


        Log::debug('Access Token: ' . session()->get('access_token'));

        $device = new Device($this->userId);
        for ($x = 0; $x < $this->testCase->loops; $x++) {
            Log::debug('Loop: ' . $x);
            foreach ($actionSeries as $action) {
                try {
                    $response = $device->executeTestAction((integer)$this->testCase->device_id, $action->action, json_decode($action->action_params));
                    Log::debug(collect($response));

                    TestCaseLog::insert([
                        'action' => $action->action,
                        'test_case_summary_id' => $testCaseSummary->id,
                        'sequence_id' => $action->id,
                        'response' => $response->getBody(),
                        'wait_time' => $action->duration,
                        'status' => $response->getStatusCode(),
                    ]);


                } catch (ClientException $e) {
                    Log::error($e->getCode() . ': ' . $e->getMessage());
                    TestCaseLog::insert([
                        'action' => $action->action,
                        'sequence_id' => $action->id,
                        'http_response' => $e->getCode(),
                        'wait_time' => $action->duration,
                        'status' => $e->getCode(),
                    ]);
                }


                Log::debug('waiting for ' . $action->duration . ' s');
                sleep($action->duration);
            }
        }

    }
}
