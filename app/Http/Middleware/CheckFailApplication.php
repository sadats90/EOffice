<?php

namespace App\Http\Middleware;

use App\Models\Application;
use App\Models\ApplicationRoute;
use Closure;

class CheckFailApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $query = Application::query();
        $is_wait = 1;

        $query->whereHas('receive_application', function ($q) use ($is_wait) {
            $q->where('is_wait', $is_wait);
        });

        $find_apps = $query->where('is_complete', 0)->where('is_failed', 0)->get();
        foreach ($find_apps as $find_app){
            //Check application fail state
            if (count($find_app->letter_issues) > 0){
                foreach ($find_app->letter_issues as $letter)
                {
                    if ($letter->is_issued == 1 && $letter->is_solved == 0){
                        $exceptIds = [1, 2];
                        if(in_array($letter->letter_type_id, $exceptIds)){
                            if ($letter->expired_date < date('Y-m-d')){
                                $find_app->is_failed = 1;
                                $find_app->save();

                                $routApp = ApplicationRoute::where([['application_id', $find_app->id], ['is_verified', 0]])->first();
                                $routApp->is_fail = 1;
                                $routApp->save();
                            }
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
