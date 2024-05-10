<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CustomerController;

class Customer extends Model
{
    protected $fillable = ['name', 'email'];
    
}





