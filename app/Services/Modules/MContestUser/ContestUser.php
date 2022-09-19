<?php

namespace App\Services\Modules\MContestUser;

use App\Models\ContestUser as ModelsContestUser;

class ContestUser implements MContestUserInterface
{
    public function __construct(private ModelsContestUser $contestUser)
    {
    }

    public function checkExitsAndManager($params)
    {
        if (!$contestUser = $this->contestUser::where('contest_id', $params['contest_id'])
            ->where('user_id', $params['user']->id)
            ->first()) $contestUser = $this->contestUser::create([
            'contest_id' => $params['contest_id'],
            'user_id' =>  $params['user']->id,
            'reward_point' => 0
        ]);
        $contestUser->reward_point = $contestUser->reward_point +  $params['point'];
        $contestUser->save();
    }
}