<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BloodGroup;
use App\Models\ForwardPermission;
use App\Models\Religion;
use App\Models\UserDetails;
use App\Models\WorkingPermission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try{
            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);
            return View('user.profile.index', [
                'model' => $user,
                'religions' => Religion::all(),
                'bloodGroups' => BloodGroup::all()
            ]);
        }catch (\Exception $ex){
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex -> getFile().': '.$ex -> getLine()
            ]);
        }
    }

    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'old_password'      =>   'required',
            'new_password'      =>   'required|alpha_dash|min:8',
            'confirm_password'  =>   'required|alpha_dash|min:8',
        ]);
        $old = $request->old_password;
        $new = $request->new_password;
        $confirm = $request->confirm_password;
        $user_old_password = Auth::user()->password;

        if (Hash::check( $old, $user_old_password)){
            if($new == $confirm){
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($confirm);
                $user->save();
                Auth::logout();
                return redirect('/login')->with('success_msg', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে! লগইন করুন');
            }
            return back()->with('error_msg', 'নিশ্চিত করুন পাসওয়ার্ড মেলে না');
        }
        return back()->with('error_msg', 'পুরানো পাসওয়ার্ড মেলে না');

    }

    public function changeProfilePicture(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|required|mimes:jpg,jpeg,png'
        ]);

        try {
            if (Auth::id() != $id)
                return redirect()->back()->with('error_msg','401 Unauthorized ');
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
            return redirect()->route('Profile')->with('success_msg','প্রোফাইলের ছবি পরিবর্তন করা হয়েছে!');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
    public function changeSignature(Request $request, $id)
    {
        $request->validate([
            'signature' => 'required|required|mimes:jpg,jpeg,png'
        ]);

        try {
            if (Auth::id() != $id)
                return redirect()->back()->with('error_msg','401 Unauthorized ');

            $user = User::findOrFail($id);
            $folder_image = 'uploads/users/signature';
            $filePath = $user->signature;
            if ($request->hasFile('signature')) {
                if ($filePath != 'uploads/users/signature/default.png')
                    if (File::exists($filePath))
                        File::delete($filePath);
                $file = $request->file('signature');
                $file_name = date('Ymd') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $folder_image . '/' . $file_name;
                $file->move($folder_image, $file_name);
            }
            $user->signature = $filePath;
            $user->save();
            return redirect()->route('Profile')->with('success_msg', 'স্বাক্ষর পরিবর্তন করা হয়েছে!');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function changeInfo(Request $request, $id)
    {
        DB::beginTransaction();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => 'required',
            'address' => 'required',
            'father_bn' => 'required',
            'father_en' => 'required',
            'mother_bn' => 'required',
            'mother_en' => 'required',
            'date_of_birth' => 'required',
            'nid_no' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'marital_status' => 'required',
        ]);

        try {
            if (Auth::id() != $id)
                return redirect()->back()->with('error_msg','401 Unauthorized ');

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->address = $request->address;
            $user->save();

            $userDetails = UserDetails::where('user_id', $user->id)->first();

            $userDetails->en_name = $request->name_en;
            $userDetails->father_en = $request->father_en;
            $userDetails->father_bn = $request->father_bn;
            $userDetails->mother_en = $request->mother_en;
            $userDetails->mother_bn = $request->mother_bn;
            $userDetails->date_of_birth = $request->date_of_birth;
            $userDetails->nid_no = $request->nid_no;
            $userDetails->gender = $request->gender;
            $userDetails->religion = $request->religion;
            $userDetails->bloodGroup = $request->blood_group;
            $userDetails->martial_status = $request->marital_status;
            $userDetails->twitter_link = $request->twitter_link;
            $userDetails->facebook_link = $request->facebook_link;
            $userDetails->linkedin_link = $request->linkedin_link;
            $userDetails->skypee_link = $request->skypee_link;
            $userDetails -> save();

            DB::commit();
            return redirect()->route('Profile')->with('success_msg', 'ব্যক্তিগত তথ্য সম্পাদন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
