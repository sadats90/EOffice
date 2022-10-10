<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Bank;
use App\Models\District;
use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            return view('user.fee.index', [
                'fee' => Fee::first(),
            ]);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'application_fee' => 'required',
            'emergency_fee' => 'required',
            'vat' => 'required',
        ]);

        try {
            $fee = Fee::first();

            if(!Helper::IsEnglish($request->application_fee))
                $fee->application_fee = Helper::ConvertToEnglish($request->application_fee);
            else
                $fee->application_fee = $request->application_fee;

            if(!Helper::IsEnglish($request->emergency_fee))
                $fee->emergency_fee = Helper::ConvertToEnglish($request->emergency_fee);
            else
                $fee->emergency_fee = $request->emergency_fee;

            if(!Helper::IsEnglish($request->vat))
                $fee->vat = Helper::ConvertToEnglish($request->vat);
            else
                $fee->vat = $request->vat;

            $fee->save();

            return redirect()->route('Fee')->with('success_msg', 'ফি সংরক্ষন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }
}
