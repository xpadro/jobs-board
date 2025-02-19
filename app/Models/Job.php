<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

//By convention classname 'Job' maps to a table name called 'jobs'
class Job extends Model {
    use HasFactory;

    //Not recommended. Use $fillable to include fields or $guarded specifying fields that should be protected (e.g. $isAdmin)
    protected $guarded = [];

    //Declare the table name in the DB: job_listings
    protected $table = 'job_listings';

    //Defines a belongsTo relation with Employer table, which let's you retrieve the employer information for this job.
    //The call to $myJob-employer triggers a new SQL query (lazy loading)
    //For example:
    // $myJob->employer->name;
    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function tags() {
        //We specify the column explicitly. Otherwise, by convention it will try to find column named 'job_id'
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listing_id");
    }
    
}