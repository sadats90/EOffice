<?php

namespace App\Providers;

use App\Models\WorkHandover;
use App\Models\WorkingPermission;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       Gate::define('isInTask', function ($user, $tasks){
           $tasks = explode(':', $tasks);
           $workingPermissions = $user->workingPermissions;
           $user_tasks = [];
           foreach ($workingPermissions as $permission){
               array_push($user_tasks, strtolower($permission->task->key));
           }
           return array_intersect($tasks, $user_tasks);
       });

       Gate::define('handoverIsInTask', function ($user, $tasks, $userId){
           if(WorkHandover::where([['user_id', $user->id], ['from_user_id', $userId], ['end_date', null]])->exists()){
               $tasks = explode(':', $tasks);
               $workingPermissions = WorkingPermission::where('user_id', $userId)->get();
               $user_tasks = [];
               foreach ($workingPermissions as $permission){
                   array_push($user_tasks, strtolower($permission->task->key));
               }
               return array_intersect($tasks, $user_tasks);
           }
          return false;
       });
    }
}
