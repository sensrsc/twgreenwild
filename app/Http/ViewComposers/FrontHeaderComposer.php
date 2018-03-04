<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;
use Cache;

class FrontHeaderComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $repository;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(CategoryRepository $repository)
    {
        // Dependencies automatically resolved by service container...
        $this->repository = $repository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Cache::has(config('common.header_cache_key'))) {
            $categorys = Cache::get(config('common.header_cache_key'));
        } else {
            $categorys = ['1' => 'abcd', '2' => '12345'];
            Cache::put(config('common.header_cache_key'), $categorys, 30);
        }
        
        $view->with('categorys', $categorys);
    }
}