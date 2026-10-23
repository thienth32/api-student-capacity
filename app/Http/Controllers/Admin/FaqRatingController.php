<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqRating;
use App\Models\FrequentlyAskedQuestion;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

class FaqRatingController extends Controller
{
    use TResponse;
    private $faqRating;

    public function __construct(FaqRating $faqRating)
    {
        $this->faqRating = $faqRating;
    }

    public function destroy(FaqRating $faqRating) 
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $faqRating->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }

    //api rating
    public function apiRate(Request $request, FrequentlyAskedQuestion $faq) {
        try {
            $this->faqRating::create([
                'faq_id' => $faq->id,
                'type' => $request->type,
                'content' => $request->content,
            ]);

            return $this->responseApi(true, 'Gửi thành công');
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }
}
