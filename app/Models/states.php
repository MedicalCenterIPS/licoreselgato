<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class states extends Model
{
    use HasFactory;

    protected $table = "hc_states";
    protected $fillable = [
        'state'
    ];
    protected $primaryKey = 'id';
}
