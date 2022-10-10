<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Upazila;
use App\MouzaArea;
use Illuminate\Http\Request;

class MouzaAreaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $areas = MouzaArea::paginate($recordsPerPage);
            return view('user.mouzaAreas.index', [
                'areas' => $areas,
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
        return view('user.mouzaAreas.create',['upazilas'=>Upazila::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'jl_name' => 'required',
            'upazila_id' => 'Required'
        ]);

        try {
            $area = new MouzaArea();
            $area->name = $request->name;
            $area->jl_name = $request->jl_name;
            $area->upazila_id = $request->upazila_id;

            $area -> save();
            return redirect()->route('MouzaAreas')->with('success_msg', 'মৌজা/এলাকা যোগ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try{
            $mouza = MouzaArea::findOrFail($id);
            return View('user.mouzaAreas.edit',
                [
                    'mouza' => $mouza,
                    'upazilas'=> Upazila::all()
                ]);
        }catch (\Exception $ex){
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex -> getFile().': '.$ex -> getLine()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'jl_name' => 'required',
            'upazila_id' => 'Required'
        ]);

        try {
            $mouzaArea = MouzaArea::findOrfail($id);
            $mouzaArea->name = $request->name;
            $mouzaArea->jl_name = $request->jl_name;
            $mouzaArea->upazila_id = $request->upazila_id;

            $mouzaArea -> save();
            return redirect()->route('MouzaAreas')->with('success_msg', 'মৌজা/এলাকা সম্পাদন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $mouzaArea = MouzaArea::findorfail($id);
            $mouzaArea->delete();
            return redirect()->route('MouzaAreas')->with('success_msg', 'মৌজা/এলাকা মুছে ফেলা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function getMouzaAreas(Request $request)
    {
        $mouzaAreas = MouzaArea::where('upazila_id', $request->id)->get();
         return json_encode($mouzaAreas);
    }
}
