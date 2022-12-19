<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatSupportEvent;
use App\Http\Controllers\Controller;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    use TUploadImage;

    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        return view('pages.support.index', $data);
    }

    public function store(Request $r)
    {
        $t = time();
        $data = [
            'id' => auth('sanctum')->user()->id,
            'room' => $r->room,
            'time' => date("h:i:s", $t)
        ];

        if ($r->message) {
            $data['message'] = $r->message;
            $this->sendBroadCast($r->room, $data);
        }

        if ($r->hasFile('file')) {
            $namefile = $this->uploadFile($r->file);
            $message = Storage::disk('s3')->temporaryUrl($namefile, now()->addSeconds(6000));
            $data['message'] = '<a href="' . $message . '"  target="_blank">Xem</a>';
            $this->sendBroadCast($r->room, $data);
        }

        return response()->json($data);
    }

    private function sendBroadCast($room, $data)
    {
        broadcast(new ChatSupportEvent($room, $data));
    }
}
