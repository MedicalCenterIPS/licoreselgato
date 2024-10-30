<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceConsumptionRecord extends Model
{
    use HasFactory;

    // Especifica la tabla correspondiente a este modelo
    protected $table = 'hc_service_consumption_records';

    // Especifica los atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_site_service',       
        'account',       
        'company_service_consumption',       
        'month',       
        'year',         
        'amount',         
        'measurement_unit', 
        'type_service', 
    ];
}
