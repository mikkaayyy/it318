<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AppointmentController;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    protected $fillable = [
        'userId',
        'schedule',
        'service',
        'price',
        'status',
    ];
    
    // use SoftDeletes;

}