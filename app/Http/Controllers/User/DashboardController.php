<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationRoute;
use App\Models\RecievedApplication;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user_role = Auth::user()->role;
        if (Auth::user()->is_active == 0){
            Auth::logout();
            return redirect('/login')->with('error_msg', 'আপনার ব্যবহৃত ইউজার আইডি/পাসওয়ার্ড সঠিক নয়। সঠিক ইউজার আইডি/পাসওয়ার্ড ব্যবহার করুন।');
        }

        if($user_role == 'user'){
            $forward = new Object_();
            $receive = new Object_();
            $adminDashboard = new Object_();
            if (Auth::user()->cannot('isInTask', 'admin')) {
                $forward->daily = count(ApplicationRoute::where([['from_user_id', Auth::id()], ['out_date', date('Y-m-d')]])->get());
                $forward->monthly = count(ApplicationRoute::where([['from_user_id', Auth::id()], ['month', date('m')], ['year', date('Y')]])->get());
                $forward->yearly = count(ApplicationRoute::where([['from_user_id', Auth::id()], ['year', date('Y')]])->get());
                $forward->total = count(ApplicationRoute::where('from_user_id', Auth::id())->get());

                $receive->daily = count(ApplicationRoute::where([['to_user_id', Auth::id()], ['in_date', date('Y-m-d')]])->get());
                $receive->monthly = count(ApplicationRoute::where([['to_user_id', Auth::id()], ['month', date('m')], ['year', date('Y')]])->get());
                $receive->yearly = count(ApplicationRoute::where([['to_user_id', Auth::id()], ['year', date('Y')]])->get());
                $receive->total = count(ApplicationRoute::where('to_user_id', Auth::id())->get());
            }else{
                $adminDashboard->total = count(Application::where('is_submit', 1)->get());
                $adminDashboard->new = count(Application::where('is_new', 1)->get());
                $adminDashboard->process = count(RecievedApplication::all());
                $adminDashboard->complete =  count(Application::where('is_complete', 1)->get());
                $adminDashboard->fail = count(Application::where('is_failed', 1)->get());
                $adminDashboard->users = count(User::where('role', 'user')->get());
                $adminDashboard->applicants = count(User::where('role', 'Applicant')->get());
            }


            return view('user.Dashboard.index', [
                'admin' =>$adminDashboard,
                'forward' => $forward,
                'receive' => $receive,
            ]);
        }
        else if($user_role == 'Applicant')
            return redirect('applicant/dashboard');
    }
}
