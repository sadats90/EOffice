<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationDocument;
use App\Models\ApplicationReport;
use App\Models\ApplicationRoute;
use App\Models\Attachment;
use App\Models\CertificateText;
use App\Models\CertificateType;
use App\Models\devPlan;
use App\Models\DocumentType;
use App\Models\ForwardPermission;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\LetterIssue;
use App\Models\LetterType;
use App\Models\Project;
use App\Models\RecievedApplication;
use App\Models\reportMap;
use App\Models\VerificationMessage;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class ForwardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index($id, $type)
   {
       $id = decrypt($id);

       $find_app = Application::where('id', $id)->where('is_complete', 0)->where('is_failed', 0)->first();

       if(!empty($find_app)) {

           $forward_users = array();
           if($find_app->is_new == 0){

               if (!Gate::allows('isInTask', 'admin')) {
                   if($find_app->receive_application->to_user_id != Auth::id()){
                       return view('404');
                   }
               }
               if($find_app->receive_application->is_back == 0 && $type != 'FW' && $find_app->receive_application->is_wait == 0){
                   return view('404');
               }

               if($find_app->receive_application->is_back == 1  && $type != 'FB' && $find_app->receive_application->is_wait == 0){
                   return view('404');
               }

               if($find_app->receive_application->is_wait == 1 && $type != 'FWW'){
                   return view('404');
               }

               if($find_app->receive_application->is_wait == 1){
                   $forward_users_permission = ForwardPermission::where('user_id', Auth::id())->get();

                   foreach ($forward_users_permission as $forward_user){
                       $user = User::findOrFail($forward_user->permitted_user_id);
                       $user->priority = $user->designation->priority;

                       if($user->priority > $forward_user->user->designation->priority){
                           $forward_users[] = $user;
                       }
                   }

               }else{

                   $forward_users = $this->GetForwardPermitUsers($forward_users);
               }
           }else{

               if (!Gate::allows('isInTask', 'admin:na')) {
                   return view('404');
               }

               $firstApplicationId = DB::table('applications')->where([['is_new', 1], ['is_complete', 0], ['is_cancel', 0]])->orderBy('app_id', 'asc')->first()->id;

               if($id != $firstApplicationId && $find_app->app_type != 'Emergency'){
                   return view('404');
               }

               if($type != 'new'){
                   return view('404');
               }

               $forward_users = $this->GetForwardPermitUsers($forward_users);
           }

           //Sort Forward users by his priority
           $forward_users = collect($forward_users);
           $forward_users = $forward_users->sortBy('priority');

           $f_v_message = VerificationMessage::where('application_id', $id)->first();
           $v_messages = VerificationMessage::where('application_id', $id)->get();
           $messageNo = count(VerificationMessage::where([['application_id', $id], ['message', '<>', null], ['message', '<>', '<p><br></p>']])->get());
           $applicants = ApplicationApplicant::where('application_personal_info_id', $find_app->personalInfo->id)->get();
           if ($type == 'new'){
               $find_app->report = ApplicationReport::where('application_id', $id)->first();
           }

           return view('user.forward.index',[
               'application'   =>  $find_app,
               'type' =>   $type,
               'documents' => ApplicationDocument::where('application_id', $id)->get(),
               'document_types' => DocumentType::all(),
               'Letters' => LetterIssue::where('application_id', $id)->get(),
               'forward_users' =>$forward_users,
               'f_v_message' => $f_v_message,
               'v_messages' => $v_messages,
               'applicants' => $applicants,
               'messageNo' => $messageNo+1,
               'letter_types' => LetterType::all(),
               'land_future_uses' => LandUseFuture::all(),
               'users' => User::where([['designation_id', '<>', 2]])->get(),
               'attachments' => Attachment::where([['application_id', $id]])->get(),
               'projects' => Project::where('project_type', 1)->get(),
               'certificateTypes' => CertificateType::all(),
               'CertificateTexts' => CertificateText::all()
           ]);
       }
       return view('404');
   }

   public function reportInitiate(Request $request, $id, $type)
   {
       $request->validate([
           'location'   =>  'required',
           'mapFiles.*'   =>  'mimes:jpg,jpeg,png,bmp,wmf,pdf',
           'dev_plans.*'   =>  'mimes:jpg,jpeg,png,bmp,wmf,pdf',
           'land_class'   =>  'required',
           'is_include_design'   =>  'required',
           'is_dev_plan'   =>  'required',
           'seat_no'   =>  'required',
           'zone'   =>  'required',
           'documents_correct'   =>  'required',
           'information_correct'   =>  'required',
           'applicable_betterment_fee'   =>  'required',
       ]);
       DB::beginTransaction();
       try{
           $id = decrypt($id);

           $old_app_report = ApplicationReport::where('application_id', $id)->first();
            $report_id = 0;
           if (!empty($old_app_report)){
               $report_id = $old_app_report->id;
               $old_app_report->location = $request->location;
               $old_app_report->land_class = $request->land_class;
               $old_app_report->seat_no = $request->seat_no;
               $old_app_report->spz_no = $request->spz_no;
               $old_app_report->documents_correct = $request->documents_correct;
               $old_app_report->information_correct = $request->information_correct;
               $old_app_report->road_condition = $request->road_condition;
               $old_app_report->applicable_betterment_fee = $request->applicable_betterment_fee;
               $old_app_report->zone = $request->zone;
               $old_app_report->is_include_design = $request->is_include_design;
               $old_app_report->is_dev_plan = $request->is_dev_plan;

               if($request->is_dev_plan == 1){
                   $old_app_report->dev_plan_desc = $request->dev_plan_desc;
               }else{
                   $old_app_report->dev_plan_desc = "";
               }
               $old_app_report->save();
           }else{
               $application_report = new ApplicationReport();
               $application_report->application_id = $id;
               $application_report->location = $request->location;
               $application_report->land_class = $request->land_class;
               $application_report->seat_no = $request->seat_no;
               $application_report->spz_no = $request->spz_no;
               $application_report->documents_correct = $request->documents_correct;
               $application_report->information_correct = $request->information_correct;
               $application_report->road_condition = $request->road_condition;
               $application_report->applicable_betterment_fee = $request->applicable_betterment_fee;
               $application_report->zone = $request->zone;
               $application_report->is_include_design = $request->is_include_design;
               $application_report->is_dev_plan = $request->is_dev_plan;

               if($request->is_dev_plan == 1){
                   $application_report->dev_plan_desc = $request->dev_plan_desc;
               }

               $application_report->save();
               $report_id = $application_report->id;
           }

           $maps = $request->mapFiles;
           if(!is_null($maps)){
               $folder = 'noc/uploads/'.date('M-y').'/map';
               foreach ($maps as $i => $map){

                   $file = $map;
                   $file_name = $i . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                   $filePath = $folder . '/' . $file_name;
                   $file->move($folder, $file_name);
                   $pathName = $filePath;

                   $map_file = new reportMap();
                   $map_file->application_report_id = $report_id;
                   $map_file->path = $pathName;
                   $map_file->name = $request->mapFilesName[$i];
                   $map_file->save();
               }
           }


           $devs = $request->dev_plans;
           if(!is_null($devs)){
               $dev_folder = 'noc/uploads/'.date('M-y').'/plans';
               foreach ($devs as $j => $dev){

                   $file = $dev;
                   $file_name = $j . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                   $filePath = $dev_folder . '/' . $file_name;
                   $file->move($dev_folder, $file_name);
                   $pathName = $filePath;

                   $dev_file = new devPlan();
                   $dev_file->application_report_id = $report_id;
                   $dev_file->path = $pathName;
                   $dev_file->name = $request->dev_plansName[$j];
                   $dev_file->save();
               }
           }
           $application = Application::findOrFail($id);
           $application->is_report_initiate = 1;
           $application->save();
           DB::commit();
           return redirect()->route('application/forward', ['id' => encrypt($id), 'type' => $type])->with('success_msg', 'রিপোর্ট তৈরি করা হয়েছে!');
       }catch (\Exception $ex){
           DB::rollBack();
           return back()->withError($ex->getMessage());
       }
   }

   public function DeleteMap($id, $app_id, $type){
       DB::beginTransaction();
        try {
            $map = reportMap::where([['id', $id]])->first();
            unlink($map->path);
            $map->delete();
            DB::commit();
           return redirect()->route('application/forward', ['id' => $app_id, 'type' => $type])->with('success_msg', 'মহাপরিকল্পনার নকশা মুছে ফেলা হয়েছে!');
       }catch (\Exception $ex){
           DB::rollBack();
           return back()->withError($ex->getMessage());
       }

   }

   public function DeletePlan($id, $app_id, $type){
       DB::beginTransaction();
        try {
            $plan = devPlan::where([['id', $id]])->first();
            unlink($plan->path);
            $plan->delete();
            DB::commit();
           return redirect()->route('application/forward', ['id' => encrypt($app_id), 'type' => $type])->with('success_msg', 'উন্নয়ন পরিকল্পনার সংযুক্তি মুছে ফেলা হয়েছে!');
       }catch (\Exception $ex){
           DB::rollBack();
           return back()->withError($ex->getMessage());
       }

   }


   public function store(Request $request, $id, $type)
   {
       $request->validate([
           'forward_to'   =>  'required',
       ]);

       DB::beginTransaction();
       try{
           $id = decrypt($id);

           if ($type == 'new'){
               if(is_null($request->message) || $request->message == "<p><br></p>"){
                   return back()->with('error_msg', 'এনওসি প্রক্রিয়া সম্পূর্নের জন্য অনুচ্ছেদ লিখুন!');
               }
           }

           //Forward application to user
           $old_app_receive = RecievedApplication::where('application_id', $id)->first();
           if (!empty($old_app_receive))
           {
               //Application Receive
               $old_app_receive->from_user_id =  Auth::id();
               $old_app_receive->to_user_id = $request->forward_to;
               $old_app_receive->in_date = date('Y-m-d');

               $any = VerificationMessage::where([['application_id', $id], ['user_id', $request->forward_to]])->get();
               if(count($any) > 0){
                   $old_app_receive->is_back = 1;
               }else{
                   $old_app_receive->is_back = 0;
               }
               $old_app_receive->save();

               //Application route
               $old_app_route = ApplicationRoute::where('application_id', $id)->where('to_user_id',  Auth::id())->first();
               $old_app_route->is_verified = 1;
               $old_app_route->out_date = date('Y-m-d');
               $old_app_route->save();

               $isAnyRoute = ApplicationRoute::where('application_id', $id)->where('from_user_id',  Auth::id())->where('to_user_id', $request->forward_to)->first();
               if (empty($isAnyRoute))
               {
                   $this->addAppRoute($request, $id,  Auth::id());
               }
               else
               {
                   $isAnyRoute->is_verified = 0;
                   $isAnyRoute->from_user_id =  Auth::id();
                   $isAnyRoute->to_user_id = $request->forward_to;
                   $isAnyRoute->in_date = date('Y-m-d');
                   $isAnyRoute->out_date = date('Y-m-d');
                   $isAnyRoute->month = date('m');
                   $isAnyRoute->year = date('Y');
                   $isAnyRoute->save();
               }
           }
           else
           {
               //Application Receive
               $app_receive = new RecievedApplication();
               $app_receive->application_id = $id;
               $app_receive->from_user_id =  Auth::id();
               $app_receive->to_user_id = $request->forward_to;
               $app_receive->in_date = date('Y-m-d');
               $app_receive->is_back = 0;
               $app_receive->save();

               //Application Route
               $application = Application::findOrFail($id);

               $new_app_route = new ApplicationRoute();
               $new_app_route->application_id = $id;
               $new_app_route->from_user_id = $application->user_id;
               $new_app_route->to_user_id = Auth::id();
               $new_app_route->in_date = date('Y-m-d');
               $new_app_route->out_date = date('Y-m-d');
               $new_app_route->month = date('m');
               $new_app_route->year = date('Y');
               $new_app_route->is_verified = 1;
               $new_app_route->save();

               $this->addAppRoute($request, $id,  Auth::id());
           }
           $issue_letter_id = 0;
           $issue_letters = LetterIssue::where([['user_id',  Auth::id()], ['is_issued', 1], ['application_id', $id]])->get();
           if(count($issue_letters) > 0){
               foreach ($issue_letters as $issue_letter){
                   $v_message_any = VerificationMessage::where([['user_id',  Auth::id()], ['letter_issue_id', $issue_letter->id]])->first();

                   if(is_null($v_message_any))
                       $issue_letter_id = $issue_letter->id;
               }
           }

           //verification message save
           $old_v_messages = VerificationMessage::where('application_id', $id)->get();
           $total_v_messages = count($old_v_messages);
           $last_v_message = VerificationMessage::where('application_id', $id)->orderBy('id', 'desc')->first();

           $v_message = new VerificationMessage();
           $v_message->application_id = $id;
           $v_message->user_id =  Auth::id();
           $v_message->message = $request->message;
           $v_message->version = $total_v_messages+1;
           $v_message->letter_issue_id = $issue_letter_id;
           if (empty($request->message) || $request->message == "<p><br></p>"){
               $v_message->same_comment = $last_v_message->same_comment;
           }
           else{
               if (!empty($last_v_message)){
                   $first_violate_message = VerificationMessage::where('application_id', $id)->where('same_comment', $last_v_message->same_comment)->orderBy('id', 'asc')->first();
                   $v_message->same_comment = $last_v_message->same_comment + 1;
                   $v_message->violate_to = $first_violate_message->id;
               }
               else{
                   $v_message->same_comment = 1;
               }
           }

           $v_message->save();

           if(!is_null($v_message->violate_to)){
               $violate_to_message = VerificationMessage::findOrFail($v_message->violate_to);
               $violate_to_message->violate_by = $v_message->id;
               $violate_to_message->save();
           }


           //Application status change
           $application = Application::findOrFail($id);
           $application->is_new = 0;
           $application->save();

           $forward_user = User::findOrFail($request->forward_to);
           DB::commit();
           if ($type == 'new')
               return redirect()->route('newApplication')->with('success_msg',$forward_user->name . 'এর নিকট আবেদন প্রেরণ হয়েছে!');
           else
               return redirect()->route('Application')->with('success_msg',$forward_user->name . 'এর নিকট আবেদন প্রেরণ হয়েছে!');
       }catch (\Exception $ex){
           DB::rollBack();
           return back()->withError($ex->getMessage());
       }
   }

    public function attachment($id){
        $attachments = Attachment::where([['application_id', $id], ['user_id', Auth::id()]])->get();
        return view('user.forward.attachment',[
            'id'   =>  $id,
            'attachments' => $attachments
        ]);
    }

    public function attachmentStore(Request $request, $id){
        $request->validate([
            'name'   =>  'required',
            'attach_file'   =>  'mimes:jpg,jpeg,png,bmp,wmf,pdf'
        ]);
        DB::beginTransaction();
        try {
            if(!is_null($request->attach_file)){

                $folder = 'noc/uploads/'.date('M-y').'/attachment';
                $file = $request->attach_file;
                $file_name = $id.'_'.Auth::id().'_'.date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $folder . '/' . $file_name;
                $file->move($folder, $file_name);
            }

            $attachment = new Attachment();
            $attachment->application_id = $id;
            $attachment->user_id = Auth::id();
            $attachment->name = $request->name;
            $attachment->path = $filePath;
            $attachment->save();

            DB::commit();
            $attachments = Attachment::where([['application_id', $id], ['user_id', Auth::id()]])->get();

            return response()->json([
                'body' => view('user.forward.attachment', ['id'   =>  $id,  'attachments' => $attachments])->render(),
                'attachments' => $attachments,
                'msg' => 'সংযুক্তি যোগ করা সফল হয়েছে!'
            ]);

        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }
    public function attachmentDelete(Request $request, $id, $app_id){
        DB::beginTransaction();
        try {
           $attachment = Attachment::where([['id', $id], ['application_id', $app_id], ['user_id', Auth::id()]])->first();
            if(!is_null($attachment)){
                unlink($attachment->path);
                $attachment->delete();
            }
            DB::commit();
            $attachments = Attachment::where([['application_id', $app_id], ['user_id', Auth::id()]])->get();
            return response()->json([
                'body' => view('user.forward.attachment', ['id'   =>  $id,  'attachments' => $attachments])->render(),
                'attachments' => $attachments,
                'msg' => 'সংযুক্তি মুছে ফেলা সফল হয়েছে!'
            ]);
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }


    private function addAppRoute(Request $request, $id, ?int $user_id): void
    {
        $app_route = new ApplicationRoute();
        $app_route->application_id = $id;
        $app_route->from_user_id = $user_id;
        $app_route->to_user_id = $request->forward_to;
        $app_route->in_date = date('Y-m-d');
        $app_route->month = date('m');
        $app_route->year = date('Y');
        $app_route->is_verified = 0;
        $app_route->save();
    }

    /**
     * @param array $forward_users
     * @return array
     */
    public function GetForwardPermitUsers(array $forward_users): array
    {
        $forward_users_permission = ForwardPermission::where('user_id', Auth::id())->get();
        foreach ($forward_users_permission as $forward_user) {
            $user = User::findOrFail($forward_user->permitted_user_id);
            $user->priority = $user->designation->priority;
            $forward_users[] = $user;
        }
        return $forward_users;
    }
}
