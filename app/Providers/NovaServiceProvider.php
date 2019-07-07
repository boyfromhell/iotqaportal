<?php

namespace App\Providers;

use App\Http\Middleware\IoTAPIAuth;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use SimonHamp\LaravelNovaCsvImport\LaravelNovaCsvImport;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {

        Gate::define('viewNova', function ($user) {

//            $user->middleware(IoTAPIAuth::class);
            return in_array($user->email, [
                'tharindarodrigo@gmail.com'
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
//            new Help,
            new \Llaski\NovaServerMetrics\Card(),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \PhpJunior\NovaLogViewer\Tool(),
            new \Spatie\TailTool\TailTool(),
            new LaravelNovaCsvImport(),
            \Vyuldashev\NovaPermission\NovaPermissionTool::make()
                ->canSee(function ($request) {
                    return $request->user()->hasRole('Admin');
                }),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
