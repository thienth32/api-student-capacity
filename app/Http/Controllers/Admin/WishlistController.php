<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\Traits\TResponse;

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
    public function addWishlist(Request $request)
    {
        DB::beginTransaction();
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

            DB::commit();
            return $this->responseApi(true,  'Lưu thành công !!');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function removeWishlist(Request $request)
    {
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
}