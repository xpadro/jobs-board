<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;


Route::get('/', function () {
    return view('home');
});

Route::get('/jobs_no_pagination', function ()  {
    //Instead of Job::all() we eagerly fetch all employer records to avoid n+1 problem
    //You can disable lazy loading at the entire application level in AppServiceProvider.php
    //
    //'employer' is the relationship name (the name of the function in Job.php)
    $jobs = Job::with('employer')->get();

    return view('jobs', ['jobs' => $jobs]);
});

Route::get('/jobs', function ()  {
    //Pagination with page numbers
    //$jobs = Job::with('employer')->paginate(10);

    //Pagination with Previous and Next
    //$jobs = Job::with('employer')->simplePaginate();

    //Pagination with cursor
    $jobs = Job::with('employer')->cursorPaginate();

    return view('jobs', ['jobs' => $jobs]);
});

Route::get('/jobs/{id}', function ($id)  {
    $job = Job::find($id);
    
    return view('job', ['job' => $job]);
});

Route::get('/contact', function () {
    return view('contact');
});
