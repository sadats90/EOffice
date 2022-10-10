<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        return view('applicant.dashboard.index');
    }
    public function track()
    {
        return view('applicant.track.track');
    }

    public function trackResult(Request $request)
    {
        $id = $request->id;
        if (!Helper::IsEnglish($request->id))
            $id = Helper::ConvertToEnglish($request->id);

        $application = Application::where('app_id', $id)->where('user_id', Auth::id())->first();
        if (!empty($application)){
            return view('applicant.track.track_result', [
                'application'=>$application
            ]);
        }
      return redirect()->route('applicant/applications/track')->with('error_msg', 'কোন আবেদন পাওয়া যায়নি');
    }

} // end of class
