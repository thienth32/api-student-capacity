<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Contest;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    use TResponse;
    public function __construct(
        private Wishlist $wishlist,
        private Contest $contest,
        private Post $post,
        private User $user
    ) {
    }


    /**
     * @OA\Post(
     *     path="api/v1/wishlist/add",
     *     description="Thêm lưu trữ,  Dẩy  type : 'contest' hoặc 'post'    , id : number",
     *     tags={"WishLish","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="id",
     *                  ),
     *            @OA\Property(
     *                      type="string",
     *                      property="type",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function addWishlist(Request $request, DB $dB)
    {

        $validate = Validator::make(
            $request->all(),
            [
                "id"    => "required",
                "type"  => "required",
            ],
            [
                'id.required' => 'Trường này còn thiếu !',
                'type.required' => 'Trường này còn thiếu !',
            ]
        );
        if ($validate->fails()) return $this->responseApi(false, $validate->errors());
        $dB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            if ($request->type == 'contest') {
                $contest = $this->contest::find($request->id);
                if (is_null($contest)) return $this->responseApi(true, ['error' => 'Lỗi hệ thống !!']);
                $contest->wishlist()->create(['user_id' => $user_id]);
            }
            if ($request->type == 'post') {
                $post = $this->post::find($request->id);
                if (is_null($post)) return $this->responseApi(true, ['error' => 'Lỗi hệ thống !!']);
                $post->wishlist()->create(['user_id' => $user_id]);
            }
            $dB::commit();
            return $this->responseApi(true,  'Lưu thành công !!');
        } catch (\Throwable $th) {
            $dB::rollBack();
        }
    }

    /**
     * @OA\Post(
     *     path="api/v1/wishlist/remove",
     *     description="Xóa lưu trữ ,  Dẩy  type : 'contest' hoặc 'post'    , id : number",
     *     tags={"WishLish","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="id",
     *                  ),
     *            @OA\Property(
     *                      type="string",
     *                      property="type",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function removeWishlist(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "id"    => "required",
                "type"  => "required",
            ],
            [
                'id.required' => 'Trường này còn thiếu !',
                'type.required' => 'Trường này còn thiếu !',
            ]
        );
        if ($validate->fails()) return $this->responseApi(false, $validate->errors());
        try {
            $user_id = auth('sanctum')->user()->id;
            if ($request->type == 'contest') {
                $contest = $this->contest::find($request->id);
                if (is_null($contest)) return $this->responseApi(true, ['error' => 'Lỗi hệ thống !!']);
                $contest->wishlist()->where('user_id', $user_id)->delete();
            }
            if ($request->type == 'post') {
                $post = $this->post::find($request->id);
                if (is_null($post)) return $this->responseApi(true, ['error' => 'Lỗi hệ thống !!']);
                $post->wishlist()->where('user_id', $user_id)->delete();
            }
            return $this->responseApi(true,  'Hủy lưu thành công !!');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    /**
     * @OA\Get(
     *     path="api/v1/wishlist/user",
     *     description="Danh sách lưu trữ",
     *     tags={"WishLish","Api V1"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Thể loại contest hoặc post ",
     *         required=false,
     *     ),
     *       @OA\Parameter(
     *         name="key",
     *         in="query",
     *         description="Nếu type = contest thì nhập key , key = 0 là contest , key= 1 là capacity",
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function list()
    {
        $user_id = auth('sanctum')->user()->id;
        $wishlistArr = [];
        try {
            $wishlists = $this->wishlist::where('user_id', $user_id)
                ->where(function ($query) {
                    if (request('type') == 'contest') {
                        $query->where('wishlistable_type', $this->contest::class);
                    }
                    if (request('type') == 'post') {
                        $query->where('wishlistable_type', $this->post::class);
                    }
                    return $query;
                })
                ->with(['wishlistable' => function ($q) {
                    if (request('type') == 'contest') {
                        $q->where('type', request('key'));
                    }
                    if (request('type') == 'post') {
                        $q->with([
                            'postable:id,name',
                            'postable.enterprise:enterprises.id,enterprises.name,enterprises.logo,enterprises.link_web',
                        ]);
                        // $q->with('postable.enterprise:enterprises.id,enterprises.name,enterprises.logo,enterprises.link_web');
                        // $q->with('postable.enterprise:enterprises.id,enterprises.name,enterprises.logo,enterprises.link_web');
                    }
                    return $q;
                }])
                ->get()->map(function ($q) {
                    return $q->wishlistable;
                });
            foreach ($wishlists as $key => $wishlist) {
                if ($wishlist) {
                    array_push($wishlistArr, $wishlist);
                }
            }
            return $this->responseApi(true, $wishlistArr);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function countWishlist()
    {
        $user_id = auth('sanctum')->user()->id;
        try {
            $countPost = $this->wishlist::where('user_id', $user_id)
                ->where('wishlistable_type', $this->post::class)->get()->count();
            $countContest = $this->wishlist::where(function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
                $q->where('wishlistable_type', $this->contest::class);
                return $q;
            })->with(['wishlistable'])->get()->count();
            return $this->responseApi(true, [
                'count_post' => $countPost,
                'count_contest' => $countContest,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}