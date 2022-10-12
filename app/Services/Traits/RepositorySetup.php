<?php

namespace App\Services\Traits;

use App\Services\Manager\FMenu\MenuManager;
use App\Services\Modules\MAnswer\Answer;
use App\Services\Modules\MAnswer\MAnswerInterface;
use App\Services\Modules\MChallenge\Challenge;
use App\Services\Modules\MChallenge\MChallengeInterface;
use App\Services\Modules\MCodeLanguage\CodeLanguage;
use App\Services\Modules\MCodeLanguage\MCodeLanguageInterface;
use App\Services\Modules\MContest\Contest;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MContestUser\ContestUser;
use App\Services\Modules\MContestUser\MContestUserInterface;
use App\Services\Modules\MExam\Exam;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MKeyword\Keyword;
use App\Services\Modules\MKeyword\MKeywordInterface;
use App\Services\Modules\MMajor\Major;
use App\Services\Modules\MMajor\MMajorInterface;
use App\Services\Modules\MQuestion\MQuestionInterface;
use App\Services\Modules\MQuestion\Question;
use App\Services\Modules\MResultCapacity\MResultCapacityInterface;
use App\Services\Modules\MResultCapacity\ResultCapacity;
use App\Services\Modules\MResultCapacityDetail\MResultCapacityDetailInterface;
use App\Services\Modules\MResultCapacityDetail\ResultCapacityDetail;
use App\Services\Modules\MResultCode\MResultCodeInterface;
use App\Services\Modules\MResultCode\ResultCode;
use App\Services\Modules\MRound\MRoundInterface;
use App\Services\Modules\MRound\Round;
use App\Services\Modules\MRoundTeam\MRoundTeamInterface;
use App\Services\Modules\MRoundTeam\RoundTeam;
use App\Services\Modules\MSampleCode\MSampleCodeInterface;
use App\Services\Modules\MSampleCode\SampleCode;
use App\Services\Modules\MSkill\MSkillInterface;
use App\Services\Modules\MSkill\Skill;
use App\Services\Modules\MTeam\MTeamInterface;
use App\Services\Modules\MTeam\Team;
use App\Services\Modules\MTestCase\MTestCaseInterfave;
use App\Services\Modules\MTestCase\TestCase;
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
            MQuestionInterface::class,
            Question::class,
        );

        $this->app->bind(
            MAnswerInterface::class,
            Answer::class,
        );

        $this->app->bind(
            MTeamInterface::class,
            Team::class,
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

        $this->app->bind(
            MExamInterface::class,
            Exam::class,
        );

        $this->app->bind(
            MResultCapacityInterface::class,
            ResultCapacity::class,
        );

        $this->app->bind(
            MResultCapacityDetailInterface::class,
            ResultCapacityDetail::class,
        );

        $this->app->bind(
            MRoundTeamInterface::class,
            RoundTeam::class,
        );

        $this->app->bind(
            MSkillInterface::class,
            Skill::class,
        );

        $this->app->bind(
            MContestUserInterface::class,
            ContestUser::class,
        );

        $this->app->bind(
            MKeywordInterface::class,
            Keyword::class,
        );

        $this->app->bind(
            MChallengeInterface::class,
            Challenge::class,
        );

        $this->app->bind(
            MResultCodeInterface::class,
            ResultCode::class,
        );

        $this->app->bind(
            MCodeLanguageInterface::class,
            CodeLanguage::class,
        );

        $this->app->bind(
            MSampleCodeInterface::class,
            SampleCode::class,
        );

        $this->app->bind(
            MTestCaseInterfave::class,
            TestCase::class,
        );
    }
}