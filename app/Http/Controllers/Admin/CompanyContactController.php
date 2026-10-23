<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyContact;
use App\Services\Traits\TResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyContactController extends Controller
{
    use TResponse;
    private $companyContact;

    public function __construct(CompanyContact $companyContact)
    {
        $this->companyContact = $companyContact;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $status = $request->has('status') ? $request->status : "";

        $query = $this->companyContact::where('company_name', 'like', "%$keyword%");
        if ($status && $status != "") {
            $query->where('status', $status);
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    public function index(Request $request)
    {
        try {
            $companyContacts = $this->getList($request)
                ->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

            return view('pages.company-contact.list', compact('companyContacts'));
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    public function un_status(CompanyContact $companyContact)
    {
        try {
            $data = $this->updateStatus($companyContact, config('util.COMPANY_CONTACT.STATUS.NEW'));
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    
    public function re_status(CompanyContact $companyContact)
    {
        try {
            $data = $this->updateStatus($companyContact, config('util.COMPANY_CONTACT.STATUS.REPLIED'));
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    private function updateStatus($companyContact, $status)
    {
        if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) throw new \Exception("Bạn không đủ thẩm quyền ! ");
        $companyContact->update(['status' => $status]);
        return $companyContact;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyContact  $companyContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyContact $companyContact)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $companyContact->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }

    /* apiCreateCompanyContact */
    public function apiSaveCompanyContact(Request $request) 
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullName' => 'required',
                'companyName' => 'required',
                'email' => 'required|email',
                'phone' => [
                    'required',
                    'regex: /(?:\+84|0084|0)[235789][0-9]{1,2}[0-9]{7}(?:[^\d]+|$)/',
                ]
            ],
            [
                'fullName.required' => 'Họ tên không được bỏ trống',
                'companyName.required' => 'Tên công ty không được bỏ trống',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'phone.required' => 'SĐT không được để trống',
                'phone.regex' => 'SĐT không đúng định dạng',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => $validator->errors()
            ]);
        }

        try {
            $this->companyContact::create([
                'full_name' => $request->fullName,
                'company_name' => $request->companyName,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => config('util.COMPANY_CONTACT.STATUS.NEW'),
            ]);
         
            return $this->responseApi(true, 'Gửi thành công');
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }
}
