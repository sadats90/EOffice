<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Language
{
    public function __construct(Application $app, Request $request) {
        $this->app = $app;
        $this->request = $request;
    }

    public function handle($request, Closure $next)
    {
        if (Session::has('applocale')) {
            $locale = Session::get('applocale');
        }
        else {
            $locale = $this->app->config->get('app.fallback_locale');
        }

        $this->app->setLocale($locale);

        return $next($request);
    }
}
