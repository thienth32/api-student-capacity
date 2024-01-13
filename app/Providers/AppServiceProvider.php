<?php

namespace App\Providers;

use App\Http\Controllers\CustomUrlResolver;
use App\Services\Manager\FMenu\MenuManager;
use App\Services\Traits\RepositorySetup;
use Google\Service\ServiceControl\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        Paginator::currentPathResolver(function () {
            return app(UrlGenerator::class)->current();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceRootUrl(config('app.url'));
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
