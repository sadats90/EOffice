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

class CancelApplicationController extends Controller
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
            $query->where('is_cancel','=', 1);

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
            return view('user.cancel.index', [
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
        $find_app = Application::where([['id', $id], ['is_cancel', 1]])->first();
        //Check cancel application
        if(!empty($find_app)) {
            return view('404');
        }

        $find_app->applicant = User::findOrFail($find_app->user_id);
        $find_app->landInfo->plut_name = LandUsePresent::findOrFail($find_app->landInfo->land_currently_use);
        $find_app->landInfo->flut_name = LandUseFuture::findOrFail($find_app->landInfo->land_future_use);

        return view('user.cancel.app_view',[
            'application' =>   $find_app,
        ]);

    }

    public function paperView($id)
    {
        $id = decrypt($id);
        $find_app = Application::where([['id', $id], ['is_cancel', 1]])->first();

        //Check cancel application
        if(!empty($find_app)) {
            return view('404');
        }

        return view('user.cancel.viewDocument',[
            'application'   =>  $find_app,
            'documents' => ApplicationDocument::where('application_id', $find_app->id)->get(),
            'document_types' => DocumentType::all()
        ]);

    }

    public function restoreApplication($id, Request $request)
    {

        DB::beginTransaction();
        try{
            $id = decrypt($id);
            $application = Application::where([['id', $id], ['is_cancel', 1]])->first();
            if (!empty($application)){
                $application->is_cancel = 0;
                $application->save();
                DB::commit();
                return redirect()->route('Cancel')->with('success_msg', 'আবেদন পুনরুদ্ধার সফলভাবে সম্পূর্ণ হয়েছে');
            }
            return view('404');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }
}
