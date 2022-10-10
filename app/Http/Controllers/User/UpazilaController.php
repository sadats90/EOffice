<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Upazila;
use Illuminate\Http\Request;

class UpazilaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $upazilas = Upazila::paginate($recordsPerPage);
            return view('user.upazila.index', [
                'upazilas' => $upazilas,
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function create()
    {
        return view('user.upazila.create',['districts'=>District::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'district_id' => 'Required'
        ]);

        try {
            $upazila = new Upazila();
            $upazila->name = $request->name;
            $upazila->district_id = $request->district_id;

            $upazila -> save();
            return redirect()->route('Upazila')->with('success_msg', 'থানা/উপজেলা যোগ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try{
            $upazila = Upazila::findOrFail($id);
            return View('user.upazila.edit',
                [
                    'upazila' => $upazila,
                    'districts'=> District::all()
                ]);
        }catch (\Exception $ex){
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex -> getFile().': '.$ex -> getLine()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request -> validate([
            'name' => 'required',
            'district_id' => 'Required'
        ]);

        try {
            $upazila = Upazila::findOrfail($id);
            $upazila->name = $request->name;
            $upazila->district_id = $request->district_id;

            $upazila -> save();
            return redirect()->route('Upazila')->with('success_msg', 'থানা/উপজেলা সম্পাদন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $upazila = Upazila::findorfail($id);
            $upazila->delete();
            return redirect()->route('Upazila')->with('success_msg', 'থানা/উপজেলা মুছে ফেলা সফল হয়েছে');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function getUpazila($id)
    {
         $upazilas = District::findOrfail($id)->upazilas;
         return json_encode($upazilas); ;
    }
}
