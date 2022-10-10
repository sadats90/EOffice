<?php

namespace App\Http\Controllers\Handover;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\LetterIssue;
use App\Models\RecievedApplication;
use App\Models\VerificationMessage;
use App\Models\WorkHandover;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckFailApplication');
    }
    public function index()
    {
        try {
            $current_user_id = Auth::id();

            list($recordsPerPage, $query) = $this->GetRecieveApplication();

            $new_application = $query->where([['is_back', 0], ['is_wait', 0]])->orderBy('updated_at', 'asc')->paginate($recordsPerPage);

            foreach ($new_application as $na) {
                $na->application = Application::findOrFail($na->application_id);
                $na->applicant_name = User::findOrFail($na->application->user_id)->name;
                $na->letters = LetterIssue::where([['application_id', $na->application_id], ['is_issued', 1]])->get();
            }

            list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCount();

            return view('handover.application.index', [
                'application' => $new_application,
                'new_app_count' => $new_app_count,
                'back_app_count' => $back_app_count,
                'wait_app_count' => $wait_app_count,
                'type' => 'fw'
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function back()
    {
        try {

            list($recordsPerPage, $query) = $this->GetRecieveApplication();

            $new_application = $query->where('is_back', 1)->where('is_wait', 0)->orderBy('updated_at', 'asc')->paginate($recordsPerPage);
            list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCount();

            foreach ($new_application as $na) {
                $na->application = Application::findOrFail($na->application_id);
                $na->applicant_name = User::findOrFail($na->application->user_id)->name;
                $na->letters = LetterIssue::where([['application_id', $na->application_id], ['is_issued', 1]])->get();
            }

            return view('handover.application.back', [
                'application' => $new_application,
                'new_app_count' => $new_app_count,
                'back_app_count' => $back_app_count,
                'wait_app_count' => $wait_app_count,
                'type' => 'FB'
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function Wait()
    {
        try {

            list($recordsPerPage, $query) = $this->GetRecieveApplication();

            $new_application = $query->where('is_wait', 1)->orderBy('updated_at', 'asc')->paginate($recordsPerPage);

            list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCount();

            foreach ($new_application as $na) {
                $na->application = Application::findOrFail($na->application_id);
                $na->applicant_name = User::findOrFail($na->application->user_id)->name;
                $na->letters = LetterIssue::where([['application_id', $na->application_id], ['is_issued', 1]])->get();
            }

            return view('handover.application.wait', [
                'application' => $new_application,
                'new_app_count' => $new_app_count,
                'back_app_count' => $back_app_count,
                'wait_app_count' => $wait_app_count,
                'type' => 'FB'
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function view($id)
    {
        $find_app = $this->getApplicationInfo($id);
        if(!empty($find_app)){
            return view('handover.application.view',[
                'application' =>   $find_app
            ]);
        }
        return view('404');
    }

    public function viewPaper($id)
    {
        $find_app = Application::findOrFail($id);
        if(!empty($find_app)) {
            return view('handover.application.viewDocument',[
                'application'   =>  $find_app,
                'documents' => ApplicationDocument::where('application_id', $find_app->id)->get(),
                'document_types' => DocumentType::all()
            ]);
        }
        return view('404');
    }

    public function report($id)
    {
        $find_app = Application::findOrFail($id);
        if (!empty($find_app)){
            $f_v_message = VerificationMessage::where('application_id', $id)->first();
            $v_messages = VerificationMessage::where('application_id', $id)->get();
            return view('handover.application.view_report',[
                'application' =>   $find_app,
                'f_v_message' => $f_v_message,
                'v_messages' => $v_messages
            ]);
        }
        return view('404');
    }

    public function userInfo(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->designation = Designation::findOrFail($user->designation_id)->name;
        return $user;
    }

    //helper function-------------------------------
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
    //-------------------------------

    /**
     * @return array
     */
    protected function GetRecieveApplication(): array
    {
        $recordsPerPage = 50;

        $query = $this->GetApplication();

        $type = request()->input('app_type');
        $app_id = request()->input('app_id');
        $mobile = request()->input('mobile');

        if (!empty($type)) {
            $query->whereHas('application', function ($q) use ($type) {
                $q->where('app_type', $type);
            });
        }

        if (!empty($app_id)) {
            if (!Helper::IsEnglish($app_id))
                $app_id = Helper::ConvertToEnglish($app_id);

            $query->whereHas('application', function ($q) use ($app_id) {
                $q->where('app_id', $app_id);
            });
        }

        if (!empty($mobile)) {
            if (!Helper::IsEnglish($mobile))
                $mobile = Helper::ConvertToEnglish($mobile);

            $query->whereHas('application', function ($q) use ($mobile) {
                $q->whereHas('user', function ($q) use ($mobile) {
                    $q->where('mobile', $mobile);
                });
            });
        }
        return array($recordsPerPage, $query);
    }

    /**
     * @return array
     */
    protected function AppCount(): array
    {
        $new = $this->GetApplication();
        $back = $this->GetApplication();
        $wait = $this->GetApplication();

        $new_app_count = count($new->where([['is_back', 0], ['is_wait', 0]])->get());
        $back_app_count = count($back->where([['is_back', 1], ['is_wait', 0]])->get());
        $wait_app_count = count($wait->where([['is_wait', 1]])->get());
        return array($new_app_count, $back_app_count, $wait_app_count);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function GetApplication(): \Illuminate\Database\Eloquent\Builder
    {
        $query = RecievedApplication::query();
        $is_fail = 0;
        $is_cancel = 0;
        $workHandovers = WorkHandover::where([['user_id', Auth::id()], ['end_date', null]])->select('from_user_id')->get();

        $query->whereIn('to_user_id', $workHandovers->toArray());

        $query->whereHas('application', function ($q) use ($is_cancel) {
            $q->where('is_cancel', $is_cancel);
        });
        $query->whereHas('application', function ($q) use ($is_fail) {
            $q->where('is_failed', $is_fail);
        });
        return $query;
    }
}
