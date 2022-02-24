<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
    use HasFactory;

    public function getTaiKhoan(){
        $products = [
            [
                "id" => 1,
                "name" => "poly"
            ],
            [
                "id" => 2,
                "name" => "Btec"
            ],
            [
                "id" => 3,
                "name" => "melburn"
            ],
    
        ];
        return $products;
    }
}
