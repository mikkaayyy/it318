<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AppointmentController;

class Appointment extends Model
{
    protected $fillable = ['client_name', 'appointment_time', 'service_type', 'price'];
}
?>