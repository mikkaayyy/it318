<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
// */
// Auth::routes();
// Route::get('/dashboard',[App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
// Auth::routes();
// Route::post('/login', [login::class, 'login'])->middleware('throttle_login')
// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');
// Auth::routes();
 
Route::get('/', function () {
    return view('/welcome');
 });

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\login;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppointmentController;
use App\Models\Appointment;


            
Route::get('/login', [login::class, 'viewlogin']);
Route::post('google/login', [SessionsController::class, 'verify_login_email'])->name('google.authorization');
Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/customer', [ClientsController::class, 'store'])->name('customers.store');
Route::get('/customer', [ClientsController::class, 'create'])->name('customer.create');
Route::post('/submit-form', [CreateController::class, 'submitForm'])->name('submit.form');
Route::get('/fetch-data', [CreateController::class, 'fetchData'])->name('fetch.data');

// Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
// Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
// Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');


Route::post('clients', function () {
    return view('pages.laravel-examples.clients');
})->name('clients.post'); 

Route::get('/appointments', [AppointmentController::class, 'index'])->middleware('auth')->name('appointments.index');
Route::get('/appointments/admin', [AppointmentController::class, 'admin'])->middleware('auth')->name('appointments.admin');
// Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('appointments/create', [AppointmentController::class, 'store'])->middleware('auth')->name('appointments-store');
Route::post('/approve_appointment/{appointmentId}', [AppointmentController::class, 'approve_appointment']);
Route::post('/reject_appointment/{usersId}', [AppointmentController::class, 'reject_appointment']);
Route::post('appointments/approve',[AppointmentController::class, ]);




Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('sign-up');
Route::post('store-sign-up', [RegisterController::class, 'store'])->middleware('guest')->name('register');
Route::get('sign-in', [SessionsController::class, 'create'])->name('login');

Route::post('verify-sign-in', [SessionsController::class, 'store'])->name('sign-in');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () { return view('sessions.password.verify');})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) { return view('sessions.password.reset', ['token' => $token]);})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile-auth');


Route::group(['middleware' => 'auth'], function () {
Route::get('clients', [ClientController::class, 'index'])->middleware('auth')->name('clients');

Route::get('billing', function () { return view('pages.billing');})->name('billing');
Route::get('services', function () { return view('pages.services');})->name('services');
Route::get('rtl', function () { return view('pages.rtl');})->name('rtl');
Route::get('virtual-reality', function () { return view('pages.virtual-reality');})->name('virtual-reality');
Route::get('notifications', function () { return view('pages.notifications');})->name('notifications');
Route::get('static-sign-in', function () { return view('pages.static-sign-in');})->name('static-sign-in');
Route::get('static-sign-up', function () { return view('pages.static-sign-up');})->name('static-sign-up');
Route::get('user-profile', function () { return view('pages.laravel-examples.user-profile');})->name('user-profile');
});