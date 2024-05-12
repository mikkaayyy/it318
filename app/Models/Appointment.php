<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AppointmentController;

class Appointment extends Model
{
    protected $fillable = [
        'userId',
        'schedule',
        'description',
        'price',
    ];
}