<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settings extends Model
{
    use HasFactory;
    protected $table = "hc_settings";
    protected $fillable = ['valor', 'user_id'];
    protected $primaryKey = 'id';
}
