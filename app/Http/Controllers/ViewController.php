<?php

namespace App\Http\Controllers;

use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
