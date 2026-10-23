<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FaqCategoryController extends Controller
{
    use TResponse;
    private $faqCategory;

    public function __construct(FaqCategory $faqCategory)
    {
        $this->faqCategory = $faqCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = $this->faqCategory::roots()
                ->with(['faqs', 'children'])
                ->orderBy('name')
                ->get();

            return view('pages.faq.categories.list', compact('categories'));
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCates = $this->faqCategory::roots()->get();

        return view('pages.faq.categories.create', compact('parentCates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:faq_categories,name',
            ],
            [
                'name.required' => 'Không được bỏ trống tên',
                'name.unique' => 'Tên danh mục bị trùng',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $this->faqCategory::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
            ]);

            return Redirect::route('admin.faq_category.list');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqCategory $faqCategory)
    {
        $parentCates = $this->faqCategory::roots()
            ->where('id', '<>', $faqCategory->id)
            ->get();

        return view('pages.faq.categories.edit', compact('faqCategory', 'parentCates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaqCategory $faqCategory)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    Rule::unique('faq_categories')->ignore($faqCategory),
                ],
            ],
            [
                'name.required' => 'Không được bỏ trống tên',
                'name.unique' => 'Tên danh mục bị trùng',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $faqCategory->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
            ]);

            return Redirect::route('admin.faq_category.list');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaqCategory $faqCategory)
    {
        try {
            if ($faqCategory->children()->count() != 0) { //nếu là danh mục cha mà có danh mục con thì ko cho xóa
                return false;
            } 
            if ($faqCategory->parent()->count() != 0 && $faqCategory->faqs()->count() != 0) {
                return false;
            }
            // if ($faqCategory->children())
            $faqCategory->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * API for frontend
     */
    public function apiList()
    {
        try {
            $categories = $this->faqCategory::roots()
                ->with(['children'])
                ->get();
            
            return $this->responseApi(true, $categories);
        } catch (\Throwable $th) {
            return false;
        }
    }

}
