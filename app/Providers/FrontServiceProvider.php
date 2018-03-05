<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use View;
use App\Repositories\CategoryRepository;
use App\Repositories\AreaRepository;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use Cache;

class FrontServiceProvider extends ServiceProvider
{
    protected $repository;
    protected $areaRepository;

    public function __construct()
    {
        $this->repository = new CategoryRepository(new \App\Models\Category);
        $this->areaRepository = new AreaRepository(new \App\Models\Area);
    }

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
        $areas = $this->areaRepository->getAll();
        if (Cache::has(config('common.area_cache_key'))) {
            $areas = Cache::get(config('common.area_cache_key'));
        } else {
            $columns = ['area_id', 'area_name'];
            $areas = $this->areaRepository->getAll($columns)->toArray();
            // Cache::put(config('common.area_cache_key'), $activities, 30);
        }
        var_dump($areas);
        View::share('areas', $areas);

        // 分類
        if (Cache::has(config('common.category_cache_key'))) {
            $activities = Cache::get(config('common.category_cache_key'));
        } else {
            $columns = ['c_id', 'c_title'];
            $activities = $this->repository->getAllWithLevel($columns)->toArray();
            // Cache::put(config('common.category_cache_key'), $activities, 30);
        }
        View::share('activities', $activities);
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
