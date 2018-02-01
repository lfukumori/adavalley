<?php

namespace App\Providers;

use App\Status;
use App\Equipment;
use App\Department;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('equipment.index', function ($view) {
            $view->with(['equipment' => Equipment::all()]);
        });

        View::composer('equipment.edit', function ($view) {
            $view->with([
                'departments'   => Department::all(),
                'statuses'      => Status::all()
            ]);
        });

        View::composer('equipment.create', function ($view) {
            $view->with([
                'equipment'     => new Equipment(),
                'departments'   => Department::all(),
                'statuses'      => Status::all()
            ]);
        });
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
