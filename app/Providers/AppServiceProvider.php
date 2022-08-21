<?php

namespace App\Providers;

use App\Services\Manager\FMenu\MenuManager;
use App\Services\Traits\RepositorySetup;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Menu;
use Illuminate\Database\Eloquent\Model;

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
        Model::preventLazyLoading(! app()->isProduction());
    }
}
