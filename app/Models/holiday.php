<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $table = "hc_holidays";

    protected $fillable = [
        'holiday',
        'date_holiday',
    ];
}
