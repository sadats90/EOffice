<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\ApplicationReport;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\LetterIssue;
use App\Models\RecievedApplication;
use App\Models\VerificationMessage;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            list($recordsPerPage, $current_user_id, $query) = $this->GetRecieveApplication();

            if (Gate::allows('isInTask', 'admin')) {
                $new_application = $query->where('is_back', 0)->where('is_wait', 0)->orderBy('updated_at', 'asc')->paginate($recordsPerPage);
                list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCount();
            }else{
                $new_application = $query->where([['to_user_id', $current_user_id], ['is_back', 0], ['is_wait', 0]])->orderBy('updated_at', 'asc')->paginate($recordsPerPage);
                list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCountByUser($current_user_id);
            }

            foreach ($new_application as $na) {
                $na->application = Application::findOrFail($na->application_id);
                $na->applicant_name = User::findOrFail($na->application->user_id)->name;
                $na->letters = LetterIssue::where([['application_id', $na->application_id], ['is_issued', 1]])->get();
            }


            return view('user.application.index', [
                'application' => $new_application,
                'new_app_count' => $new_app_count,
                'back_app_count' => $back_app_count,
                'wait_app_count' => $wait_app_count,
                'type' => 'FW'

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

            list($recordsPerPage, $current_user_id, $query) = $this->GetRecieveApplication();

            if (Gate::allows('isInTask', 'admin')) {
                $new_application = $query->where('is_back', 1)->where('is_wait', 0)->orderBy('updated_at', 'asc')->paginate($recordsPerPage);
                list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCount();
            }else{
                $new_application = $query->where([['to_user_id', $current_user_id], ['is_back', 1], ['is_wait', 0]])->orderBy('updated_at', 'asc')->paginate($recordsPerPage);
                list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCountByUser($current_user_id);
            }
            foreach ($new_application as $na) {
                $na->application = Application::findOrFail($na->application_id);
                $na->applicant_name = User::findOrFail($na->application->user_id)->name;
                $na->letters = LetterIssue::where([['application_id', $na->application_id], ['is_issued', 1]])->get();
            }


            return view('user.application.back', [
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

            list($recordsPerPage, $current_user_id, $query) = $this->GetRecieveApplication();

            if (Gate::allows('isInTask', 'admin')) {
                $new_application = $query->where('is_wait', 1)->orderBy('updated_at', 'asc')->paginate($recordsPerPage);
                list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCount();
            }else{
                $new_application = $query->where([['to_user_id', $current_user_id], ['is_wait', 1]])->orderBy('updated_at', 'asc')->paginate($recordsPerPage);
                list($new_app_count, $back_app_count, $wait_app_count) = $this->AppCountByUser($current_user_id);
            }
            foreach ($new_application as $na) {
                $na->application = Application::findOrFail($na->application_id);
                $na->applicant_name = User::findOrFail($na->application->user_id)->name;
                $na->letters = LetterIssue::where([['application_id', $na->application_id], ['is_issued', 1]])->get();
            }


            return view('user.application.wait', [
                'application' => $new_application,
                'new_app_count' => $new_app_count,
                'back_app_count' => $back_app_count,
                'wait_app_count' => $wait_app_count,
                'type' => 'FWW'
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function view($id, $type)
    {
        $id = decrypt($id);

        $find_app = Application::findOrFail($id);

        //Check Business validations start::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        if(empty($find_app)) {
            return view('404');
        }

        $statusCode = $this->CheckApplication($find_app, $type);
        if($statusCode == 404){
            return view('404');
        }
        //Check Business validations End::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        $find_app->applicant = User::findOrFail($find_app->user_id);
        $find_app->landInfo->plut_name = LandUsePresent::findOrFail($find_app->landInfo->land_currently_use);
        $find_app->landInfo->flut_name = LandUseFuture::findOrFail($find_app->landInfo->land_future_use);

        return view('user.application.view',[
            'application' =>   $find_app,
            'type' =>   $type,
        ]);

    }

    public function viewPaper($id, $type)
    {
        $id = decrypt($id);
        $find_app = Application::findOrFail($id);

        //Check Business validations start::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $statusCode = $this->CheckApplication($find_app, $type);
        if($statusCode == 404){
            return view('404');
        }
        //Check Business validations End::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        return view('user.application.viewDocument',[
            'application'   =>  $find_app,
            'type' =>   $type,
            'documents' => ApplicationDocument::where('application_id', $find_app->id)->get(),
            'document_types' => DocumentType::all()
        ]);

    }

    public function report($id, $type)
    {
        $id = decrypt($id);
        $find_app = Application::findOrFail($id);

        //Check Business validations start::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $statusCode = $this->CheckApplication($find_app, $type);
        if($statusCode == 404){
            return view('404');
        }
        //Check Business validations End::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        //Main Operation START::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $f_v_message = VerificationMessage::where('application_id', $id)->first();
        $v_messages = VerificationMessage::where('application_id', $id)->get();
        return view('user.application.view_report',[
            'application' =>   $find_app,
            'f_v_message' => $f_v_message,
            'v_messages' => $v_messages,
            'type' => $type
        ]);
        //Main Operation END::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    }

    public function userInfo(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->designation = Designation::findOrFail($user->designation_id)->name;
        return $user;
    }

    //helper function-------------------------------
    private function CheckApplication($application, $type): int
    {

        $statusCode = 200;
        if($application->is_new == 0){
            if (!Gate::allows('isInTask', 'admin')) {
                if($application->receive_application->to_user_id != Auth::id()){
                    $statusCode = 404;
                }
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
        }else{

            if (!Gate::allows('isInTask', 'admin:na')) {
                $statusCode = 404;
            }

            $firstApplicationId = DB::table('applications')->where([['is_new', 1], ['is_complete', 0], ['is_cancel', 0]])->first()->id;

            if($application->id != $firstApplicationId && $application->app_type != 'Emergency'){
                $statusCode = 404;
            }

            if($type != 'new'){
                $statusCode = 404;
            }
        }

        return $statusCode;
    }

    /**
     * @return array
     */
    protected function GetRecieveApplication(): array
    {
        $recordsPerPage = 50;
        $current_user_id = Auth::id();
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
        return array($recordsPerPage, $current_user_id, $query);
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
     * @param $current_user_id
     * @return array
     */
    protected function AppCountByUser($current_user_id): array
    {
        $new = $this->GetApplication();
        $back = $this->GetApplication();
        $wait = $this->GetApplication();

        $new_app_count = count($new->where([['to_user_id', $current_user_id], ['is_back', 0], ['is_wait', 0]])->get());
        $back_app_count = count($back->where([['to_user_id', $current_user_id], ['is_back', 1], ['is_wait', 0]])->get());
        $wait_app_count = count($wait->where([['to_user_id', $current_user_id], ['is_wait', 1]])->get());
        return array($new_app_count, $back_app_count, $wait_app_count);
    }

    /**
     * @return Builder
     */
    protected function GetApplication(): Builder
    {
        $query = RecievedApplication::query();
        $is_fail = 0;
        $is_cancel = 0;
        $query->whereHas('application', function ($q) use ($is_cancel) {
            $q->where('is_cancel', $is_cancel);
        });
        $query->whereHas('application', function ($q) use ($is_fail) {
            $q->where('is_failed', $is_fail);
        });
        return $query;
    }

}
