<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Jobs\TranslateJob;
use App\Mail\JobPosted;
use Illuminate\Support\Facades\Route;
use App\Models\Job;
use Illuminate\Support\Facades\Mail;

// This is a short hand for the commented code below
Route::view('/', 'home');

/* Route::get('/', function () {
    return view('home');
}); */

Route::view('/contact', 'contact');

Route::get('/jobs/create', [JobController::class, 'create']);
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{job}', [JobController::class, 'show']);

// Must be signed-in
Route::post('/jobs', [JobController::class, 'store'])
    ->middleware('auth');

// Must be signed-in and the gate 'edit-job' must succeed
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->middleware('auth')
    ->can('edit', 'job');

Route::patch('/jobs/{job}', [JobController::class, 'update'])
    ->middleware('auth')
    ->can('edit', 'job'); // Refers to 'edit' policy in JobPolicy class

Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
    ->middleware('auth')
    ->can('edit', 'job');

// If you have all the resource methods (create, index, show, store, edit, update, destroy), you can simply have the following line and
// remove lines between 19 and 26
// Route:resource('jobs', JobController::class);

// If you just want to implement few routes, you can specify them:
// Route::resource('jobs', JobController::class, ['only' => ['index', 'show']]);


// Auth
Route::get('/register', [RegisterUserController::class, 'create']);
Route::post('/register', [RegisterUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);


// Test - Send some work to a queue
// For testing purpose, run 'php artisan queue:work' on terminal to process the jobs on the queue
Route::get('test_queue', function() {
    dispatch(function() {
        logger('hello from the queue');
    });

    return 'Done';
});


// Using a Job instead of a closure
Route::get('test_queue2', function() {
    $job = Job::first();

    // This only dispatches the job. You still need a worker to deal with it. For example 'php artisan queue:work'
    TranslateJob::dispatch($job);

    return 'Done';
});
