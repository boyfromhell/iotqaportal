<?php

namespace App\Jobs;

use App\Device;
use App\TestCase;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $testCase = $event->testCase;
        $actionSeries = $this->testCase->sequences;

        Log::debug('Access Token: ' . session()->get('access_token'));

        $device = new Device();
        for ($x = 0; $x < $this->testCase->loops; $x++) {
            Log::debug('Loop: ' . $x);
            foreach ($actionSeries as $action) {
                try {


                    $response = $device->executeAction((integer)$this->testCase->device_id, $action->action, json_decode($action->action_params));
                    Log::debug(collect($response));

                } catch (ClientException $e) {
                    Log::error($e->getCode() . ': ' . $e->getMessage());
                }

                Log::debug('waiting for ' . $action->duration . ' s');
                sleep($action->duration);
            }
        }

    }
}
