<?php

namespace App\Services\Modules\MContest;

interface MContestInterface
{
    public function index();

    public function apiIndex($flagCapacity = false);

    public function store($filename, $request, $skills = []);

    public function sendMail($id);

    public function backUpContest($id);

    public function deleteContest($id);

    public function apiShow($id, $type);

    public function show($id, $type);

    public function find($id);

    public function update($contest, $data, $skills = []);

    public function getContest();

    public function getContestRunning();

    public function getConTestCapacityByDateTime();

    public function getCountContestGoingOn();

    public function getContestByDateNow($date);

    public function getContestMapSubDays($date);

    public function getContestRelated($id_contest);

    public function getContestByIdUpdate($id, $type = 0);

    public function getContestDeadlineEnd($with = []);

    public function getContestDone();

    public function endContestOutDateRegisterDealine();
}