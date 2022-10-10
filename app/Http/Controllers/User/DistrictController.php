<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $districts = District::paginate($recordsPerPage);
            return view('user.district.index', [
                'districts' => $districts,
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
        return view('user.district.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $district = new District();
            $district->name = $request->name;

            $district -> save();
            return redirect()->route('District')->with('success_msg', 'জেলা যোগ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try{
            $district = District::findOrFail($id);
            return View('user.district.edit',
                [
                    'district' => $district
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
        ]);

        try {
            $district = District::findOrfail($id);
            $district->name = $request->name;
            $district -> save();
            return redirect()->route('District')->with('success_msg', 'জেলা সম্পাদন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $district = District::findorfail($id);
            $district->delete();
            return redirect()->route('District')->with('success_msg', 'জেলা মুছে ফেলা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
