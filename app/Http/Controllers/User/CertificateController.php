<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Helpers\Message;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationReport;
use App\Models\ApplicationRoute;
use App\Models\Certificate;
use App\Models\CertificateAttachment;
use App\Models\CertificateDuplicate;
use App\Models\CertificateLaw;
use App\Models\CertificateLedger;
use App\Models\GeneralCertificate;
use App\Models\GeneralCertificateApplicant;
use App\Models\GovernmentCertificate;
use App\Models\GovernmentCertificateLaw;
use App\Models\RecievedApplication;
use App\Models\VerificationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use test\Mockery\Stubs\Animal;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store( Request $request, $id, $type)
    {
        $id = decrypt($id);

        $request->validate([
            'certificate_type_id'   =>  'required',
            'subject'   =>  'required',
            'condition'   =>  'required',
            'certificate_attach_file.*'   =>  'mimes:jpg,jpeg,png,bmp,wmf'
        ]);

       if($request->certificate_type_id == 1){
           $request->validate([
               'applicant_names.*'   =>  'required',
               'father_names.*'   =>  'required',
               'village'   =>  'required',
               'post_office'   =>  'required',
               'thana'   =>  'required',
               'district'   =>  'required',
               'zone'   =>  'required',
               'mouza'   =>  'required',
               'rs_line'   =>  'required',
               'zl_no'   =>  'required',
               'land'   =>  'required',
           ]);
       }else{
           $request->validate([
               'certificate_laws.*'   =>  'required',
               'name'   =>  'required',
               'address'   =>  'required',
           ]);
       }

        DB::beginTransaction();
        try{
            $old_certificate = Certificate::where('application_id', $id)->first();
            $certificate_id = 0;
            if (!empty($old_certificate)){

                $old_duplicate_certificates = CertificateDuplicate::where('certificate_id', $old_certificate->id)->get();
                if(count($old_duplicate_certificates) > 0){
                    foreach ($old_duplicate_certificates as $duplicate){
                        $duplicate->delete();
                    }
                }
              if(!is_null($request->certificate_attach_file)){
                    $old_attachements = CertificateAttachment::where('certificate_id', $old_certificate->id)->get();
                    if(count($old_attachements) > 0){
                        foreach ($old_attachements as $c_attachement){
                            unlink($c_attachement->path);
                            $c_attachement->delete();
                        }
                    }
                }

                if($old_certificate->certificate_type_id == 1){
                    $old_certificate_General = GeneralCertificate::where('certificate_id', $old_certificate->id)->first();
                    $old_certificate_General->delete();
                }
                if($old_certificate->certificate_type_id == 2){
                    $old_certificate_govt = GovernmentCertificate::where('certificate_id', $old_certificate->id)->first();
                    $old_certificate_govt->delete();
                }
                $old_certificate->certificate_type_id = $request->certificate_type_id;

                $old_certificate->subject = $request->subject;
                $old_certificate->old_swarok = $request->old_swarok;
                $old_certificate->condition_to_be_followed = $request->condition;
                $old_certificate->created_by = Auth::id();
                $old_certificate->created_ip = $request->ip();
                $old_certificate->save();

                $certificate_id = $old_certificate->id;
            }else{

                $certificate = new Certificate();
                $certificate->application_id = $id;
                $certificate->certificate_no = '';
                $certificate->certificate_type_id = $request->certificate_type_id;
                $certificate->subject = $request->subject;
                $certificate->condition_to_be_followed = $request->condition;
                $certificate->old_swarok = $request->old_swarok;

                $certificate->created_by = Auth::id();
                $certificate->created_ip = $request->ip();
                $certificate->year = date('Y');
                $certificate->save();

                $certificate_id = $certificate->id;
            }

            $attach_files = $request->certificate_attach_file;

            if(!is_null($attach_files)){
                if(count($attach_files) > 0)
                {
                    $folder = 'noc/uploads/'.date('M-y').'/certificate_attachment';
                    foreach($attach_files as $i => $file)
                    {
                        $file_name = $i . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $filePath = $folder . '/' . $file_name;
                        $file->move($folder, $file_name);

                        $attachment = new CertificateAttachment();
                        $attachment->certificate_id = $certificate_id;
                        $attachment->name = $request->certificate_attach_name[$i];
                        $attachment->path = $filePath;
                        $attachment->save();
                    }
                }
            }
            $users = $request->user_id;

            if(!is_null($users[0]))
            {
                foreach($users as $user)
                {
                    $duplicate_certificate = new CertificateDuplicate();
                    $duplicate_certificate->certificate_id = $certificate_id;
                    $duplicate_certificate->user_id = $user;
                    $duplicate_certificate->save();
                }
            }

            if($request->certificate_type_id == 1){

                $general_certificate = new GeneralCertificate();
                $general_certificate->certificate_id = $certificate_id;

                $general_certificate->village = $request->village;
                $general_certificate->post_office = $request->post_office;
                $general_certificate->thana = $request->thana;
                $general_certificate->district = $request->district;
                $general_certificate->zone = $request->zone;
                $general_certificate->mouza = $request->mouza;
                $general_certificate->spot_no = $request->rs_line;
                $general_certificate->zl_no = $request->zl_no;
                $general_certificate->land_amount = Helper::ConvertToEnglish($request->land);
                $general_certificate->save();

                $applicants = $request->applicant_names;
                $fathers = $request->father_names;

                foreach ($applicants as $i_a => $item){
                    $applicant = new GeneralCertificateApplicant();
                    $applicant->general_certificate_id = $general_certificate->id;
                    $applicant->name = $item;
                    $applicant->father = $fathers[$i_a];
                    $applicant->save();
                }
            }
            if($request->certificate_type_id == 2){

                $government_certificate = new GovernmentCertificate();
                $government_certificate->certificate_id = $certificate_id;
                $government_certificate->name = $request->name;
                $government_certificate->address = $request->address;
                $government_certificate->save();

                $laws = $request->certificate_laws;
                if(count($laws) > 0)
                {
                    foreach($laws as $law)
                    {
                        $certificate_law = new GovernmentCertificateLaw();
                        $certificate_law->government_certificate_id	 = $government_certificate->id;
                        $certificate_law->name = $law;
                        $certificate_law->save();
                    }
                }
            }

            $application = Application::findOrFail($id);
            $application->is_certificate_make = 1;
            $application->save();
            DB::commit();
            return redirect()->route('application/forward', ['id' => encrypt($id), 'type' => $type])->with('success_msg', 'অনিস্পত্তি আবেদন সফলভাবে সম্পূর্ণ হয়েছে');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function reset($id, $type){
        DB::beginTransaction();
        try{
            $id = decrypt($id);

            $certificate = Certificate::where('application_id', $id)->first();

            if(empty($certificate)){
                DB::rollBack();
                return view('404');
            }

            $statusCode = $this->CheckBusinessValidation($certificate->application, $type);
            if($statusCode == 404)
                return view('404');

            if(count($certificate->certificate_attachments) > 0){
                foreach ($certificate->certificate_attachments as $attachment){
                    unlink($attachment->path);
                    $attachment->delete();
                }
            }
            $certificate->delete();

            $application = Application::findOrFail($id);
            $application->is_certificate_make = 0;
            $application->save();
            DB::commit();
            return redirect()->route('application/forward', ['id' => encrypt($id), 'type' => $type])->with('success_msg', 'অনিস্পত্তি আবেদন পুনরায় সফলভাবে রিসেট হয়েছে');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function view($id, $type){
        try {
            $id = decrypt($id);

            $application = Application::findOrFail($id);

            if(empty($application)){
                return view('404');
            }

            $statusCode = $this->CheckBusinessValidation($application, $type);
            if($statusCode == 404)
                return view('404');

            return view('user.certificate.view', [
                'type' => $type,
                'application' => $application,
            ]);
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function issue(Request $request, $id, $type)
    {
        DB::beginTransaction();
        try {
            $id = decrypt($id);
            $old_certificates = Certificate::where('is_issue', 1)->get();

            $certificate = Certificate::where('application_id', $id)->first();
            if (!empty($certificate)){
                $certificate->is_issue = 1;
                $certificate->certificate_no = count($old_certificates);
                $certificate->issue_by = Auth::id();
                $certificate->issue_ip = $request->ip();
                $certificate->issue_date = date('y-m-d');
                $certificate->save();

                $response = Message::SendSMS($certificate->application->user->mobile, 'আপনার ভূমি ব্যবহার ছাড়পত্রের আবেদনটি নিষ্পত্তি হয়েছে');

                if($response['status'] == 'fail') {
                    DB::rollBack();
                    return back()->with('error_msg','Exception : ' . $response['message']);
                }

                DB::commit();
                return redirect()->route('application/forward', ['id' => encrypt($id), 'type' => $type])->with( 'success_msg', 'আপনার ভূমি ব্যবহার ছাড়পত্রের আবেদনটি নিষ্পত্তি হয়েছে');
            }
            DB::rollBack();
            return view('404');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function complete($id, $type)
    {
        DB::beginTransaction();
        try {
            $id = decrypt($id);
           $application = Application::findOrFail($id);

           if (empty($application))
           {
               DB::rollBack();
               return view('404');
           }
           //Check validation
            $statusCode = $this->CheckBusinessValidation($application, $type);
            if($statusCode == 404)
                return view('404');

            $application->is_complete = 1;
            $application->save();

            $received_app = RecievedApplication::where('application_id', $id)->first();
            $received_app->delete();

            $old_app_route = ApplicationRoute::where('application_id', $id)->where('to_user_id', Auth::id())->first();
            $old_app_route->is_verified = 1;
            $old_app_route->out_date = date('Y-m-d');
            $old_app_route->save();

            //verification message save
            $old_v_messages = VerificationMessage::where('application_id', $id)->get();
            $total_v_messages = count($old_v_messages);
            $last_v_message = VerificationMessage::where('application_id', $id)->orderBy('id', 'desc')->first();

            $v_message = new VerificationMessage();
            $v_message->application_id = $id;
            $v_message->user_id = Auth::id();
            $v_message->message = 'এনওসি সনদপত্র প্রদান করা হয়েছে';
            $v_message->version = $total_v_messages+1;
            $v_message->same_comment = $last_v_message->same_comment+1;
            $v_message->letter_issue_id = 0;
            $v_message->save();

            DB::commit();
            return redirect()->route('Application')->with('success_msg', 'আবেদন সম্পুর্ন হয়েছে');
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    //Helper Methods section Start:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::->
    private function CheckBusinessValidation($application, $type): int
    {
        $statusCode = 200;
        if (!Gate::allows('isInTask', 'admin')) {
            if($application->receive_application->to_user_id != Auth::id())
                $statusCode = 404;
        }
        if($application->receive_application->is_back == 0 && $type != 'FW' && $application->receive_application->is_wait == 0){
            $statusCode = 404;
        }

        if($application->receive_application->is_back == 1  && $type != 'FB' && $application->receive_application->is_wait == 0){
            $statusCode = 404;
        }

        if($application->receive_application->is_wait == 1 && $type != 'FWW'){
            $statusCode = 404;
        }

        return $statusCode;
    }

    //Helper Methods section End:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::->
}
