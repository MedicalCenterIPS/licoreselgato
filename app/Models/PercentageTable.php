<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PercentageTable extends Model
{
    use HasFactory;
    protected $table = "hc_production_units";
    protected $fillable = ['id', 'id_site', 'id_type', 'month', 'amount', 'company'];
}
