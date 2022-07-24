<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="OpenApi Capacity Fpoly",
 *      description="OpenApi Capacity Fpoly<br>
 *      ✅NOTE✅
 *      Note: Khi sử dụng api authentication v1 cần nhập token bearer phần Authorize
 *      Note: Tìm kiếm api theo các tag
 *      Note: Thiếu , gặp bug -> chụp ảnh gửi cho BE sửa 🔧
 *      ✅END NOTE✅",
 *      @OA\Contact(
 *              email="",
 *       ),
 * )
 * @OAS\SecurityScheme(
 *      securityScheme="bearer_token",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
