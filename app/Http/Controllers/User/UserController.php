<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\ApplicationType;
use App\Models\BloodGroup;
use App\Models\Designation;
use App\Models\ForwardPermission;
use App\Models\LandType;
use App\Models\Religion;
use App\Models\Task;
use App\Models\UserDetails;
use App\Models\WorkHandover;
use App\Models\WorkingPermission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $query = User::query();
            $query = $query->where([['id', '<>', 1], ['role','<>', 'Applicant']]);
            $users = $query->paginate($recordsPerPage);
            return view('user.user.index', [
                'model' => $users,
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function workHandover($id){

        if(User::where([['id', $id], ['is_work_handover', 0], ['is_active', 1]])->exists()){
            $query = User::where([['designation_id', '<>', 1],['designation_id', '<>', 2], ['id', '<>',$id], ['is_active', 1], ['is_work_handover', 0]])->get();

            return view('user.user.workHandover',
                [
                    'users'=> $query,
                    'id' => $id,
                    'is_valid' => 1
                ]);
        }
        return view('user.user.workHandover', ['is_valid' => 0]);
    }

    public function workHandoverStore(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'fromDate' => 'required',
            'toDate' => 'required',
        ]);

       DB::beginTransaction();
        try {
           $user = User::where([['id', $id], ['is_active', 1], ['is_work_handover', 0]])->first();
           if($user == null)
               return view('404');

           $task_id = Task::where('key', "WH")->first()->id;
            if(!WorkingPermission::where([['user_id', $request->user_id], ['task_id', $task_id]])->exists()){
                $workingPermission = new WorkingPermission();
                $workingPermission->user_id = $request->user_id;
                $workingPermission->task_id = $task_id;
                $workingPermission->save();
            }

            $workHandover = new WorkHandover();
            $workHandover->user_id = $request->user_id;
            $workHandover->from_user_id = $id;
            $workHandover->start_date = date('y-m-d');
            $workHandover->end_date = date('y-m-d', strtotime(str_replace('/','-', $request->toDate)));
            $workHandover->save();

            $user->is_work_handover = 1;
            $user->save();

           DB::commit();
            return redirect()->route('User')->with('success_msg', $user->name . ' এর কাছে দায়িত্ব হস্তান্তর করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function cancelWorkHandover($id)
    {
       DB::beginTransaction();
        try {
           $user = User::where([['id', $id], ['is_active', 1], ['is_work_handover', 1]])->first();
           if($user == null)
               return view('404');

           $task_id = Task::where('key', "WH")->first()->id;
           $workHandover = WorkHandover::where('from_user_id', $id)->orderBy('id', 'desc')->first();
           $workHandover->end_date = date('y-m-d');
           $workHandover->save();

           $anyHandoversAvailable = WorkHandover::where([['user_id', $workHandover->user_id], ['from_user_id', $id]])->get();
           if(count($anyHandoversAvailable) == 0){
               $taskPermission = WorkingPermission::where([['user_id', $workHandover->user_id], ['task_id', $task_id]])->first();
               if($taskPermission != null)
                    $taskPermission->delete();
           }

            $user->is_work_handover = 0;
            $user->save();

           DB::commit();
            return redirect()->route('User')->with('success_msg', 'দায়িত্ব হস্তান্তর বাতিল করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function workingPermission($id){
        return view('user.user.workingPermission',
            [
                'tasks'=>Task::where('key', '<>', 'admin')->get(),
                'id' => $id
            ]);
    }

    public function WorkingPermissionStore(Request $request, $id){
        $request->validate([
            'task_id' => 'required',
        ]);
        try {
            $tasks = $request->task_id;
            foreach ($tasks as $task){
                $isExsits = WorkingPermission::where([['user_id', $id], ['task_id', $task]])->first();
                if ($isExsits == null){
                    $workingPermission = new WorkingPermission();
                    $workingPermission->user_id = $id;
                    $workingPermission->task_id = $task;
                    $workingPermission -> save();
                }
            }
            return redirect()->route('User')->with('success_msg', 'কাজের অনুমতি বরাদ্দ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function workingPermissionDelete($id){
        try {
            $workingPermission = WorkingPermission::findOrFail($id);
            $workingPermission->delete();
            return redirect()->route('User')->with('success_msg', 'কাজের অনুমতি মুছে ফেলা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->route('User')->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function forwardPermission($id)
    {
        return view('user.user.forwardPermission',
            [
                'designations'=>Designation::where([['id', '<>', 1],['id', '<>', 2]])->get(),
                'id' => $id
            ]);
    }

    public function forwardPermissionStore(Request $request, $id){
        $request->validate([
            'designation_id' => 'required',
            'permitted_users' => 'required'
        ]);
        try {
           $users = $request->permitted_users;
           foreach ($users as $user){
               $isExsits = ForwardPermission::where([['user_id', $id], ['permitted_user_id', $user]])->first();
               if ($isExsits == null){
                   $forwardPermission = new ForwardPermission();
                   $forwardPermission->user_id = $id;
                   $forwardPermission->designation_id = $request->designation_id;
                   $forwardPermission->permitted_user_id = $user;
                   $forwardPermission -> save();
               }
           }

            return redirect()->route('User')->with('success_msg', 'ফরওয়ার্ডিং অনুমতি যোগ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function forwardPermissionDelete($id){
        try {
            $forwardPermission = ForwardPermission::findOrFail($id);
            $forwardPermission->delete();
            return redirect()->route('User')->with('success_msg', 'ফরওয়ার্ডিং অনুমতি মুছে ফেলা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->route('User')->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function create()
    {
        $designation = Designation::where([['name', '<>', 'Admin'], ['name', '<>', 'Applicant']])->get();
        return view('user.user.create',
            [
                'designations'=>$designation,
                'religions' => Religion::all(),
                'bloodGroups' => BloodGroup::all()
            ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => 'required',
            'designation_id' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'father_bn' => 'required',
            'father_en' => 'required',
            'mother_bn' => 'required',
            'mother_en' => 'required',
            'date_of_birth' => 'required',
            'nid_no' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'marital_status' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8','confirmed'],
            'password_confirmation' => 'required',
            'signature' => 'required|mimes:jpg,jpeg,png',
            'image' => 'required|mimes:jpg,jpeg,png',

        ]);

        try {

            if (User::where('mobile', $request->mobile)->exists()){
                return back()->with('error_msg', 'এই মোবাইল নম্বরটি ইতিমধ্যেই নিবন্ধিত');
            }
            if (User::where('email', $request->email)->exists()){
                return back()->with('error_msg', 'এই ইমেইলটি আগেই নতিভুক্ত করা আছে');
            }

            $upload_dir_signature = 'uploads/users/signature';
            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $file_name = date('Ymd') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $signaturePath = $upload_dir_signature . '/' . $file_name;
                $file->move($upload_dir_signature, $file_name);
            }
            else {
                $file_name = 'default.png';
                $signaturePath = $upload_dir_signature . '/' . $file_name;
            }

            $upload_directory_image = 'uploads/users/photo';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = date('Ymd') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $upload_directory_image . '/' . $file_name;
                $file->move($upload_directory_image, $file_name);
            }
            else {
                $file_name = 'default.png';
                $filePath = $upload_directory_image . '/' . $file_name;
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 'user';
            $user->address = $request->address;
            $user->mobile = $request->mobile;
            $user->designation_id = $request->designation_id;
            $user->signature = $signaturePath;
            $user->is_active = 1;
            $user->mobile_verified_code = 112233;
            $user->password = Hash::make($request->password);
            $user->photo = $filePath;
            $user->save();


            $userDetails = new UserDetails();
            $userDetails->user_id = $user->id;
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

            //Send Mail to user---------------------------------------------------
//            $mail_data = array(
//                'subject'   =>  'Congratulations!',
//                'email'     =>  $request->email,
//                'password'  =>  $request->password
//            );
//            Helper::SendMail($mail_data,'mail_password');
            //---------------------------------------------------
            DB::commit();
            return redirect()->route('User')->with('success_msg', 'আবেদন পত্রের ধরণ যোগ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        try{
            $user = User::findOrFail($id);
            $workingPermissions = WorkingPermission::where('user_id', $id)->get();
            $forwardingPermissions = ForwardPermission::where('user_id',$id)->get();
            foreach ($forwardingPermissions as $row){
                $row->permitted_user = User::findOrFail($row->permitted_user_id)->name;
            }
            return View('user.user.details', [
                'model' => $user,
                'workingPermissions' => $workingPermissions,
                'forwardingPermissions' => $forwardingPermissions
            ]);
        }catch (\Exception $ex){
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex -> getFile().': '.$ex -> getLine()
            ]);
        }
    }
    public function edit($id)
    {
        try{
            $userDetails = User::findOrFail($id);
            $designation = Designation::where('name', '<>', 'অ্যাডমিনিস্ট্রেটর')->get();
            return View('user.user.edit', [
                'model' => $userDetails,
                'designations'=>$designation,
                'religions' => Religion::all(),
                'bloodGroups' => BloodGroup::all()
                ]);
        }catch (\Exception $ex){
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex -> getFile().': '.$ex -> getLine()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => 'required',
            'designation_id' => 'required',
            'address' => 'required',
            'mobile' => 'required',
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
            $user = User::findOrFail($id);

            $folder_signature = 'uploads/users/signature';
            $signaturePath =$user->signature;
            if ($request->hasFile('signature')) {
                if ($signaturePath != 'uploads/users/signature/default.png')
                    if (File::exists($signaturePath))
                        File::delete($signaturePath);
                $file = $request->file('signature');
                $file_name = date('Ymd') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $signaturePath = $folder_signature . '/' . $file_name;
                $file->move($folder_signature, $file_name);
            }

            $folder_image = 'uploads/users/photo';
            $filePath = $user->photo;
            if ($request->hasFile('image')) {
                if ($filePath != 'uploads/users/photo/default.png')
                    if (File::exists($filePath))
                        File::delete($filePath);
                $file = $request->file('image');
                $file_name = date('Ymd') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $folder_image . '/' . $file_name;
                $file->move($folder_image, $file_name);
            }
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->designation_id = $request->designation_id;
            $user->signature = $signaturePath;
            $user->photo = $filePath;
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
            return redirect()->route('User')->with('success_msg', 'ব্যবহারকারী সম্পাদন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function destroy($id)
    {
        try {

            $user = User::findOrFail($id);

            $filePath = $user->photo;
            if ($filePath != 'uploads/users/photo/default.png')
                if (File::exists($filePath))
                    File::delete($filePath);

            $signaturePath =$user->signature;
            if ($signaturePath != 'uploads/users/signature/default.png')
                if (File::exists($signaturePath))
                    File::delete($signaturePath);

            $user->delete();
            return redirect()->route('User')->with('success_msg', 'ব্যবহারকারী মুছে ফেলা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function active($id)
    {
        try {

            $user = User::findOrFail($id);
            if (!empty($user)){
                $user->is_active = 1;
                $user->save();
            }else{
                return view('404');
            }

            return redirect()->route('User')->with('success_msg', 'ব্যবহারকারীকে সক্রিয় করা হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function inactive($id)
    {
        try {
            $user = User::findOrFail($id);
            if (!empty($user)){
                $user->is_active = 0;
                $user->save();
            }else{
                return view('404');
            }

            return redirect()->route('User')->with('success_msg', 'ব্যবহারকারীকে নিস্ক্রিয় করা হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function getUsersByDesignation($id, $user_id)
    {
       $users = User::where([
           ['designation_id',$id],
           ['id','<>', $user_id],
           ['designation_id', '<>', 1]
       ])->get();

       return $users;
    }


}
