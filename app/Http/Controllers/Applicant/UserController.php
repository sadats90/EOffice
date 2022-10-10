<?php

namespace App\Http\Controllers\Applicant;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\UserDetail;

class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        return view('applicant.user.index');
    }

    public function create()
    {
        return view('applicant::create');
    }

    public function userProfile()
    {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        return view('applicant::noc.profile.user_profile',['user'=>$user]);
    }

    public function UpdateUserProfile(Request $request)
    {
        $request->validate([
            'name'      =>  'required',
            'mobile'    =>  'required',
            'file'      =>  'image|mimes:jpeg,png,jpg'
        ]);
        $uid = Auth::user()->id;

        DB::beginTransaction();
        try{
            $user = User::find($uid);
            if($user->mobile != $request->mobile){
                if (User::where('mobile', $request->mobile)->exists()){
                    return back()->with('error_msg', 'এই মোবাইল নম্বরটি, ('.$request->mobile.') ইতোমধ্যে নিবন্ধিত হয়েছে।');
                }
                $user->mobile = $request->mobile;
                $user->mobile_verified_at = null;
                $user->mobile_verified_code = null;
            }
            $user->name = $request->name;
            $user->save();

            $user_details = UserDetail::where('user_id',$uid)->first();
            if ($request->hasFile('file')) {
                if (!empty($user_details->image)){
                    unlink($user_details->image);
                }
                $file = $request->file('file');
                $folder = 'noc/uploads/users/profile_picture';
                $file_name = $uid .'_' .'_user_profile_picture_' . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $folder . '/' . $file_name;
                $file->move($folder, $file_name);
                $user_details->image = $filePath;
            }
            $user_details->created_by = $uid;
            $user_details->created_ip = $request->ip();
            $user_details->save();
            DB::commit();
            return redirect('applicant/user-profile')->with('success_msg', 'আপনার প্রোফাইল সফলভাবে নবায়ন হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function changePassword()
    {
        return view('applicant.user.change_password');
    }

    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'old_password'      =>   'required',
            'new_password'      =>   'required|alpha_dash|min:6',
            'confirm_password'  =>   'required|alpha_dash|min:6',
        ]);
        $old = $request->old_password;
        $new = $request->new_password;
        $confirm = $request->confirm_password;
        $old_user = Auth::user()->password;

        if (Hash::check( $old,$old_user)){
            if($new == $confirm){
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($confirm);
                $user->save();
                Auth::logout();
                return redirect('/login')->with('success_msg', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে! দয়া করে লগইন করুন');
            }
            return back()->with('error_msg', 'আপনার পাসওয়ার্ডটি সঠিক নয়, এখানে একই পাসওয়ার্ড দিন');
        }
        return back()->with('error_msg', 'আপনার পুরনো পাসওয়ার্ডটি সঠিক নয়, সঠিক পাসওয়ার্ড দিন');

    }

    public function changeProfilePic()
    {
        return view('applicant.user.change_profile_pic');
    }

    public function updateProfilePic(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            $id = Auth::id();

            $userDetails = User::findOrFail($id);
            $folder_image = 'uploads/users/photo';
            $filePath = $userDetails->photo;
            if ($request->hasFile('image')) {
                if ($filePath != 'uploads/users/photo/default.png')
                    if (File::exists($filePath))
                        File::delete($filePath);
                $file = $request->file('image');
                $file_name = date('Ymd') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $folder_image . '/' . $file_name;
                $file->move($folder_image, $file_name);
            }
            $userDetails->photo = $filePath;
            $userDetails->save();
            return redirect()->route('applicant/user/changeProfilePic')->with('success_msg', 'প্রোফাইলের ছবি সফলভাবে পরিবর্তন করা হয়েছে!');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
