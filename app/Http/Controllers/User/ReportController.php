<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationDocument;
use App\Models\ApplicationReport;
use App\Models\ApplicationRoute;
use App\Models\Attachment;
use App\Models\BettermentFee;
use App\Models\Certificate;
use App\Models\CertificateText;
use App\Models\CertificateType;
use App\Models\DocumentType;
use App\Models\ForwardPermission;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\LetterIssue;
use App\Models\LetterType;
use App\Models\Project;
use App\Models\RecievedApplication;
use App\Models\RestoreApplication;
use App\Models\VerificationMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\Object_;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dayRange()
    {
        $reciepients = '';
        $forwarders = '';

        if (!Gate::allows('isInTask', 'admin')){
            $current_user_id = Auth::id();
            $reciepients = $this->getReceiver($current_user_id);
            $forwarders = $this->getForwarder($current_user_id);
        }

        return view('user.report.dayRange', [
            'users' => User::where('role', 'user')->where('name','<>', 'Administrator')->get(),
            'reciepients' => $reciepients,
            'forwarders' => $forwarders,
        ]);
    }

    public function dayRangeReceive(Request $request)
    {
       $request->validate([
           'user_id' => 'required',
           'date' => 'required',
           'to_date' => 'required'
       ]);

        try
        {
            $user_id = $request->user_id;
            $receipient_id = $request->receipient_id;
            $date = date('Y-m-d',strtotime(str_replace('/','-', $request->date)));
            $to_date = date('Y-m-d',strtotime(str_replace('/','-', $request->to_date)));

            $receipient = 'সব';
            $query = ApplicationRoute::query();
            $query->where('to_user_id', $user_id)->whereBetween('out_date',[$date, $to_date]);
            if (!empty($receipient_id)){
                $query->where('from_user_id', $receipient_id);
                $receipient = User::findOrfail($receipient_id)->name;
            }

            return view('user.report.dayRangeReceive', [
                'receiveApps' => $query->get(),
                'receipient' => $receipient,
                'date' => Helper::ConvertToBangla($request->date),
                'to_date' => Helper::ConvertToBangla($request->to_date),
                'user' => User::findOrFail($user_id)->name
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function dayRangeForward(Request $request)
    {
       $request->validate([
           'user_id_f' => 'required',
           'date_f' => 'required',
           'to_date_f' => 'required'
       ]);

        try
        {
            $user_id = $request->user_id_f;
            $forward_user_id = $request->forward;
            $date = date('Y-m-d',strtotime(str_replace('/','-', $request->date_f)));
            $to_date = date('Y-m-d',strtotime(str_replace('/','-', $request->to_date_f)));

            $forward_user = 'সব';
            $query = ApplicationRoute::query();
            $query->where('from_user_id', $user_id)->whereBetween('in_date',[$date, $to_date]);
            if (!empty($forward_user_id)){
                $query->where('to_user_id', $forward_user_id);
                $forward_user = User::findOrfail($forward_user_id)->name;
            }

            return view('user.report.dayRangeForward', [
                'forwardApps' => $query->get(),
                'forward_user' => $forward_user,
                'date' => Helper::ConvertToBangla($request->date_f),
                'to_date' => Helper::ConvertToBangla($request->to_date_f),
                'user' => User::findOrFail($user_id)->name
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function position()
    {
        try
        {
            $years = Application::query()->where([['is_submit', 1]])->select('year')->distinct()->get();

            $year = request()->input('year');
            $app_id = request()->input('app_id');

            $query = Application::query()->where([['is_submit', 1]]);

            if (!Gate::allows('isInTask', 'admin')) {
                $userId = Auth::id();

                $query->whereHas('application_routes', function ($q) use ($userId) {
                    $q->where('to_user_id', $userId);
                });
            }
            if (!empty($app_id)) {
              $query->where('app_id', $app_id);
            }

            if (!empty($year)) {
              $query->where('year', $year);
            }

            return view('user.report.position', [
                'applications' => $query->get(),
                'years' => $years
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function ApplicationDetails($id, $type){
        $find_app = Application::where('id', $id)->first();

        if(!empty($find_app)) {


            $forward_users = ForwardPermission::where('user_id', Auth::id())->get();
            foreach ($forward_users as $user){
                $user->permitted_user_name = User::findOrFail($user->permitted_user_id)->name;
            }

            $find_app->land_personal_info = $this->getApplicationInfo($id);
            $find_app->applicant = User::findOrFail($find_app->user_id);
            $find_app->landInfo->plut_name = LandUsePresent::findOrFail($find_app->landInfo->land_currently_use);
            $find_app->landInfo->flut_name = LandUseFuture::findOrFail($find_app->landInfo->land_future_use);
            $f_v_message = VerificationMessage::where('application_id', $id)->first();
            $v_messages = VerificationMessage::where('application_id', $id)->get();
            $applicants = ApplicationApplicant::where('application_personal_info_id', $find_app->personalInfo->id)->get();
            if ($type == 'new'){
                $find_app->report = ApplicationReport::where('application_id', $id)->first();
            }
            return view('user.report.applicationDetails',[
                'application'   =>  $find_app,
                'type' =>   $type,
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
                'attachments' => Attachment::where([['application_id', $id]])->get(),
                'projects' => Project::all(),
                'certificateTypes' => CertificateType::all(),
                'CertificateTexts' => CertificateText::all()
            ]);
        }
        return view('404');
    }

    public function bettermentFee()
  {
        try
        {
            $years = LetterIssue::query()->where([['is_bm_fee_payment', 1], ['is_issued', 1], ['letter_type_id', 2]])->select('year')->distinct()->get();

            $year = request()->input('year');
            $project_id = request()->input('project_id');

            $query = LetterIssue::query()->where([['is_bm_fee_payment', 1], ['is_issued', 1], ['letter_type_id', 2]]);
            if (!empty($year)) {
                $query->where('year', $year);
            }
            if (!empty($project_id)) {
                $query->whereHas('betterment_fee', function ($q) use ($project_id) {
                    $q->where('project_id', $project_id);
                });
            }
            return view('user.report.bettermentFee', [
                'letters' => $query->get(),
                'years' => $years,
                'projects' => Project::all()
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
  }

    public function letterIssue()
    {
        try
        {
            $years = LetterIssue::query()->where([['is_issued', 1]])->select('year')->distinct()->get();

           $year = request()->input('year');
           $query = LetterIssue::query()->where([['is_issued', 1]]);
            if (!empty($year)) {
                $query->where('year', $year);
           }
            return view('user.report.letterIssue', [
                'letters' => $query->get(),
                'years' => $years
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function certificateIssue()
    {
        try
        {
            $years = Certificate::query()->where([['is_issue', 1]])->select('year')->distinct()->get();

           $year = request()->input('year');
           $query = Certificate::query()->where([['is_issue', 1]]);
            if (!empty($year)) {
                $query->where('year', $year);
           }
            return view('user.report.certificateIssue', [
                'certificates' => $query->get(),
                'years' => $years
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function landUse()
    {
        try
        {
            $from = request()->input('dateFrom');
            $to = request()->input('dateTo');
            $land_use_type = request()->input('land_use_type');
            $app_id = request()->input('app_id');

            $query = Application::query()->where('is_submit', 1);

            if (!empty($from)) {
                $query->where('submission_date', '>=', date('Y-m-d', strtotime(str_replace('/','-',$from ))));
            }
            if (!empty($to)) {
                $query->where('submission_date', '<=',date('Y-m-d', strtotime(str_replace('/','-',$to ))));
            }
            if (!empty($app_id)) {
                $query->where('app_id', $app_id);
            }
            if (!empty($land_use_type)) {
                $query->whereHas('landInfo', function ($q) use ($land_use_type) {
                    $q->where('land_future_use', $land_use_type);
                });
            }

            return view('user.report.land_use', [
                'applications' => $query->get(),
                'land_future_use_types' => LandUseFuture::all()
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function restoreReport()
    {
        try
        {
            $from = request()->input('dateFrom');
            $to = request()->input('dateTo');
            $appId = request()->input('appId');
            $appType = request()->input('appType');

            $query = RestoreApplication::query();

            if (!empty($from)) {
                $query->where('created_at', '>=', date('Y-m-d', strtotime(str_replace('/','-',$from ))));
            }
            if (!empty($to)) {
                $query->where('created_at', '<=',date('Y-m-d', strtotime(str_replace('/','-',$to ))));
            }

            if (!empty($appId)) {
                $query->whereHas('LetterIssue', function ($q) use ($appId) {
                    $q->whereHas('application', function ($qNext) use ($appId) {
                        $qNext->where('app_id', $appId);
                    });
                });
            }

            if (!empty($appType)) {
                $query->whereHas('LetterIssue', function ($q) use ($appType) {
                    $q->whereHas('application', function ($qNext) use ($appType) {
                        $qNext->where('app_type', $appType);
                    });
                });
            }

            return view('user.report.restoreReport', [
                'restores' => $query->get(),
                'land_future_use_types' => LandUseFuture::all()
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function landUseSummary()
    {
        try
        {
            $from = request()->input('dateFrom');
            $to = request()->input('dateTo');

            $query = Application::query();

            if (!empty($from)) {
                $query->where('submission_date', '>=', date('Y-m-d', strtotime(str_replace('/','-',$from ))));
            }
            if (!empty($to)) {
                $query->where('submission_date', '<=',date('Y-m-d', strtotime(str_replace('/','-',$to ))));
            }

            return view('user.report.land_use_summary', [
                'applications' => $query->get(),
                'submitApp' => $query->where('is_submit', 1)->sum('form_buy_price'),
                'without_submit_App' => $query->where('is_submit', 0)->sum('form_buy_price'),
            ]);
        }
        catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function getRecipaint(Request $request)
    {
        $id = $request->id;
        return $this->getReceiver($id);
    }

    public function getForwardUser(Request $request)
    {
        $id = $request->id;
        return $this->getForwarder($id);
    }


    private function getReceiver($id)
    {
        $recipients = ForwardPermission::where('permitted_user_id', $id)->distinct('user_id')->get();
        foreach ($recipients as $recipient){
            $recipient->name = User::findOrFail($recipient->user_id)->name;
        }

        return $recipients;
    }

    private function getForwarder($id){

        $forwardUsers = ForwardPermission::where('user_id', $id)->get();
        foreach ($forwardUsers as $forwardUser){
            $forwardUser->name = User::findOrFail($forwardUser->permitted_user_id)->name;
        }

        return $forwardUsers;
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
