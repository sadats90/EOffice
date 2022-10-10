<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Helpers\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function index()
    {
        return view('applicant.user.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              =>  'required',
            'mobile'            =>  'required',
            'email'             =>  'required',
            'city'             =>  'required',
            'password'          =>  'required',
            'password_confirm'  =>  'required',
        ]);
        if ($request->password != $request->password_confirm){
            $request->flush();
            return back()->with('error_msg', 'আপনার ব্যবহৃত ইউজার আইডি/পাসওয়ার্ড সঠিক নয়। সঠিক ইউজার আইডি/পাসওয়ার্ড ব্যবহার করুন।');
        }
        if (User::where('mobile', $request->mobile)->exists()){
            $request->flush();
            return back()->with('error_msg', 'এই মোবাইল নম্বরটি ইতোমধ্যে নিবন্ধিত হয়েছে। বিধায়, অন্য মোবাইল নম্বর দিয়ে যথাযথ ভাবে নিবন্ধন করুন।');
        }
        if (User::where('email', $request->email)->exists()){
            $request->flush();
            return back()->with('error_msg', 'এই ইমেইলটি ইতোমধ্যে নিবন্ধিত হয়েছে। বিধায়, অন্য ইমেইল দিয়ে যথাযথ ভাবে নিবন্ধন করুন।');
        }

        DB::beginTransaction();
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation_id = 2;
            $user->role = 'Applicant';
            $user->is_active = 1;
            $user->address = $request->city;
            $user->signature = 'noc/uploads/users/signatures/default.png';
            $user->photo = 'uploads/users/photo/default.png';
            $user->mobile_verified_code = Helper::RandomNumber(6);
            $user->password = bcrypt($request->password);
            $user->save();

            /*  Sent Mobile verification SMS  */
            $response = Message::SendSMS($user->mobile,  $user->mobile_verified_code . 'ইহা আপনার মোবাইল যাচাইকরণ কোড।');

            if($response['status'] == 'fail') {
                DB::rollBack();
                return back()->with('error_msg','Exception : ' . $response['message']);
            }

            DB::commit();
            return redirect()->route('login')->with('success_msg', 'আপনার অ্যাকাউন্ট সফলভাবে নিবন্ধিত হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }
}
