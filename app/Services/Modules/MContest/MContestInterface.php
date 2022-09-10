<?php

namespace App\Services\Modules\MContest;

interface MContestInterface
{
    public function index();

    public function apiIndex($flagCapacity = false);

    public function store($filename, $request);

    public function sendMail($id);

    public function backUpContest($id);

    public function deleteContest($id);

    public function apiShow($id, $type);

    public function show($id, $type);

    public function find($id);

    public function update($contest, $data);

    public function getContest();

    public function getContestRunning();

    public function getConTestCapacityByDateTime();

    public function getCountContestGoingOn();

    public function getContestByDateNow($date);

    public function getContestMapSubDays($date);

    public function getCapacityRelated($id_capacity);

    public function getContestByIdUpdate($id, $type = 0);
}