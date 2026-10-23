<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    private $topic;

    public function __construct(Topic $topic) 
    {
        $this->topic = $topic;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $topics = $this->topic::paginate(20);

            return view('pages.topic.list', compact('topics'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.topic.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = [
                'name' => $request->name,
            ];
            $this->topic->create($data);
            
            return redirect()->route('admin.topic.list')->with('success', 'Thêm lĩnh vực thành công');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        return view('pages.topic.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        try {
            $data = [
                'name' => $request->name,
            ];
            $topic->update($data);
            
            return redirect()->route('admin.topic.list')->with('success', 'Sửa lĩnh vực thành công');;
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $topic->delete();

            return redirect()->back()->with('success', 'Xóa lĩnh vực thành công');;
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
