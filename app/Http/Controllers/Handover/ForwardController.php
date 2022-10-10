<?php

namespace App\Http\Controllers\Handover;

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
use App\Models\VatInvoice;
use App\Models\VerificationMessage;
use App\Models\VerificationMessageFile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class ForwardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index($id)
   {
       $find_app = Application::where('id', $id)->where('is_complete', 0)->where('is_failed', 0)->first();

       if(!empty($find_app)) {
           $forward_users = ForwardPermission::where('user_id',$find_app->receive_application->to_user_id)->get();
           foreach ($forward_users as $user){
               $user->permitted_user_name = User::findOrFail($user->permitted_user_id)->name;
           }

           $find_app->applicant = User::findOrFail($find_app->user_id);
           $find_app->landInfo->plut_name = LandUsePresent::findOrFail($find_app->landInfo->land_currently_use);
           $find_app->landInfo->flut_name = LandUseFuture::findOrFail($find_app->landInfo->land_future_use);
           $f_v_message = VerificationMessage::where('application_id', $id)->first();
           $v_messages = VerificationMessage::where('application_id', $id)->get();
           $applicants = ApplicationApplicant::where('application_personal_info_id', $find_app->personalInfo->id)->get();

           return view('handover.forward.index',[
               'application'   =>  $find_app,
               'documents' => ApplicationDocument::where('application_id', $id)->get(),
               'document_types' => DocumentType::all(),
               'Letters' => LetterIssue::where('application_id', $id)->get(),
               'forward_users' =>$forward_users,
               'f_v_message' => $f_v_message,
               'v_messages' => $v_messages,
               'applicants' => $applicants,
               'letter_types' => LetterType::all(),
               'land_future_uses' => LandUseFuture::all(),
               'users' => User::where([['designation_id', '<>', 2]])->get(),
               'attachments' => Attachment::where([['user_id', Auth::id()], ['application_id', $id]])->get(),
               'projects' => Project::all(),
               'certificateTypes' => CertificateType::all(),
               'CertificateTexts' => CertificateText::all(),
               'hit' => 'vr'
           ]);
       }
       return view('404');
   }

   public function store(Request $request, $id, $to_user_Id)
   {
       $request->validate([
           'forward_to'   =>  'required',
       ]);

       DB::beginTransaction();
       try{

           $user_id = Auth::id();

           //Forward application to user
           $old_app_receive = RecievedApplication::where('application_id', $id)->first();
           if (!empty($old_app_receive))
           {
               //Application Receive
               $old_app_receive->from_user_id = $user_id;
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
               $old_app_route = ApplicationRoute::where('application_id', $id)->where('to_user_id', $user_id)->first();
               $old_app_route->is_verified = 1;
               $old_app_route->out_date = date('Y-m-d');
               $old_app_route->save();

               $isAnyRoute = ApplicationRoute::where('application_id', $id)->where('from_user_id', $user_id)->where('to_user_id', $request->forward_to)->first();
               if (empty($isAnyRoute))
               {
                   $this->addAppRoute($request, $id, $user_id);
               }
               else
               {
                   $isAnyRoute->is_verified = 0;
                   $isAnyRoute->from_user_id = $user_id;
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
               $app_receive->from_user_id = $user_id;
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

               $this->addAppRoute($request, $id, $user_id);
           }

           $issue_letter_id = 0;
           $issue_letters = LetterIssue::where([['user_id', $user_id], ['is_issued', 1], ['application_id', $id]])->get();
           if(count($issue_letters) > 0){
               foreach ($issue_letters as $issue_letter){
                   $v_message_any = VerificationMessage::where([['user_id', $user_id], ['letter_issue_id', $issue_letter->id]])->first();

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
           $v_message->user_id = $to_user_Id;
           $v_message->on_behalf_of = $user_id;
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
           return redirect()->route('workHandover/Application')->with('success_msg',$forward_user->name . 'এর কাছে আবেদন সফলভাবে প্রেরণ হয়েছে!');

       }catch (\Exception $ex){
           DB::rollBack();
           return back()->withError($ex->getMessage());
       }
   }

    public function cancelApplication($id){

        DB::beginTransaction();
        try {
            $application = Application::findOrFail($id);
            $application->is_cancel = 1;
            $application->save();
            DB::commit();
            return redirect()->route('newApplication')->with('success_msg', 'আবেদনটি সফলভাবে বাতিল করা হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function invoiceVerify($id){

        return view('user.forward.invoiceVerify',['id'  =>  $id, 'invoice' => VatInvoice::findOrFail($id)]);
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

    //-------------------------------

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
}
