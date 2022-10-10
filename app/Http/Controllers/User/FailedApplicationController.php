<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationDocument;
use App\Models\ApplicationRoute;
use App\Models\DocumentType;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\RecievedApplication;
use App\Models\RestoreApplication;
use App\Models\VerificationMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FailedApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;

            $query = Application::query();
            $query->where('is_failed','=', 1);

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
            return view('user.failed.index', [
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
        $find_app = Application::where([['id', $id], ['is_failed', 1]])->first();
        if(!empty($find_app)){
            return view('user.failed.app_view',[
                'application' =>   $find_app,
            ]);
        }
        return view('404');
    }

    public function paperView($id)
    {
        $id = decrypt($id);

        $find_app = Application::where([['id', $id], ['is_failed', 1]])->first();

        if(empty($find_app)) {
            return view('404');
        }

        $find_app->applicant = User::findOrFail($find_app->user_id);
        $find_app->landInfo->plut_name = LandUsePresent::findOrFail($find_app->landInfo->land_currently_use);
        $find_app->landInfo->flut_name = LandUseFuture::findOrFail($find_app->landInfo->land_future_use);

        return view('user.failed.viewDocument',[
            'application'   =>  $find_app,
            'documents' => ApplicationDocument::where('application_id', $find_app->id)->get(),
            'document_types' => DocumentType::all()
        ]);

    }

    public function reportView($id)
    {
        $id = decrypt($id);

        $find_app = Application::where([['id', $id], ['is_failed', 1]])->first();

        if(empty($find_app)) {
            return view('404');
        }

        $f_v_message = VerificationMessage::where('application_id', $id)->first();
        $v_messages = VerificationMessage::where('application_id', $id)->get();
        return view('user.failed.view_report',[
            'application' =>   $find_app,
            'f_v_message' => $f_v_message,
            'v_messages' => $v_messages
        ]);
    }

    public function letters($id)
    {
        $id = decrypt($id);

        $application = Application::where([['id', $id], ['is_failed', 1]])->first();

        if(empty($application)) {
            return view('404');
        }

        return view('user.failed.letters', [
            'letter_issues' => $application->letter_issues,
            'id' => $id
        ]);
    }

    public function restore($id)
    {
        $id = decrypt($id);

        $application = Application::where([['id', $id], ['is_failed', 1]])->first();

        if(empty($application)) {
            return view('404');
        }

        return view('user.failed.restore', [
            'id' => $id
        ]);
    }

    public function restoreApplication($id, Request $request)
    {
        $id = decrypt($id);

        $request->validate([
            'ExpiredDate'   =>  'required'
        ]);

        DB::beginTransaction();
        try{
            $application = Application::where([['id', $id], ['is_failed', 1]])->first();
            if (!empty($application)){
                //Check application fail state
                if (count($application->letter_issues) > 0){
                    foreach ($application->letter_issues as $letter)
                    {
                        if($letter->letter_type_id != 3 && $letter->letter_type_id != 4){
                            if ($letter->is_issued == 1 && $letter->is_solved == 0){

                                if ($letter->expired_date < date('Y-m-d')){
                                    $application->is_failed = 0;
                                    $application->save();

                                    $routApp = ApplicationRoute::where([['application_id', $application->id], ['is_verified', 0]])->first();
                                    $routApp->is_fail = 0;
                                    $routApp->save();

                                    $restore = new RestoreApplication();
                                    $restore->letter_issue_id = $letter->id;
                                    $restore->old_expired_date = $letter->expired_date;
                                    $restore->new_expired_date = date('Y-m-d', strtotime(str_replace('/','-', $request->ExpiredDate)));
                                    $restore->created_ip = $request->ip();
                                    $restore->created_by = Auth::id();
                                    $restore->created_at = date('Y-m-d');
                                    $restore->save();

                                    $letter->expired_date = date('Y-m-d', strtotime(str_replace('/','-', $request->ExpiredDate)));
                                    $letter->save();
                                }
                            }
                        }
                    }
                    //application note initiate
                    if(!is_null($request->note)){
                        //verification message save
                        $old_v_messages = VerificationMessage::where('application_id', $id)->get();
                        $last_v_message = VerificationMessage::where('application_id', $id)->orderBy('id', 'desc')->first();
                        $v_message = new VerificationMessage();
                        $v_message->application_id = $id;
                        $v_message->user_id = Auth::id();
                        $v_message->message = $request->note;
                        $v_message->version = count($old_v_messages) + 1;
                        $v_message->same_comment = $last_v_message->same_comment + 1;
                        $v_message->letter_issue_id = 0;
                        $v_message->save();
                    }
                }
                DB::commit();
                return redirect()->route('failed')->with('success_msg', 'আবেদন পুনরুদ্ধার করা সফল হয়েছে!');
            }
            return view('404');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }


}
