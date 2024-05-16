<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;

class ServiceController extends Controller
{
    public function create()
    {
        $validatedData = request()->validate([
            'servicename' => 'required|string',
            'serviceprice' => 'required|int',
            'status'=> 'int'
        ]);

        Services::create($validatedData);

        return response()->json(['success' => true]);
    }
    
    public function getService($serviceID){
        $services = Services::find($serviceID);
        return $services;
    }

    public function updateService(Request $request){

        $services = Services::find($request->editserviceID);

        
        if ($services) {
            $services->servicename = $request->editservicename;
            $services->serviceprice = $request->editserviceprice;
            $services->servicestatus = $request->editservicestatus;
            $services->save();
             

            return response()->json(['success' => true, 'message' => 'Appointment approved successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
          
        }

    }
}
