<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\RequestEvent;
use App\Models\Enterprise;
use App\Models\Event;
use App\Models\Sponsor;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use TUploadImage, TResponse;
    protected $event;
    protected $enterprise;

    public function __construct(Event $event, Enterprise $enterprise)
    {
        $this->event = $event;
        $this->enterprise = $enterprise;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->event::where('name', 'like', "%$keyword%")
            ->with(['createdBy', 'participants', 'sponsors']);

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    public function index(Request $request) {
        try {
            $events = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
                
            return view('pages.events.list', compact('events'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create() {
        return view('pages.events.create');
    }

    public function store(RequestEvent $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'note' => $request->note,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'register_link' => $request->register_link,
                'interview_count' => $request->interview_count,
                'jobs_opening_count' => $request->jobs_opening_count,
                'created_by' => auth()->user()->id,
            ];
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                $thumbnail = $this->uploadFile($thumbnailFile);
                $data['thumbnail'] = $thumbnail;
            }
            if ($request->hasFile('timeline')) {
                $timelineFile = $request->file('timeline');
                $timeline = $this->uploadFile($timelineFile);
                $data['timeline'] = $timeline;
            }
            
            $this->event->create($data);
            
            return redirect()->route('admin.event.list')->with('success', 'Thêm ngày hội việc làm thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(Event $event) {
        return view('pages.events.edit', compact('event'));
    }

    public function update(Event $event, RequestEvent $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'note' => $request->note,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'register_link' => $request->register_link,
                'interview_count' => $request->interview_count,
                'jobs_opening_count' => $request->jobs_opening_count,
            ];
            // nếu có upload ảnh mới
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $this->uploadFile($request->file('thumbnail'), $event->thumbnail);
                if (!$thumbnail) {
                    return redirect()->back()->with('error', 'Upload ảnh thất bại!');
                }
                $data['thumbnail'] = $thumbnail;
            }
            // nếu có upload ảnh mới
            if ($request->hasFile('timeline')) {
                $timeline = $this->uploadFile($request->file('timeline'), $event->timeline);
                if (!$timeline) {
                    return redirect()->back()->with('error', 'Upload ảnh thất bại!');
                }
                $data['timeline'] = $timeline;
            }
            $event->update($data);
            
            return redirect()->route('admin.event.list')->with('success', 'Chỉnh sửa thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Event $event) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $event->delete();

            return redirect()->back()->with('success', 'Xóa ngày hội việc làm thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function sponsors(Event $event, Request $request) {
        //lấy danh sách doanh nghiệp có thể thêm
        $query = $event->sponsors();
        $joinedSponsors = $query->pluck('sponsor_id')->toArray();
        $enterprises = $this->enterprise::select('id', 'name', 'logo')->whereNotIn('id', $joinedSponsors)->get();

        $priority = $request->priority ?? 0;
        switch ($priority) {
            case '0':
                $query->host();
                break;
            case '1':
                $query->participant();
                break;
            case '2':
                $query->silver();
                break;
            case '3':
                $query->gold();
                break;
            case '4':
                $query->diamond();
                break;
            default:
                return redirect('error');
                break;
        }
        $sponsors = $query->with('company')->paginate(10)->appends(['priority' => $priority]);

        return view('pages.events.sponsors', compact('event', 'priority', 'sponsors', 'enterprises'));
    } 

    public function addSponsors(Event $event, Request $request)
    {
        try {
            $request->validate([
                'sponsor_ids' => 'required|array',
                'sponsor_ids.*' => 'exists:enterprises,id'
            ]);
            $priority = $request->priority;
            foreach ($request->sponsor_ids as $enterpriseId) {
                Sponsor::firstOrCreate([
                    'event_id' => $event->id,
                    'sponsor_id' => $enterpriseId,
                    'priority' => $priority,
                ]);
            }

            return back()->with('success', 'Thêm doanh nghiệp thành công');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function deleteSponsor(Event $event, Sponsor $sponsor)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            if ($sponsor->event_id != $event->id) return false;
            $sponsor->delete();

            return redirect()->back()->with('success', 'Xóa doanh nghiệp thành công');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**API for client */
    public function getCurrentEvent() {
        $data = $this->event::where('status', config('util.ACTIVE_STATUS'))
            ->where('start_at', '<=', now())
            ->orderByDesc('end_at')
            ->with(['posts' => function ($query) {
                $query->orderByDesc('created_at');
            }])
            ->first();
            
        if (!$data) abort(404);
        $data->load(['sponsors.company']);

        return $this->responseApi(true, $data);
    }
}
