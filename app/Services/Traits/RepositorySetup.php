<?php

namespace App\Services\Traits;

use App\Services\Manager\FMenu\MenuManager;
use App\Services\Modules\MContest\Contest;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MRound\MRoundInterface;
use App\Services\Modules\MRound\Round;

trait RepositorySetup
{
    public function callApp()
    {
       $this->configMenuAdmin();
       $this->callRepositoryApp();
    }

    private function configMenuAdmin()
    {
        $this -> app -> singleton('menu' , function () {
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
    }
}
