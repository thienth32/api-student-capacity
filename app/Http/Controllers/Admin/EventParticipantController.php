<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use App\Services\Traits\TResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    use TResponse;
    protected $participant;
    protected $user;

    public function __construct(EventParticipant $participant, User $user)
    {
        $this->participant = $participant;
        $this->user = $user;
    }

    public function list(Event $event, Request $request) 
    {
        $type = $request->type ?? 1;
        $event->load('participants');
        $query = $event->participants();
        $joinedIds = $event->participants()->pluck('user_id')->toArray();

        if ($type == 1) { //mentor đã được duyệt
            $query->mentor();
        }
        if ($type == 2) { //user thường
            $query->normalUser();
        }
        $participants = $query->with(['user'])->paginate(10)->appends(['type' => $type]);
        $users = $this->user::where('status', 1)
            ->whereHas('roles', function (Builder $query) {
                $query->where('id', config('util.MENTOR_ROLE'));
            })
            ->whereNotIn('id', $joinedIds)
            ->get();

        return view('pages.events.participants', compact('event', 'participants', 'type', 'users'));
    }

    public function addMentor(Event $event, Request $request) 
    {
        try {
            $request->validate([
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id'
            ]);

            foreach ($request->user_ids as $userId) {
                EventParticipant::firstOrCreate([
                    'event_id' => $event->id,
                    'user_id' => $userId,
                    'role' => config('util.EVENT.PARTICIPANT.ROLE.MENTOR'),
                    'status' => config('util.EVENT.PARTICIPANT.STATUS.APPROVE'),
                ]);
            }
            return back()->with('success', 'Thêm mentor thành công');
        } catch (\Throwable $th) {
            return redirect('error');
        }
    }

    public function remove(Event $event, EventParticipant $participant)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            if ($event->id != $participant->event_id) return abort(400);
            $participant->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect('error');
        }
    }

    //api for client
    public function apiJoinEvent(Event $event) //user join event với role user thường
    {

    }
    
    public function apiRequestMentor(Event $event) //user join event với role mentor
    {

    }
}
