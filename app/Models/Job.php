<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

//By convention classname 'Job' maps to a table name called 'jobs'
class Job extends Model {
    use HasFactory;
    
    //Declare the table name in the DB: job_listings
    protected $table = 'job_listings';
    
}