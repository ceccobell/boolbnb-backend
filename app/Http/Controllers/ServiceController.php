<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        // Recupera tutti i servizi dal database
        $services = Service::all();

        // Restituisce i servizi in formato JSON
        return response()->json($services);
    }
}
