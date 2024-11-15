<?php

namespace App\Http\Controllers;

use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
        ]);

        $ipAddress = $request->ip();
        $apartmentId = $request->input('apartment_id');
        $today = Carbon::now()->toDateString();

        $existingView = View::where('apartment_id', $apartmentId)
            ->where('ip_address', $ipAddress)
            ->whereDate('view_date', $today)
            ->first();

        if (!$existingView) {
            View::create([
                'apartment_id' => $apartmentId,
                'ip_address' => $ipAddress,
                'view_date' => $today,
            ]);
        }

        return response()->json(['message' => 'View registered successfully!'], 200);
    }

    public function getViewcount($apartmentId)
    {
        $count = View::where('apartment_id', $apartmentId)->count();
        return response()->json(['view_count' => $count]);
    }

    public function visualizzazioniSettimanali(Request $request)
    {
        // Recupera l'apartment_id dai parametri della richiesta
        $apartmentId = $request->query('apartment_id');

        // Verifica che apartment_id sia stato passato
        if (!$apartmentId) {
            return response()->json(['error' => 'apartment_id is required'], 400);
        }

        $dataInizio = Carbon::now()->subDays(7)->startOfDay();  // Data di 7 giorni fa
        $dataFine = Carbon::now()->endOfDay();  // Data odierna

        // Supponiamo tu abbia una tabella 'visualizzazioni' con una colonna 'created_at' e 'apartment_id'
        // Modifica il codice a seconda della tua struttura dati

         $visualizzazioni = DB::table('views')
            ->where('apartment_id', $apartmentId)
            ->whereBetween('view_date', [$dataInizio, $dataFine])
            ->select(DB::raw('DATE(view_date) as data, COUNT(*) as count'))
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        // Prepara un array con tutte le date dell'ultima settimana
        $dateSettimana = [];
        $countsSettimana = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays(6 - $i)->format('Y-m-d');
            $dateSettimana[$date] = 0; // Imposta 0 come valore predefinito
        }

        // Riempiamo i valori reali dalle visualizzazioni
        foreach ($visualizzazioni as $visualizzazione) {
            $dateSettimana[$visualizzazione->data] = $visualizzazione->count;
        }

       return response()->json([
            'labels' => array_keys($dateSettimana),
            'values' => array_values($dateSettimana),
        ]);
    }
}
