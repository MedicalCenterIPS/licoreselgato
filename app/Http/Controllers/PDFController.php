<?php

namespace App\Http\Controllers;

use App\Models\RegisterDocumentRequest;
use App\Models\RutesRequest;
use App\Models\service_request;
use App\Models\shipments;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDFRequestService($id, $option)
    {
        //$id_service = $request->input('service_id');
        $id_service = $id;

        $service = service_request::with(
            'user',
            'responsible',
            'RutesRequestDetails.originCity',
            'RutesRequestDetails.destinationCity',
            'company',
            'documentsDetails.documentRequest',
            'typeVehicle',
            'state'
        )->find($id_service);

        $routes = RutesRequest::with('originCity', 'destinationCity')->where('service_request_id', $id_service)->get();

        $shipments = shipments::with('containers')->where('service_request_id', $id_service)->get();

        $pdf = PDF::loadView('pages.pre_invoices.index', compact('service', 'routes', 'shipments'));

        $pdf->setPaper('A4', 'portrait');

        $path = public_path('storage/servicios/' . str_pad($id_service, 4, "0", STR_PAD_LEFT));

        $fileName =  'Solicitud de transporte ' . date('Y') . '-' . str_pad($id_service, 4, "0", STR_PAD_LEFT) . '.pdf';

        $pdf->save($path . '/' . $fileName);

        $datos_doc = [];
        $datos_doc['nombre'] = 'Solicitud de transporte';
        $datos_doc['service_id'] = $id_service;
        $datos_doc['process_types_id'] = 1;
        $datos_doc['document_request_id'] = 15;
        $datos_doc['extension'] = 'pdf';
        $datos_doc['file_path'] = 'servicios/' . str_pad($id_service, 4, "0", STR_PAD_LEFT) . '/' . $fileName;

        RegisterDocumentRequest::create($datos_doc);
        return 'storage/servicios/' . str_pad($id_service, 4, "0", STR_PAD_LEFT) . '/' . $fileName;
            /* dd($path . '/' . $fileName);
        if ($option == 'save') {
            return $path . '/' . $fileName;
        } else if ($option == 'generate') {
            return 'storage/servicios/' . str_pad($id_service, 4, "0", STR_PAD_LEFT) . '/' . $fileName;
        } */
        //return $pdf->download($fileName);

        /*  return view('pages.pre_invoices.index', compact('service', 'routes', 'shipments')); */
    }
}
