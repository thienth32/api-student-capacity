<?php

namespace App\Services\Traits;

use App\Services\Manager\FMenu\MenuManager;
use App\Services\Modules\MContest\Contest;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MMajor\Major;
use App\Services\Modules\MMajor\MMajorInterface;
use App\Services\Modules\MRound\MRoundInterface;
use App\Services\Modules\MRound\Round;
use App\Services\Modules\MUser\MUserInterface;
use App\Services\Modules\MUser\User;

trait RepositorySetup
{
    public function callApp()
    {
        $this->configMenuAdmin();
        $this->callRepositoryApp();
    }

    private function configMenuAdmin()
    {
        $this->app->singleton('menu', function () {
            return new MenuManager();
        });
    }

    private function callRepositoryApp()
    {
        $this->app->bind(
            MContestInterface::class,
            Contest::class,
        );
        $this->app->bind(
            MRoundInterface::class,
            Round::class,
        );
        $this->app->bind(
            MMajorInterface::class,
            Major::class,
        );

        $this->app->bind(
            MUserInterface::class,
            User::class,
        );
    }
}