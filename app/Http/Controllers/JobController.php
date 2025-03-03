<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

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

        // Send email
        // To configure sender and SMTP settings, go to config/mail.php
        // For testing purposes, you can register to https://mailtrap.io/
        // Laravel is smart enough to resolve the email from the user model (newJob->employer->user)
        //Mail::to($newJob->employer->user)->send(new JobPosted($newJob));

        // Instead of sending the mail synchronously, we send it to a queue
        Mail::to($newJob->employer->user)->queue(new JobPosted($newJob));

        return redirect('/jobs');
    }

    public function edit(Job $job) {
        // This is no longer necessary since the Gate is already handling it (returning 403)
        /* if (Auth::guest()) {
            return redirect('/login');
        } */
        
        // Calls the gate named 'edit-job' defined in AppServiceProvider
        // If you put it here, it will only apply to this endpoint. Has been moved to routes
        //Gate::authorize('edit-job', $job);

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
