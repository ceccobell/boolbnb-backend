<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        // Recupera tutti i servizi dal database e li riordina in modo alfabetico

        $services = Service::orderBy('service_name', 'asc')->get();

        // Restituisce i servizi in formato JSON
        return response()->json($services);
    }
}
