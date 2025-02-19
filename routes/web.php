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

    return view('jobs.index', ['jobs' => $jobs]);
});

Route::get('/jobs/create', function ()  {
    return view(view: 'jobs.create');
});

Route::get('/jobs', function ()  {
    //Pagination with page numbers
    //$jobs = Job::with('employer')->paginate(10);

    //Pagination with Previous and Next
    //$jobs = Job::with('employer')->simplePaginate();

    //Pagination with cursor
    //latest() adds a order by creation date to the SQL query
    $jobs = Job::with('employer')->latest()->cursorPaginate();

    return view('jobs.index', ['jobs' => $jobs]);
});

Route::get('/jobs/{id}', function ($id)  {
    $job = Job::find($id);
    
    return view('jobs.show', ['job' => $job]);
});

Route::post('/jobs', function () {
    $newJob = Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);
    return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});
