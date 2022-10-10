<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationDocument;
use App\Models\DocumentType;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\RecievedApplication;
use App\Models\VerificationMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CompleteApplicationController extends Controller
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
            $query->where([['is_complete', 1], ['correction_request_status', '<>', 1],  ['correction_request_status', '<>', 3]]);
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
            return view('user.complete.index', [
                'application' => $complete_app
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function applicationView($id)
    {
        $id = decrypt($id);
        $find_app = Application::where('id', $id)->first();

        if(empty($find_app)){
            return view('404');
        }

        $find_app->applicant = User::findOrFail($find_app->user_id);
        $find_app->landInfo->plut_name = LandUsePresent::findOrFail($find_app->landInfo->land_currently_use);
        $find_app->landInfo->flut_name = LandUseFuture::findOrFail($find_app->landInfo->land_future_use);

        return view('user.complete.app_view',[
            'application' =>   $find_app
        ]);

    }

    public function paperView($id)
    {
        $id = decrypt($id);
        $find_app = Application::where('id', $id)->first();

        if(!empty($find_app)) {
            return view('user.complete.viewDocument',[
                'application'   =>  $find_app,
                'documents' => ApplicationDocument::where('application_id', $find_app->id)->get(),
                'document_types' => DocumentType::all()
            ]);
        }
        return view('404');
    }

    public function reportView($id)
    {
        $id = decrypt($id);
        $find_app = Application::where('id', $id)->first();

        if (!empty($find_app)){

            $f_v_message = VerificationMessage::where('application_id', $id)->first();
            $v_messages = VerificationMessage::where('application_id', $id)->get();
            return view('user.complete.view_report',[
                'application' =>   $find_app,
                'f_v_message' => $f_v_message,
                'v_messages' => $v_messages
            ]);
        }
        return view('404');
    }

    public function letters($id)
    {
        $id = decrypt($id);
        $find_app = Application::where('id', $id)->first();

        if (!empty($find_app)){
            return view('user.complete.letters', [
                'letter_issues' => $find_app->letter_issues,
                'id' => $id
            ]);
        }
        return view('404');
    }
    public function certificate($id){
        try {
            $code_to_view = $id;
           
            $id = decrypt($id);
            $application = Application::where('id', $id)->first();
            return view('user.complete.certificate', [
                'application' => $application,
                'applicants' => ApplicationApplicant::where('application_personal_info_id', $application->personalInfo->id)->get(),
                'code_to_view' => $code_to_view
            ]);
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

}
