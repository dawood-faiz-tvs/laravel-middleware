<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware(['log.requests', 'custom.header']);

Route::view('home', 'home')->name('home');

Route::post('process-home', function(){
    echo "I am processed.";
})->name('process-home')->middleware('token.validity');

Route::view('login', 'login')->name('login');
Route::post('process-login', function(Request $request){
    $credentials = [
        'email' => $request->input('email'),
        'password' => $request->input('password'),
    ];

    if(Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
})->name('process-login');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'user.permissions', 'ensure.role:admin,user', 'logging', 'log.time'])->name('dashboard');