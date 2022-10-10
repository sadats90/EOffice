<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationRoute;
use App\Models\Certificate;
use App\Models\CertificateDuplicate;
use App\Models\RecievedApplication;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Object_;

class CertificateDuplicateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $query = Certificate::query();
        $userId = Auth::id();
        if(Gate::allows('isInTask', 'admin')){
            $query->where('is_issue', 1);
        }else{
            $query->whereHas('certificate_duplicates', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }

        return view('user.CertificateDuplicate.index', [
            'certificates' => $query->orderBy('issue_date', 'desc')->get()
        ]);
    }

    public function view($id){
        try {

            $id = decrypt($id);
            $application = Application::findOrFail($id);

            $duplicateCertificate = CertificateDuplicate::where([['certificate_id', $application->certificate->id], ['user_id ', Auth::id()]])->first();
            if(empty($duplicateCertificate))
                return view('404');

            return view('user.CertificateDuplicate.view', [
                'application' => $application,
                'applicants' => ApplicationApplicant::where('application_personal_info_id', $application->personalInfo->id)->get(),
            ]);
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
