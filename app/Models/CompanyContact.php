<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    use HasFactory;

    protected $tables = "company_contacts";

    protected $fillable = [
        'full_name',
        'company_name',
        'email',
        'status',
        'phone',
    ];

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
    ];
}
