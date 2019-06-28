<?php

namespace App\Nova\Actions;

use App\Jobs\RunDeviceTestJob;
use App\TestCase;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RunTestCase extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $userId = Auth::id();
        foreach ($models as $model) {
            $job = (new RunDeviceTestJob($model, $userId))->delay(now()->addSeconds(1));
            dispatch($job);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
