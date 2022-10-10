<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Helpers\Message;
use App\Models\Application;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        $user_id = Auth::id();
        $applications = Application::where('user_id', $user_id)->get();
        $totalLetter = 0;
        foreach ($applications as $application)
        {
            foreach ($application->letter_issues as $letter)
            {
                if ($application->is_failed == 0){
                    if ($letter->is_issued == 1 && $letter->is_solved == 0)
                    {
                        $totalLetter++;
                    }
                }
            }
        }
        return view('applicant.dashboard.index',[
            'total' => count($applications),
            'blank' => count(Application::where([['user_id', $user_id], ['is_submit', 0]])->get()),
            'submit' => count(Application::where([['user_id', $user_id], ['is_submit', 1], ['is_complete', 0], ['is_failed', 0]])->get()),
            'process' => count(Application::where([['user_id', $user_id], ['is_submit', 1], ['is_complete', 0], ['is_failed', 0]])->get()),
            'complete' => count(Application::where([['user_id', $user_id], ['is_submit', 1], ['is_complete', 1], ['is_failed', 0]])->get()),
            'fail' => count(Application::where([['user_id', $user_id], ['is_submit', 1], ['is_complete', 0], ['is_failed', 1]])->get()),
            'letters' => $totalLetter,
            ]);
    }

    public function VerifyMobile()
    {
        $user = Auth::user();
        return view('applicant.dashboard.mobile-verify',['user'=>$user]);
    }
    public function SendVerificationCode()
    {
        DB::beginTransaction();
        try {
            $uid = Auth::user()->id;
            $code = Helper::RandomNumber(6);
            $user = User::find($uid);
            $user->mobile_verified_at = null;
            $user->mobile_verified_code = $code;
            $user->save();

            $u = User::find($uid);
            $sms_text = $code. 'ইহা আপনার মোবাইল নম্বর যাচাইকরণ কোড';
            $sms = Message::SendSMS($u->mobile, $sms_text);

            if($sms['status'] == 'fail') {
                DB::rollBack();
                return redirect('applicant/verify-mobile')->with('error_msg',$sms['message']);
            }

            DB::commit();
            return redirect('applicant/verify-mobile');
        }
        catch (QueryException $ex) {
            DB::rollBack();
            return redirect('applicant/verify-mobile')->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function VerifyCode(Request $request)
    {
        try {
            $uid = Auth::user()->id;
            $user = User::find($uid);
            if($user->mobile_verified_code != $request->code)
                return redirect('applicant/verify-mobile')->with('error_msg', 'ইহা ভুল যাচাইকরণ কোড');
            $user->mobile_verified_at = date('y-m-d h:i:s');
            $user->save();
            return redirect('applicant/verify-mobile');
        }
        catch (QueryException $ex) {
            return redirect('applicant/verify-mobile')->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
} // end of class
