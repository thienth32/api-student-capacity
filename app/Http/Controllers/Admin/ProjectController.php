<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enterprise;
use App\Models\Project;
use App\Models\Topic;
use App\Models\User;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    use TUploadImage, TResponse;
    protected $project;
    protected $mentor;
    protected $enterprise;
    protected $topic;

    public function __construct(Project $project, User $mentor, Enterprise $enterprise, Topic $topic) {
        $this->project = $project;
        $this->mentor = $mentor;
        $this->enterprise = $enterprise;
        $this->topic = $topic;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->project::where('name', 'like', "%$keyword%");

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    public function index(Request $request) {
        try {
            $projects = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            $projects->load(['topics', 'enterprises', 'mentors']);
            return view('pages.project.list', compact('projects'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create() {
        $topics = $this->topic::get();
        $enterprises = $this->enterprise::get();
        $mentors = $this->mentor::select('id', 'name', 'email')
            ->where('status', 1)
            ->whereHas('roles', function (Builder $query) {
                $query->where('id', config('util.MENTOR_ROLE'));
            })
            ->get();

        return view('pages.project.create', compact('mentors', 'topics', 'enterprises'));
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            //tạo project
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'contact_name' => $request->contact_name,
                'status' => $request->status,
            ];
            $thumbnail = $this->uploadFile($request->file('thumbnail'));
            if (!$thumbnail)  return redirect()->back()->with('error', 'Upload ảnh thất bại !');
            $data['thumbnail'] = $thumbnail;
            $project = $this->project->create($data);
            
            //lưu thông tin doanh nghiệp đồng hành
            $enterpriseIds = $request->enterprise_ids;
            $project->enterprises()->sync($enterpriseIds);

            //lưu thông tin mentors dự án
            $mentorIds = $request->mentor_ids;
            $project->mentors()->sync($mentorIds);

            //lưu thông tin lĩnh vực
            $topicIds = $request->topic_ids;
            $project->topics()->sync($topicIds);
            
            DB::commit();

            return redirect()->route('admin.project.list')->with('success', 'Thêm dự án thành công');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(Request $request, Project $project) {
        $topics = $this->topic::get();
        $enterprises = $this->enterprise::get();
        $mentors = $this->mentor::select('id', 'name', 'email')
            ->where('status', 1)
            ->whereHas('roles', function (Builder $query) {
                $query->where('id', config('util.MENTOR_ROLE'));
            })
            ->get();
        $selectedEnterprises = $project->enterprises->pluck('id')->toArray();
        $selectedMentors = $project->mentors->pluck('id')->toArray();
        $selectedTopics = $project->topics->pluck('id')->toArray();
        
        return view('pages.project.edit', compact(
            'project', 
            'mentors', 
            'topics', 
            'enterprises', 
            'selectedEnterprises', 
            'selectedMentors',
            'selectedTopics'
        ));
    }

    public function update(Request $request, Project $project) {
        try {
            DB::beginTransaction();
            //tạo project
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'contact_name' => $request->contact_name,
                'status' => $request->status,
            ];
             // nếu có upload ảnh mới
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $this->uploadFile($request->file('thumbnail'), $project->thumbnail);
                if (!$thumbnail) {
                    return redirect()->back()->with('error', 'Upload ảnh thất bại!');
                }
                $data['thumbnail'] = $thumbnail;
            }
            $project->update($data);
            
            //lưu thông tin doanh nghiệp đồng hành
            $enterpriseIds = $request->enterprise_ids;
            $project->enterprises()->sync($enterpriseIds);

            //lưu thông tin mentors dự án
            $mentorIds = $request->mentor_ids;
            $project->mentors()->sync($mentorIds);

            //lưu thông tin lĩnh vực
            $topicIds = $request->topic_ids;
            $project->topics()->sync($topicIds);
            
            DB::commit();

            return redirect()->route('admin.project.list')->with('success', 'Sửa dự án thành công');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    } 

    public function destroy(Project $project) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            DB::beginTransaction();
            $project->topics()->detach();
            $project->mentors()->detach();
            $project->enterprises()->detach();

            $project->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Xóa dự án thành công');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**API for client */
    public function getProjects() {
        $data = $this->project::where('status', 1)
            ->with('topics', 'enterprises', 'mentors')->paginate(10);
        if (!$data) abort(404);

        return $this->responseApi(true, $data);
    }
}
