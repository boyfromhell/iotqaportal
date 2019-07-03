<?php

namespace App\Nova;

use App\Nova\Actions\RunTestCase;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class TestCase extends Resource
{
    public static $with = ['sequences', 'testCaseSummaries'];
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\TestCase';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'device_id'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $device = new \App\Device();

        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Select::make('Device', 'device_id')
                ->options($device->getDeviceSelect())
                ->displayUsingLabels(),
            Number::make('loops'),
            BelongsTo::make('User'),
            HasMany::make('Sequences', 'sequences'),
            HasMany::make('Test Case Summaries', 'testCaseSummaries')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new RunTestCase()
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole('Admin')) {
            return $query;
        }

        return $query->where('user_id', $request->user()->id);
    }
}
