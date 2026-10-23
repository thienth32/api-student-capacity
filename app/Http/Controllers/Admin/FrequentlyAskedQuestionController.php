<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\FrequentlyAskedQuestion;
use App\Services\Builder\Builder;
use App\Services\Traits\TResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FrequentlyAskedQuestionController extends Controller
{
    use TResponse;
    private $faq;
    private $faqCategory;

    public function __construct(FrequentlyAskedQuestion $faq, FaqCategory $faqCategory) {
        $this->faq = $faq;
        $this->faqCategory = $faqCategory;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $categoryId = $request->has('category_id') ? $request->category_id : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->faq::where('question', 'like', "%$keyword%")
            ->with(['upRatings','downRatings', 'category.parent']);
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        if ($categoryId != "") {
            $rootCates = $this->faqCategory::roots()->with(['children'])->get();
            if (in_array($categoryId, $rootCates->pluck('id')->toArray())) {
                //nếu lọc theo root category thì sẽ lấy cả của category con và chính nó
                $childrenCateIds = $rootCates->first(function ($item) use ($categoryId) {
                    return $item->id == $categoryId;
                })->children->pluck('id')->toArray();
                array_push($childrenCateIds, $categoryId);
                $query->whereIn('category_id', $childrenCateIds);
            } else {
                $query->where('category_id', $categoryId);
            }
        } 
        
        return $query;
    }

    /**ADMIN CRUD */ 
    public function index(Request $request) {
        try {
            $categories = $this->faqCategory::roots()
                ->with(['children'])
                ->orderBy('name')
                ->get();
            $faqs = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            
            return view('pages.faq.list', compact('faqs', 'categories'));
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function create() {
        $categories = $this->faqCategory::roots()
            ->with(['children'])
            ->orderBy('name')
            ->get();

        return view('pages.faq.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                'answer' => 'required',
                'category_id' => 'required|numeric',
            ],
            [
                'question.required' => 'Chưa nhập trường này',
                'answer.required' => 'Chưa nhập trường này',
                'category_id.required' => 'Chưa nhập trường này',
                'category_id.numeric' => 'Sai định dạng!',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $this->faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'category_id' => $request->category_id,
            ]);

            return Redirect::route('admin.faq.list');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function edit(FrequentlyAskedQuestion $faq) {
        $categories = $this->faqCategory::roots()
            ->with(['children'])
            ->orderBy('name')
            ->get();

        return view('pages.faq.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, FrequentlyAskedQuestion $faq)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                'answer' => 'required',
                'category_id' => 'required|numeric',
            ],
            [
                'question.required' => 'Chưa nhập trường này',
                'answer.required' => 'Chưa nhập trường này',
                'category_id.required' => 'Chưa nhập trường này',
                'category_id.numeric' => 'Sai định dạng!',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'category_id' => $request->category_id,
            ]);

            return Redirect::route('admin.faq.list');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function destroy(FrequentlyAskedQuestion $faq) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $faq->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**API for client */
    public function getListFAQ(Request $request) {
        $data = $this->getList($request)
            ->paginate(20);

        if (!$data) abort(404);
        
        return $this->responseApi(true, $data);
    }

    public function apiDetail(FrequentlyAskedQuestion $faq)
    {
        if (!$faq) abort(404);
        $faq->increment('view');
        $faq->load(['category']);

        return $this->responseApi(true,$faq);
    }

    public function apiRelate(Request $request, FrequentlyAskedQuestion $faq)
    {
        $data = $this->getList($request)
            ->where('category_id', $faq->category_id)
            ->where('id', '<>', $faq->id)
            ->paginate(request('limit') ?? 6);
        
        return $this->responseApi(true, $data); 
    }
}
