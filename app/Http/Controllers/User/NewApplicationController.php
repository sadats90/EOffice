<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Application;
use App\User;
use Illuminate\Http\Request;

class NewApplicationController extends Controller
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
            $query->where([['is_new', 1], ['is_complete', 0], ['is_cancel', 0]]);

            $type = request()->input('app_type');
            $app_id = request()->input('app_id');
            $mobile = request()->input('mobile');

            if (!empty($type)) {
                $query->where('app_type', $type);
            }
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

            $new_application = $query->orderBy('app_id', 'asc')->paginate($recordsPerPage);
            foreach ($new_application as $na) {
                $na->applicant_name = User::findOrFail($na->user_id)->name;
                $na->applicant_mobile = User::findOrFail($na->user_id)->mobile;
            }
            return view('user.newApplication.index', [
                'new_application' => $new_application
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }
}
