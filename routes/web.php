<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Models\Job;


// This is a short hand for the commented code below
Route::view('/', 'home');

/* Route::get('/', function () {
    return view('home');
}); */

Route::view('/contact', 'contact');


Route::controller(JobController::class)->group(function() {
    Route::get('/jobs/create', 'create');
    Route::get('/jobs', 'index');
    Route::get('/jobs/{job}', 'show');
    Route::post('/jobs', 'store');
    Route::get('/jobs/{job}/edit', 'edit');
    Route::patch('/jobs/{job}', 'update');
    Route::delete('/jobs/{job}', 'destroy');
});

// If you have all the resource methods (create, index, show, store, edit, update, destroy), you can simply have the following line and
// remove lines between 19 and 26
// Route:resource('jobs', JobController::class);

// If you just want to implement few routes, you can specify them:
// Route::resource('jobs', JobController::class, ['only' => ['index', 'show']]);


// Auth
Route::get('/register', [RegisterUserController::class, 'create']);
Route::post('/register', [RegisterUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);