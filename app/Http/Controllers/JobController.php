<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller {
    public function index() {
        //Pagination with page numbers
        //$jobs = Job::with('employer')->paginate(10);

        //Pagination with Previous and Next
        //$jobs = Job::with('employer')->simplePaginate();

        //Pagination with cursor
        //latest() adds a order by creation date to the SQL query
        $jobs = Job::with('employer')->latest()->cursorPaginate();

        //Instead of Job::all() we eagerly fetch all employer records to avoid n+1 problem
        //You can disable lazy loading at the entire application level in AppServiceProvider.php
        //
        //'employer' is the relationship name (the name of the function in Job.php)
        //$jobs = Job::with('employer')->get();

        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function show(Job $job) {
        return view('jobs.show', ['job' => $job]);
    }

    public function create() {
        return view(view: 'jobs.create');
    }
    

    public function store() {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);
    
        $newJob = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);
        return redirect('/jobs');
    }

    public function edit(Job $job) {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job) {
         // validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        // authorize (later)

        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        // redirect
        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job) {
        // authorize (later)

        $job->delete();

        // redirect
        return redirect('/jobs');
    }
}
