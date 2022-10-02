<?php

namespace App\Providers;

use App\Services\Manager\FMenu\MenuManager;
use App\Services\Traits\RepositorySetup;
use Google\Service\ServiceControl\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    use RepositorySetup;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->callApp();
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
        Blade::if("capacity", function () {
            return request('type') == config('util.TYPE_TEST');
        });
        Blade::if("contest", function () {
            return request('type') != config('util.TYPE_TEST');
        });
        Blade::if('admin', function () {
            return auth()->user()->hasRole(config('util.ROLE_ADMINS'));
        });
        // Model::preventLazyLoading(!app()->isProduction());
    }
}