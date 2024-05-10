<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        $activePage = 'appointment';
        return view('appointments.index', compact('appointments', 'activePage'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_name' => 'required|string',
            'appointment_time' => 'required|date',
            'service_type' => 'required|string',
            'price' => 'required|numeric',
        ]);

        Appointment::create($validatedData);

        return response()->json(['success' => true]);
    }
}
