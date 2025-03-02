<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Disable lazy loading
        Model::preventLazyLoading();

        //In case you want to change default styling (tailwind) of pagination element
        //Paginator::useBootstrap();

        // A gate allows or denies access based on current logged user '$user'
        // If the gate returns 'false', it will return a 403 Forbidden
        // By defining the gate here, it is visible throughout all the application
        // Commented out in benefit of Job policy (JobPolicy class)
        /* Gate::define('edit-job', function(User $user, Job $job) {
            // function '$model->is()' compares if the ID field of both models match and they both belong to the same table
            return $job->employer->user->is($user);
        }); */
    }
}
