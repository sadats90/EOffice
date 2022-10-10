<?php

namespace App\Http\Middleware;

use App\Models\WorkingPermission;
use Closure;
use Illuminate\Support\Facades\Auth;

class task
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $name)
    {
        $task = \App\Models\Task::where('name', $name)->get()->first();
        $admin = \App\Models\Task::where('name', 'Admin')->get()->first();
        $userId = Auth::id();
        $is_permitted_task = WorkingPermission::where([['user_id', $userId],['task_id', $task->id]])->exists();
        $is_Admin =  WorkingPermission::where([['user_id', $userId],['task_id', 1]])->exists();
        if ($is_permitted_task || $is_Admin){
            return $next($request);
        }
        Auth::logout();
        return redirect('/login')
            ->with(['error' => "You do not have the permission to enter this site. Please login with correct user."]);
    }
}
