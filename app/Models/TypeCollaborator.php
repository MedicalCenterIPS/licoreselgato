<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCollaborator extends Model
{
    use HasFactory;
    protected $table = "hc_type_collaborators";
    protected $fillable = ['id', 'category'];
}
