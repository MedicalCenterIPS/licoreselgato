<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    use HasFactory;
    protected $table = "hc_companies";
    protected $fillable = ['company'];
    protected $primaryKey = 'id';
}