<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CapacityPlayController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\CodeManagerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\JudgeController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContestController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SendMailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnterpriseController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\admin\KeywordController;
use App\Http\Controllers\Admin\RecruitmentController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PrintPDFController;
use App\Http\Controllers\Admin\PrintExcelController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard/api-cuoc-thi', [DashboardController::class, 'chartCompetity'])->name('dashboard.chart-competity');

Route::prefix('rounds')->group(function () {

    Route::get('', [RoundController::class, 'index'])->name('admin.round.list')->middleware('role_admin');


    Route::group([
        'middleware' => 'role_admin'
    ], function () {
        Route::post('send-mail/{id}', [SendMailController::class, 'sendMailRoundUser'])->name('round.send.mail.pass');
        Route::get('{id}/form-send-mail', [RoundController::class, 'sendMail'])->name('admin.round.send.mail');
        Route::get('form-add', [RoundController::class, 'create'])->name('admin.round.create');
        Route::post('form-add-save', [RoundController::class, 'store'])->name('admin.round.store');
        Route::get('{id}/edit', [RoundController::class, 'edit'])->name('admin.round.edit');
        Route::put('{id}', [RoundController::class, 'update'])->name('admin.round.update');
        Route::delete('{id}', [RoundController::class, 'destroy'])->name('admin.round.destroy');
        Route::get('round-soft-delete', [RoundController::class, 'softDelete'])->name('admin.round.soft.delete');
        Route::get('round-soft-delete/{id}/backup', [RoundController::class, 'backUpRound'])->name('admin.round.soft.backup');
        Route::get('round-soft-delete/{id}/delete', [RoundController::class, 'deleteRound'])->name('admin.round.soft.destroy');
    });



    Route::prefix('{id}/detail')->group(function () {
        Route::get('', [RoundController::class, 'adminShow'])->name('admin.round.detail');


        Route::group([
            'middleware' => 'role_admin'
        ], function () {
            Route::prefix('enterprise')->group(function () {
                Route::get('', [RoundController::class, 'roundDetailEnterprise'])->name('admin.round.detail.enterprise');
                Route::post('attach', [RoundController::class, 'attachEnterprise'])->name('admin.round.detail.enterprise.attach');
                Route::get('detach/{enterprise_id}', [RoundController::class, 'detachEnterprise'])->name('admin.round.detail.enterprise.detach');
            });
        });

        Route::prefix('roundTeam')->group(function () {
            Route::get('', [RoundController::class, 'roundDetailUpdateRoundTeam'])->name('admin.round.detail.updateRoundTeam');
        });

        Route::prefix('team')->group(function () {
            Route::group([
                'middleware' => 'role_admin'
            ], function () {
                Route::post('attach', [RoundController::class, 'attachTeam'])->name('admin.round.detail.team.attach');
                Route::post('sync', [RoundController::class, 'syncTeam'])->name('admin.round.detail.team.sync');
                Route::get('detach/{team_id}', [RoundController::class, 'detachTeam'])->name('admin.round.detail.team.detach');
            });

            Route::get('', [RoundController::class, 'roundDetailTeam'])->name('admin.round.detail.team');
            // Route::prefix('take-exam')->group(function () {
            //     Route::get('{teamId}', [RoundController::class, 'roundDetailTeamTakeExam'])->name('admin.round.detail.team.takeExam');
            //     Route::get('{teamId}/make', [RoundController::class, 'roundDetailTeamMakeExam'])->name('admin.round.detail.team.make.exam');
            //     Route::post('{teamId}/make', [RoundController::class, 'roundDetailFinalTeamMakeExam'])->name('admin.round.detail.team.final.make.exam');
            //     Route::put('{teamId}/make', [RoundController::class, 'roundDetailUpdateTeamMakeExam'])->name('admin.round.detail.team.update.make.exam');
            //     // Route::post('attach', [RoundController::class, 'attachTeam'])->name('admin.round.detail.team.attach');
            //     // Route::post('sync', [RoundController::class, 'syncTeam'])->name('admin.round.detail.team.sync');
            //     // Route::get('detach/{team_id}', [RoundController::class, 'detachTeam'])->name('admin.round.detail.team.detach');
            // });

            //            Route::group([
            //                'middleware' => 'role_admin:judge'
            //            ], function () {
            // Chấm điểm thi
            Route::prefix('take_exam')->group(function () {
                Route::put('{teamId}/update/{takeExamId}', [RoundController::class, 'roundDetailTeamTakeExamUpdate'])
                    ->name('admin.round.detail.team.takeExam.update')
                    ->middleware('role_admin');
                Route::group([
                    'middleware' => 'role_admin:judge'
                ], function () {
                    Route::get('{teamId}/make', [RoundController::class, 'roundDetailTeamMakeExam'])->name('admin.round.detail.team.make.exam');
                    Route::post('{teamId}/make', [RoundController::class, 'roundDetailFinalTeamMakeExam'])->name('admin.round.detail.team.final.make.exam');
                    Route::put('{teamId}/make', [RoundController::class, 'roundDetailUpdateTeamMakeExam'])->name('admin.round.detail.team.update.make.exam');
                    // Ban giám khảo
                    Route::get('{teamId}', [RoundController::class, 'roundDetailTeamTakeExam'])->name('admin.round.detail.team.takeExam');
                });
            });
            //            });
            Route::group([
                'middleware' => 'role_admin'
            ], function () {
                Route::prefix('judge')->group(function () {
                    Route::get('{teamId}', [RoundController::class, 'roundDetailTeamJudge'])->name('admin.round.detail.team.judge');
                });
            });


            Route::get('{teamId}', [RoundController::class, 'roundDetailTeamDetail'])->name('admin.round.detail.team.detail');

            Route::prefix('exam')->group(function () {
                Route::get('{teamId}', [RoundController::class, 'roundDetailTeamExam'])->name('admin.round.detail.team.Exam');
            });
        });

        Route::prefix('exam')->group(function () {
            Route::get('', [ExamController::class, 'index'])->name('admin.exam.index');
            Route::get('create', [ExamController::class, 'create'])->name('admin.exam.create');
            Route::post('store', [ExamController::class, 'store'])->name('admin.exam.store');
            Route::get('{id_exam}/edit', [ExamController::class, 'edit'])->name('admin.exam.edit');
            Route::post('{id_exam}/un-status', [ExamController::class, 'un_status'])->name('admin.exam.un_status');
            Route::post('{id_exam}/re-status', [ExamController::class, 're_status'])->name('admin.exam.re_status');
            Route::put('{id_exam}', [ExamController::class, 'update'])->name('admin.exam.update');
        });

        Route::prefix('result')->group(function () {
            Route::get('', [ResultController::class, 'index'])->name('admin.result.index');
        });
    });
});


Route::group([
    'middleware' => 'role_admin'
], function () {
    Route::prefix('capacity-play')->group(function () {
        Route::get('', [CapacityPlayController::class, 'index'])->name('admin.capacit.play.index');
        Route::get('create', [CapacityPlayController::class, 'create'])->name('admin.capacit.play.create');
        Route::post('store', [CapacityPlayController::class, 'store'])->name('admin.capacit.play.store');
        Route::get('{id}', [CapacityPlayController::class, 'show'])->name('admin.capacit.play.show');
        Route::get('run-now/{id}', [CapacityPlayController::class, 'start'])->name('admin.capacit.play.run');
        Route::get('view-now/{id}', [CapacityPlayController::class, 'viewStart'])->name('admin.capacit.play.view.run');
        Route::get('end/{id}', [CapacityPlayController::class, 'end'])->name('admin.capacit.play.end');
        Route::post('{id_exam}/un-status', [CapacityPlayController::class, 'un_status'])->name('admin.capacit.un_status');
        Route::post('{id_exam}/re-status', [CapacityPlayController::class, 're_status'])->name('admin.capacit.re_status');
    });

    Route::prefix('teams')->group(function () {
        //list
        Route::get('', [TeamController::class, 'ListTeam'])->name('admin.teams'); // Api list Danh sách teams theo cuộc thi. phía view
        // end lisst
        Route::delete('{id}', [TeamController::class, 'deleteTeam'])->name('admin.delete.teams'); // Api xóa teams phía view
        Route::prefix('form-add')->group(function () {
            Route::get('', [TeamController::class, 'create'])->name('admin.teams.create');
            Route::post('contest', [TeamController::class, 'getContest'])->name('admin.teams.add.contest.show');
        });
        Route::post('form-add-save', [TeamController::class, 'store'])->name('admin.teams.store');
        Route::get('form-edit/{id}', [TeamController::class, 'edit'])->name('admin.teams.edit');
        Route::put('form-edit-save/{id}', [TeamController::class, 'update'])->name('admin.teams.update');

        Route::get('team-soft-delete', [TeamController::class, 'softDelete'])->name('admin.team.soft.delete');
        Route::get('team-soft-delete/{id}/backup', [TeamController::class, 'backUpTeam'])->name('admin.team.soft.backup');
        Route::get('team-soft-delete/{id}/delete', [TeamController::class, 'destroy'])->name('admin.team.soft.destroy');
    });
    Route::prefix('users')->group(function () {
        Route::post('team-user-search', [UserController::class, 'TeamUserSearch'])->name('admin.user.TeamUserSearch');
        Route::post('user-team-search/{id_contest}', [TeamController::class, "userTeamSearch"])->name('admin.user.team.search');
    });
});



Route::prefix('contests')->group(function () {

    Route::get('', [ContestController::class, 'index'])->name('admin.contest.list');
    // Send mail method poss

    Route::group([
        'middleware' => 'role_admin'
    ], function () {
        Route::get('form-add', [ContestController::class, 'create'])->name('admin.contest.create');
        Route::get('register-deadline/{id}', [ContestController::class, 'register_deadline'])->name('contest.register.deadline');
        Route::post('send-mail/{id}', [SendMailController::class, 'sendMailContestUser'])->name('contest.send.mail.pass');
        // Send mail method Get
        Route::get('{id}/form-send-mail', [ContestController::class, 'sendMail'])->name('admin.contest.send.mail');
        Route::post('form-add-save', [ContestController::class, 'store'])->name('admin.contest.store');
        Route::post('un-status/{id}', [ContestController::class, 'un_status'])->name('admin.contest.un.status');
        Route::post('re-status/{id}', [ContestController::class, 're_status'])->name('admin.contest.re.status');
        Route::delete('{id}', [ContestController::class, 'destroy'])->name('admin.contest.destroy');
        Route::get('{id}/edit', [ContestController::class, 'edit'])->name('admin.contest.edit');
        Route::put('{id}', [ContestController::class, 'update'])->name('admin.contest.update');
    });

    Route::prefix('{id}/detail')->group(function () {
        Route::get('', [ContestController::class, 'show'])->name('admin.contest.show');
        Route::get('rounds', [RoundController::class, 'contestDetailRound'])->name('admin.contest.detail.round');
        Route::group([
            'middleware' => 'role_admin'
        ], function () {
            Route::prefix('teams')->group(function () {
                Route::get('', [ContestController::class, 'contestDetailTeam'])->name('admin.contest.detail.team');
                Route::post('update-team-select', [ContestController::class, 'contestDetailTeamAddSelect'])->name('admin.contest.detail.team.addSelect');
                Route::get('add-team-contest-form.html', [ContestController::class, 'addFormTeamContest'])->name('admin.contest.detail.team.add.form');
                Route::post('add-team-contest-save', [ContestController::class, 'addFormTeamContestSave'])->name('admin.contest.detail.team.add.save');
                Route::get('{id_team}/edit-team-contest-form', [ContestController::class, 'editFormTeamContest'])->name('admin.contest.detail.team.edit.form');
                Route::put('{id_team}/edit-team-contest-save', [ContestController::class, 'editFormTeamContestSave'])->name('admin.contest.detail.team.save');
            });
            Route::prefix('enterprise')->group(function () {
                Route::get('', [ContestController::class, 'contestDetailEnterprise'])->name('admin.contest.detail.enterprise');
                Route::post('attach', [ContestController::class, 'attachEnterprise'])->name('admin.contest.detail.enterprise.attach');
                Route::get('detach/{enterprise_id}', [ContestController::class, 'detachEnterprise'])->name('admin.contest.detail.enterprise.detach');
            });
        });
    });
    Route::group([
        'middleware' => 'role_admin'
    ], function () {
        Route::get('contest-soft-delete', [ContestController::class, 'softDelete'])->name('admin.contest.soft.delete');
        Route::get('contest-soft-delete/{id}/backup', [ContestController::class, 'backUpContest'])->name('admin.contest.soft.backup');
        Route::get('contest-soft-delete/{id}/delete', [ContestController::class, 'deleteContest'])->name('admin.contest.soft.destroy');
    });
});

// Route::prefix('exam')->group(function () {
//     Route::post('store', [ExamController::class, 'store'])->name('admin.exam.store');
//     Route::put('{id}', [ExamController::class, 'apiUpdate']);
// });
// Route::group([
//     'middleware' => 'role_admin'
// ], function () {

// Middleware phân quyền ban giám khảo chấm thi , khi nào gộp code sẽ chỉnh sửa lại route để phân quyền route
Route::group([
    'middleware' => 'role_admin:judge|admin|super admin'
], function () {
    Route::get('prinft-pdf', [PrintPDFController::class, 'printf'])->name('admin.prinf');
    Route::get('prinft-excel', [PrintExcelController::class, 'printf'])->name('admin.excel');
});

Route::group([
    'middleware' => 'role_admin'
], function () {

    Route::prefix('enterprise')->group(function () {
        Route::get('{id}/edit', [EnterpriseController::class, 'edit'])->name('admin.enterprise.edit');
        Route::put('{id}', [EnterpriseController::class, 'update'])->name('admin.enterprise.update');
        Route::get('', [EnterpriseController::class, 'index'])->name('admin.enterprise.list');
        Route::get('form-add', [EnterpriseController::class, 'create'])->name('admin.enterprise.create');
        Route::post('form-add-save', [EnterpriseController::class, 'store'])->name('admin.enterprise.store');
        Route::post('un-status/{id}', [EnterpriseController::class, 'un_status'])->name('admin.enterprise.un.status');
        Route::post('re-status/{id}', [EnterpriseController::class, 're_status'])->name('admin.enterprise.re.status');
        Route::delete('{id}', [EnterpriseController::class, 'destroy'])->name('admin.enterprise.destroy');

        Route::get('enterprise-soft-delete', [EnterpriseController::class, 'softDelete'])->name('admin.enterprise.soft.delete');
        Route::get('enterprise-soft-delete/{id}/backup', [EnterpriseController::class, 'backUpEnterprise'])->name('admin.enterprise.soft.backup');
        Route::get('enterprise-soft-delete/{id}/delete', [EnterpriseController::class, 'delete'])->name('admin.enterprise.soft.destroy');
    });
    Route::prefix('majors')->group(function () {
        Route::get('{slug}/edit', [MajorController::class, 'edit'])->name('admin.major.edit');
        Route::put('{slug}', [MajorController::class, 'update'])->name('admin.major.update');
        Route::get('', [MajorController::class, 'index'])->name('admin.major.list');
        Route::get('create', [MajorController::class, 'create'])->name('admin.major.create');
        Route::post('store', [MajorController::class, 'store'])->name('admin.major.store');
        Route::delete('{slug}', [MajorController::class, 'destroy'])->name('admin.major.destroy');
        Route::prefix('{slug}/skill')->group(function () {
            Route::get('', [MajorController::class, 'Skill'])->name('admin.major.skill');
            Route::post('attach', [MajorController::class, 'attachSkill'])->name('admin.major.skill.attach');
            Route::get('detach/{skill_id}', [MajorController::class, 'detachSkill'])->name('admin.major.skill.detach');
        });
        Route::prefix('list-soft-deletes')->group(function () {
            Route::get('', [MajorController::class, 'listRecordSoftDeletes'])->name('admin.major.list.soft.deletes');
            Route::get('{slug}/delete', [MajorController::class, 'permanently_deleted'])->name('admin.major.soft.deletes');
            Route::get('{slug}/restore', [MajorController::class, 'restore_deleted'])->name('admin.major.soft.restore');
        });
    });

    Route::prefix('judges')->group(function () {
        Route::get('{contest_id}/contest', [JudgeController::class, 'getJudgesContest'])->name('admin.judges.contest');
        Route::get('{round_id}/round', [JudgeController::class, 'getJudgesRound'])->name('admin.judges.round');
        Route::post('{round_id}/attach-round', [JudgeController::class, 'attachRound'])->name('admin.judges.attach.round');
        Route::post('{round_id}/detach-round', [JudgeController::class, 'dettachRound'])->name('admin.judges.detach.round');

        Route::post('{contest_id}/attach', [JudgeController::class, 'attachJudges'])->name('admin.judges.attach');
        Route::post('{contest_id}/sync', [JudgeController::class, 'syncJudges'])->name('admin.judges.sync');
        Route::delete('{contest_id}/detach', [JudgeController::class, 'detachJudges'])->name('admin.judges.detach');
    });

    Route::prefix('sliders')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('admin.sliders.list');
        Route::get('/{id}/edit', [SliderController::class, 'edit'])->name('admin.sliders.edit');
        Route::put('/{id}', [SliderController::class, 'update'])->name('admin.sliders.update');
        Route::get('create', [SliderController::class, 'create'])->name('admin.sliders.create');
        Route::post('store', [SliderController::class, 'store'])->name('admin.sliders.store');
        Route::delete('{id}', [SliderController::class, 'destroy'])->name('admin.sliders.destroy');
        Route::post('un-status/{id}', [SliderController::class, 'un_status'])->name('admin.sliders.un.status');
        Route::post('re-status/{id}', [SliderController::class, 're_status'])->name('admin.sliders.re.status');

        Route::get('slider-soft-delete', [SliderController::class, 'softDelete'])->name('admin.sliders.soft.delete');
        Route::get('slider-soft-delete/{id}/backup', [SliderController::class, 'backUpSlider'])->name('admin.sliders.soft.backup');
        Route::get('slider-soft-delete/{id}/delete', [SliderController::class, 'deleteSlider'])->name('admin.sliders.soft.destroy');
    });

    Route::prefix('skill')->group(function () {
        Route::get('{id}/edit', [SkillController::class, 'edit'])->name('admin.skill.edit');
        Route::put('{id}', [SkillController::class, 'update'])->name('admin.skill.update');
        Route::get('', [SkillController::class, 'index'])->name('admin.skill.index');
        Route::get('create', [SkillController::class, 'create'])->name('admin.skill.create');
        Route::post('store', [SkillController::class, 'store'])->name('admin.skill.store');
        Route::delete('{id}', [SkillController::class, 'destroy'])->name('admin.skill.destroy');
        Route::get('{id}/detail', [SkillController::class, 'detail'])->name('admin.skill.detail');
        Route::get('skill-soft-delete', [SkillController::class, 'softDelete'])->name('admin.skill.soft.delete');
        Route::get('skill-soft-delete/{id}/backup', [SkillController::class, 'backUpSkill'])->name('admin.skill.soft.backup');
        Route::get('skill-soft-delete/{id}/delete', [SkillController::class, 'delete'])->name('admin.skill.soft.destroy');
    });

    Route::prefix('acount')->group(function () {
        Route::get('', [UserController::class, 'listAdmin'])->name('admin.acount.list');
        Route::post('un-status/{id}', [UserController::class, 'un_status'])->name('admin.acount.un.status');
        Route::post('re-status/{id}', [UserController::class, 're_status'])->name('admin.acount.re.status');
        Route::post('change-role', [UserController::class, 'changeRole'])->name('admin.acount.change.role');
    });

    Route::prefix('capacity')->group(function () {
        Route::get('{id}', [ContestController::class, 'show_test_capacity'])->name('admin.contest.show.capatity');
    });

    Route::get('contest-capacity', [ContestController::class, 'getConTestCapacity']);

    Route::prefix('recruitment')->group(function () {
        Route::get('{id}/edit', [RecruitmentController::class, 'edit'])->name('admin.recruitment.edit');
        Route::put('{id}', [RecruitmentController::class, 'update'])->name('admin.recruitment.update');
        Route::get('', [RecruitmentController::class, 'index'])->name('admin.recruitment.list');
        Route::get('create', [RecruitmentController::class, 'create'])->name('admin.recruitment.create');

        Route::post('store', [RecruitmentController::class, 'store'])->name('admin.recruitment.store');
        Route::delete('{id}', [RecruitmentController::class, 'destroy'])->name('admin.recruitment.destroy');

        Route::prefix('list-soft-deletes')->group(function () {
            Route::get('', [RecruitmentController::class, 'listRecordSoftDeletes'])->name('admin.recruitment.list.soft.deletes');
            Route::get('{id}/delete', [RecruitmentController::class, 'backUpRecruitment'])->name('admin.recruitment.soft.deletes');
            Route::get('{id}/restore', [RecruitmentController::class, 'delete'])->name('admin.recruitment.soft.restore');
        });
        Route::post('un-hot/{id}', [RecruitmentController::class, 'un_hot'])->name('admin.recruitment.un.hot');
        Route::post('re-hot/{id}', [RecruitmentController::class, 're_hot'])->name('admin.recruitment.re.hot');
        Route::get('{id}', [RecruitmentController::class, 'detail'])->name('admin.recruitment.detail');
    });

    Route::prefix('posts')->group(function () {
        Route::get('{slug}/edit', [PostController::class, 'edit'])->name('admin.post.edit');
        Route::put('{id}', [PostController::class, 'update'])->name('admin.post.update');
        Route::get('', [PostController::class, 'index'])->name('admin.post.list');
        Route::get('create', [PostController::class, 'create'])->name('admin.post.create');
        Route::get('insert', [PostController::class, 'insert'])->name('admin.post.insert');

        Route::post('un-status/{id}', [PostController::class, 'un_status'])->name('admin.post.un.status');
        Route::post('re-status/{id}', [PostController::class, 're_status'])->name('admin.post.re.status');
        Route::post('un-hot/{id}', [PostController::class, 'un_hot'])->name('admin.post.un.hot');
        Route::post('re-hot/{id}', [PostController::class, 're_hot'])->name('admin.post.re.hot');
        Route::post('store', [PostController::class, 'store'])->name('admin.post.store');
        Route::delete('{slug}', [PostController::class, 'destroy'])->name('admin.post.destroy');
        Route::prefix('list-soft-deletes')->group(function () {
            Route::get('', [PostController::class, 'listRecordSoftDeletes'])->name('admin.post.list.soft.deletes');
            Route::get('{id}/delete', [PostController::class, 'backUpPost'])->name('admin.post.soft.deletes');
            Route::get('{id}/restore', [PostController::class, 'delete'])->name('admin.post.soft.restore');
        });
        Route::get('{slug}', [PostController::class, 'detail'])->name('admin.post.detail');
    });
    Route::prefix('candidates')->group(function () {
        Route::get('', [CandidateController::class, 'index'])->name('admin.candidate.list');
        Route::get('user-cv', [CandidateController::class, 'listCvUser'])->name('admin.candidate.listCvUser');
        Route::delete('{id}', [CandidateController::class, 'destroy'])->name('admin.candidate.destroy');
        Route::prefix('list-soft-deletes')->group(function () {
            Route::get('', [CandidateController::class, 'listRecordSoftDeletes'])->name('admin.candidate.list.soft.deletes');
            Route::get('{id}/delete', [CandidateController::class, 'backUpPost'])->name('admin.candidate.soft.deletes');
            Route::get('{id}/restore', [CandidateController::class, 'delete'])->name('admin.candidate.soft.restore');
        });
        Route::get('{id}', [CandidateController::class, 'detail'])->name('admin.candidate.detail');
    });
    Route::prefix('keywords')->group(function () {
        Route::get('{id}/edit', [KeywordController::class, 'edit'])->name('admin.keyword.edit');
        Route::put('{id}', [KeywordController::class, 'update'])->name('admin.keyword.update');
        Route::get('', [KeywordController::class, 'index'])->name('admin.keyword.list');
        Route::get('add', [KeywordController::class, 'create'])->name('admin.keyword.create');
        Route::post('un-status/{id}', [KeywordController::class, 'un_status'])->name('admin.keyword.un.status');
        Route::post('re-status/{id}', [KeywordController::class, 're_status'])->name('admin.keyword.re.status');
        Route::post('add-save', [KeywordController::class, 'store'])->name('admin.keyword.store');
        Route::delete('{id}', [KeywordController::class, 'destroy'])->name('admin.keyword.destroy');
        Route::prefix('list-soft-deletes')->group(function () {
            Route::get('', [KeywordController::class, 'listRecordSoftDeletes'])->name('admin.keyword.list.soft.deletes');
            Route::get('{id}/delete', [KeywordController::class, 'backUpPost'])->name('admin.keyword.soft.deletes');
            Route::get('{id}/restore', [KeywordController::class, 'delete'])->name('admin.keyword.soft.restore');
        });
    });


    Route::get('dowload-frm-excel', function () {
        return response()->download(public_path('assets/media/excel/excel_download.xlsx'));
    })->name("admin.download.execel.pass");
    Route::post('upload-image', [CkeditorController::class, 'updoadFile'])->name('admin.ckeditor.upfile');
    Route::prefix('questions')->group(function () {
        Route::get('', [QuestionController::class, 'index'])->name('admin.question.index');
        Route::get('add', [QuestionController::class, 'create'])->name('admin.question.create');
        Route::post('add', [QuestionController::class, 'store'])->name('admin.question.store');
        Route::get('edit/{id}', [QuestionController::class, 'edit'])->name('admin.question.edit');
        Route::post('update/{id}', [QuestionController::class, 'update'])->name('admin.question.update');
        Route::delete('destroy/{id}', [QuestionController::class, 'destroy'])->name('admin.question.destroy');
        Route::post('un-status/{id}', [QuestionController::class, 'un_status'])->name('admin.question.un.status');
        Route::post('re-status/{id}', [QuestionController::class, 're_status'])->name('admin.question.re.status');
        Route::get('soft-delete', [QuestionController::class, 'softDeleteList'])->name('admin.question.soft.delete');
        Route::delete('delete/{id}', [QuestionController::class, 'delete'])->name('admin.question.delete');
        Route::get('restore-delete/{id}', [QuestionController::class, 'restoreDelete'])->name('admin.question.restore');

        Route::post('import', [QuestionController::class, 'import'])->name('admin.question.excel.import');
        Route::post('import/{exam}', [QuestionController::class, 'importAndRunExam'])->name('admin.question.excel.import.exam');
        Route::get('export', [QuestionController::class, 'exportQe'])->name('admin.question.excel.export');


        Route::get('skill-question-api', [QuestionController::class, 'skillQuestionApi'])->name('admin.question.skill');
    });

    Route::prefix('job')->group(function () {
        Route::get('', [JobController::class, 'index'])->name('admin.job');
        Route::post('store', [JobController::class, 'store'])->name('admin.job.store');
        Route::get('destroy-error', [JobController::class, 'destroy'])->name('admin.job.destroy');
        Route::post('update-status', [JobController::class, 'updateStatusJob'])->name('admin.job.status');
    });

    Route::prefix('code-manager')->group(function () {
        Route::get('', [CodeManagerController::class, 'index'])->name('admin.code.manager.list');
        Route::get('show/{id}', [CodeManagerController::class, 'show'])->name('admin.code.manager.show');
        Route::post('update/{id}', [CodeManagerController::class, 'update'])->name('admin.code.manager.update');
        Route::get('create', [CodeManagerController::class, 'create'])->name('admin.code.manager.create');
        Route::post('store', [CodeManagerController::class, 'store'])->name('admin.code.manager.store');
        Route::post('update-test-case/{id}', [CodeManagerController::class, 'updateTestCase'])->name('admin.code.manager.update.test.case');
        Route::post('update-sample-code/{id}', [CodeManagerController::class, 'updateSampleCode'])->name('admin.code.manager.update.sample.code');
        Route::post('update-status/{id}', [CodeManagerController::class, 'updateStatus'])->name('admin.code.manager.update.status');
    });
});



// Route::get('api-view-check', function (App\Services\Modules\MContest\Contest $contest) {
//     $data = $contest->apiIndex();
//     return view('welcome');
// });
Route::get("dev", function () {
    return "<h1>Chức năng đang phát triển</h1> ";
})->name('admin.dev.show');