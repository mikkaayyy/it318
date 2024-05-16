<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Services;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentDate = now()->format('Y-m-d');
        $services = Appointment::leftJoin('users', 'users.id', '=', 'appointments.userId') 
        ->leftJoin('services', 'services.id', '=', 'appointments.service')
        ->where('users.id','=', auth()->id())
        ->get();
        $dailySpent = Appointment::leftJoin('services as s', 's.id', '=', 'appointments.service')
                                    ->where(DB::raw('DATE(appointments.schedule)'), '=', $currentDate)
                                    ->where('appointments.status', 1)
                                    ->where('appointments.userId', auth()->id())
                                    ->sum('s.serviceprice');
        $overAllSpent = Appointment::leftJoin('services as s', 's.id', '=', 'appointments.service')
                                    ->where(DB::raw('DATE(appointments.schedule)'), '<=', $currentDate)
                                    ->where('appointments.status', 1)
                                    ->where('appointments.userId', auth()->id())
                                    ->sum('s.serviceprice');

        return view('dashboard.userindex', compact('services','dailySpent', 'overAllSpent'));
    }
    public function adminindex()
    {
        $currentDate = now()->format('Y-m-d');
        $services = Services::all();
        $dailyRevenue = Appointment::leftJoin('services as s', 's.id', '=', 'appointments.service')
                                    ->where(DB::raw('DATE(appointments.schedule)'), '=', $currentDate)
                                    ->whereIn('appointments.status', [1, 3])
                                    ->sum('s.serviceprice');
        $overAllRevenue = Appointment::leftJoin('services as s', 's.id', '=', 'appointments.service')
                                    ->where(DB::raw('DATE(appointments.schedule)'), '<=', $currentDate)
                                    ->whereIn('appointments.status', [1, 3])
                                    ->sum('s.serviceprice');
        $totalUser = User::where('role','=','user')->count();
        return view('dashboard.index', compact('services','dailyRevenue', 'overAllRevenue', 'totalUser'));
    }
    
}
