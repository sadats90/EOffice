<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationDocument;
use App\Models\ApplicationReport;
use App\Models\Attachment;
use App\Models\CertificateText;
use App\Models\CertificateType;
use App\Models\CorrectionRequest;
use App\Models\DocumentType;
use App\Models\ForwardPermission;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\LetterIssue;
use App\Models\LetterType;
use App\Models\Project;
use App\Models\VerificationMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SwarakReplacementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $recordsPerPage = 50;

            $query = Application::query();
            $query->where([['is_complete', 1], ['correction_request_status', 3]]);
            $app_id = request()->input('app_id');
            $mobile = request()->input('mobile');

            if (!empty($app_id)){
                if (!Helper::IsEnglish($app_id))
                    $app_id = Helper::ConvertToEnglish($app_id);

                $query->where('app_id', $app_id);
            }

            if (!empty($mobile)){
                if (!Helper::IsEnglish($mobile))
                    $mobile = Helper::ConvertToEnglish($mobile);

                $query->whereHas('user', function ($q) use ($mobile){
                    $q->where('mobile','like', '%'.$mobile.'%');
                });
            }

            $complete_app = $query->orderBy('submission_date', 'desc')->paginate($recordsPerPage);
            return view('user.swarakReplacement.index', [
                'application' => $complete_app
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function details($id){
        $id = decrypt($id);
        $application = Application::where([['id', $id], ['correction_request_status', '<>', 0]])->first();
        if(!empty($application)){
            return view('user.swarakReplacement.details', [
                'application' => $application
            ]);
        }
        return redirect()->back()->with('error_msg','404. Not Found');
    }

    public function request()
    {
        try {

            $recordsPerPage = 50;

            $app_id = request()->input('app_id');

            $query = CorrectionRequest::query();
            $query->where([['submitted_at', '<>', null], ['status', 1]]);

            if (!empty($app_id)){
                if (!Helper::IsEnglish($app_id))
                    $app_id = Helper::ConvertToEnglish($app_id);

                $query->whereHas('application', function ($q) use ($app_id){
                    $q->where('app_id', $app_id);
                });
            }



            $replacementRequests = $query->orderBy('submitted_at', 'desc')->paginate($recordsPerPage);
            return view('user.swarakReplacement.request', [
                'replacementRequests' => $replacementRequests
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function review($id){
        $id = decrypt($id);
        $application = Application::where([['id', $id], ['correction_request_status', 1]])->first();
        if(!empty($application)){

            $application->land_personal_info = $this->getApplicationInfo($id);
            $application->applicant = User::findOrFail($application->user_id);
            $application->landInfo->plut_name = LandUsePresent::findOrFail($application->landInfo->land_currently_use);
            $application->landInfo->flut_name = LandUseFuture::findOrFail($application->landInfo->land_future_use);
            $f_v_message = VerificationMessage::where('application_id', $id)->first();
            $v_messages = VerificationMessage::where('application_id', $id)->get();
            $applicants = ApplicationApplicant::where('application_personal_info_id', $application->personalInfo->id)->get();

            return view('user.swarakReplacement.review',[
                'application'   =>  $application,
                'type' =>   'jjj',
                'documents' => ApplicationDocument::where('application_id', $id)->get(),
                'document_types' => DocumentType::all(),
                'Letters' => LetterIssue::where('application_id', $id)->get(),
                'f_v_message' => $f_v_message,
                'v_messages' => $v_messages,
                'applicants' => $applicants,
                'letter_types' => LetterType::all(),
                'land_future_uses' => LandUseFuture::all(),
                'attachments' => Attachment::where([['application_id', $id]])->get(),
                'certificateTypes' => CertificateType::all(),
                'CertificateTexts' => CertificateText::all()
            ]);
        }
    }

    public function cancel($id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $id = decrypt($id);
            $application = Application::where([['id', $id], ['correction_request_status', 1]])->first();
            if (!empty($application)) {

                $application->correction_request_status = 2;
                $application->update();

                $correction_req = $application->correction_request;
                $correction_req->status = 2;
                $correction_req->update();

                DB::commit();
                return redirect()->back()->with('success_msg','একই স্বারকে প্রতিস্থাপনের অনুরোধ বাতিল করা সফল হয়েছে!');
            }
            return redirect()->back()->with('error_msg','404. Not Found');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function store($id, Request $request){

        $request->validate([
            'message'   =>  'required',
        ]);

        DB::beginTransaction();

        try {
            $id = decrypt($id);
            $application = Application::where([['id', $id], ['correction_request_status', 1]])->first();
            if (!empty($application)) {


                //verification message save
                $total_v_messages = count(VerificationMessage::where('application_id', $id)->get());
                $last_v_message = VerificationMessage::where('application_id', $id)->orderBy('id', 'desc')->first();

                $v_message = new VerificationMessage();
                $v_message->application_id = $id;
                $v_message->user_id =  Auth::id();
                $v_message->message = $request->message;
                $v_message->version = $total_v_messages+1;
                $v_message->letter_issue_id = 0;
                $v_message->same_comment = $last_v_message->same_comment + 1;

                $v_message->save();

//                if(!is_null($v_message->violate_to)){
//                    $violate_to_message = VerificationMessage::findOrFail($v_message->violate_to);
//                    $violate_to_message->violate_by = $v_message->id;
//                    $violate_to_message->save();
//                }

                $application->correction_request_status = 3;
                $application->update();

                $correction_req = $application->correction_request;
                $correction_req->status = 3;
                $correction_req->update();

                $certificate = $application->certificate;
                $certificate->issue_date = Carbon::now();
                $certificate->update();

                DB::commit();
                return redirect()->route('SwarakReplacement/request')->with('success_msg', 'একই স্বারকে প্রতিস্থাপন সফল হয়েছে!');
            }
            return redirect()->back()->with('error_msg','404. Not Found');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    private function getApplicationInfo($app_id)
    {
        $find_app = Application::findOrFail($app_id);

        if(!empty($find_app)) {
            $find_app->applicant = User::findOrFail($find_app->user_id);
            $find_app->landInfo->plut_name = LandUsePresent::findOrFail($find_app->landInfo->land_currently_use);
            $find_app->landInfo->flut_name = LandUseFuture::findOrFail($find_app->landInfo->land_future_use);
            return $find_app;
        }
        return $find_app;
    }
}
