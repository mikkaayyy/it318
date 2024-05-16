<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function getAll(){
        if(auth()->user()->role == 'admin'){
            $id= 1;
        }else{
            $id= auth()->id();
        }
        $allnotifcation = Notification::where('notifcationTo', $id)
        ->get();
        
        return $allnotifcation;
    }
    public function getUnRead(){

        if(auth()->user()->role == 'admin'){
            $id= 1;
        }else{
            $id= auth()->id();
        }
        $unreadnotifcation = Notification::where('notificationStatus', 0)
                                    ->where('notifcationTo', $id)
                                    ->count();

        return $unreadnotifcation;
    }
    public function readAll(){

        if(auth()->user()->role == 'admin'){
            $id= 1;
        }else{
            $id= auth()->id();
        }
        $unreadNotifications = Notification::where('notifcationTo', $id)
                                            ->where('notificationStatus', 0)
                                            ->get();

        foreach ($unreadNotifications as $notification) {
            $notification->notificationStatus = 1;
            $notification->save();
        }

        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
