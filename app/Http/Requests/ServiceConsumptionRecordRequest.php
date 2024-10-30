<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceConsumptionRecordRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Cambia esto a true si deseas permitir la solicitud sin verificación adicional.
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_site_service' => 'required|string',
            'account' => 'required|string',
            'month' => 'required|string', 
            'year' => 'required|integer|min:2000', 
            'amount' => 'required|numeric',
            'company_service_consumption' => 'required|string',
            'type_service' => 'required|string',
        ];
    }

    /**
     * Mensajes de error personalizados.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'site.required' => 'El campo sitio es obligatorio.',
            'account.required' => 'El campo cuenta es obligatorio.',
            'month.required' => 'El campo mes es obligatorio.',
            'year.required' => 'El campo año es obligatorio.',
            'amount.required' => 'El campo cantidad es obligatorio.',
            'amount.numeric' => 'La cantidad debe ser un número.',
            'company_service_consumption.required' => 'El campo consumo del servicio de la empresa es obligatorio.',
            'type_service.required' => 'El campo tipo de servicio es obligatorio.',
        ];
    }
}
