<?php

namespace App\Providers;

use App\Services\Manager\FMenu\MenuManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Menu;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this -> app -> singleton('menu' , function () {
            return new MenuManager();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Arr::macro('listColumnOfTable', function (string $table) {
            return Schema::getColumnListing($table);
        });
    }
}
