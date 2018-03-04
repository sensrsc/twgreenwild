<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use View;

class FrontServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $agent = new Agent();
        $device = $agent->isMobile()? 'mobile' : 'desktop';
        View::share('device', $device);

        // 地區


        // 分類
        View::composer(
            ['front.desktop.header', 'front.mobile.header'], 'App\Http\ViewComposers\FrontHeaderComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
