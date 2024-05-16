<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Services;
use App\Models\Notification;

class AppointmentController extends Controller
{
    public function index()
    {
        $currentUser = auth()->id();
        $services = Services::all();
        $appointments = Appointment::leftJoin('users  as s', 's.id', '=', 'appointments.userId') 
                                    ->leftJoin('services', 'services.id', '=', 'appointments.service')
                                    ->where('s.id','=', $currentUser)
                                    ->select('s.*', 'services.*', 'appointments.id as appointmentID', 'appointments.*' )
                                    ->get();
        return view('appointments.index', compact('appointments','services'));
    }
    
    public function admin()
    {
        $services = Services::all();
        $appointments = Appointment::leftJoin('users as s', 's.id', '=', 'appointments.userId')
                                    ->leftJoin('services', 'services.id', '=', 'appointments.service')
                                    ->select('s.*', 'services.*', 'appointments.id as appointmentID', 'appointments.*' )
                                    ->get();
        return view('appointments.indexadmin', compact('appointments','services'));
    }


    public function getAppointment($appID)
    {
        $appointments = Appointment::leftJoin('users', 'users.id', '=', 'appointments.userId') 
                                    ->leftJoin('services', 'services.id', '=', 'appointments.service')
                                    ->where('appointments.id', $appID)
                                    ->get();

        return $appointments;
    }
    public function updateAppointment(Request $request)
    {
        $Appointment = Appointment::find($request->editAppID);
        if ($Appointment) {
            $Appointment->service = $request->editservice;
            $Appointment->schedule = $request->editschedule;
            $Appointment->save();
             

            return response()->json(['success' => true, 'message' => 'Appointment approved successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
          
        }
    }
    public function deleteAppointment($appId)
    {
        $Appointment = Appointment::find($appId);
        if ($Appointment) {
            $Appointment->delete();
             
            return response()->json(['success' => true, 'message' => 'Appointment deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
          
        }
    }

    public function store(Request $request)
    {
        $validatedData = request()->validate([
            'schedule' => 'required|date_format:Y-m-d\TH:i',
            'service' => 'required|int',
            'price' => 'required|int',
            'status'=> 'int'
        ]);
        $validatedData['userId'] = auth()->id();
        Appointment::create($validatedData);

        $service = Services::find(request()->service);
        $notificationData = [
            'notifcationFrom' => auth()->id(),
            'notifcationTo' => 1,
            'notifcationSubject' => 'New Appointment',
            'notifcationBody' => 'You have new appointment for '. $service->servicename .' on ' .Carbon::parse(request()->schedule)->format('F d Y h:ia'),
            'notificationStatus' => 0,
        ];

        Notification::create($notificationData);
        return response()->json(['success' => true]);
    }

    public function approve_appointment($appointmentId)
    {
        $appointmentId = intval($appointmentId);
        $appointment = Appointment::leftJoin('services as s','s.id', '=', 'appointments.service')->find($appointmentId);
        $appointmentUpdate = Appointment::find($appointmentId);
        
        $notificationData = [
            'notifcationFrom' => auth()->id(),
            'notifcationTo' => $appointment->userId,
            'notifcationSubject' => 'Appointment Approved',
            'notifcationBody' => 'You appointment '. $appointment->servicename .' on ' .Carbon::parse($appointment->schedule)->format('F d Y h:ia'). ' has been approved',
            'notificationStatus' => 0,
        ];

        if ($appointmentUpdate) {
            $appointmentUpdate->status = 1;
            $appointmentUpdate->save();
             
            Notification::create($notificationData);
            return response()->json(['success' => true, 'message' => 'Appointment approved successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
          
        }
    }
    
    
    public function reject_appointment($appointmentId)
    {
        $appointmentId = intval($appointmentId);
        $appointment = Appointment::leftJoin('services as s','s.id', '=', 'appointments.service')->find($appointmentId);
        $appointmentUpdate = Appointment::find($appointmentId);
        // $appointment = Appointment::where('userId', $appointment->userId)->first();

        $notificationData = [
            'notifcationFrom' => auth()->id(),
            'notifcationTo' => $appointment->userId,
            'notifcationSubject' => 'Appointment Rejected',
            'notifcationBody' => 'You appointment '. $appointment->servicename .' on ' .Carbon::parse($appointment->schedule)->format('F d Y h:ia'). ' has been rejected',
            'notificationStatus' => 0,
        ];
        if ($appointmentUpdate) {
            $appointmentUpdate->status = 2;
            $appointmentUpdate->save();

            Notification::create($notificationData);
            return response()->json(['success' => true, 'message' => 'Appointment rejected successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
        }
    }
    
}  

