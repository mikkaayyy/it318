<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $currentUser = auth()->id();
        $appointments = Appointment::leftJoin('users', 'users.id', '=', 'appointments.userId') 
                                    ->where('users.id','=', $currentUser)
                                    ->get();
        $activePage = 'myappointment';
        return view('appointments.index', compact('appointments', 'activePage'));
    }
    
    public function admin()
    {
        $appointments = Appointment::leftJoin('users', 'users.id', '=', 'appointments.userId') 
                                    ->get();
        $activePage = 'allappointment';
        return view('appointments.indexadmin', compact('appointments', 'activePage'));
    }


    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $validatedData = request()->validate([
            'schedule' => 'required|date_format:Y-m-d\TH:i',
            'description' => 'required|string',

        ]);
        $validatedData['userId'] = auth()->id();

        Appointment::create($validatedData);

        return response()->json(['success' => true]);
    }

    public function approve_appointment($appointmentId)
    {
        
        $appointment = Appointment::find($appointmentId);
        dd($appointmentId);
        

        if ($appointment) {
            $appointment->status = 'Approved';
            $appointment->save();
            return response()->json(['success' => true, 'message' => 'Appointment approved successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
          
        }
    }
    
    

    


    public function reject_appointment($userId)
    {
        $appointment = Appointment::find($userId);
        
        if ($appointment) {
            $appointment->status = 'Rejected';
            $appointment->save();
            return response()->json(['success' => true, 'message' => 'Appointment rejected successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
        }
    }
    
    


}
