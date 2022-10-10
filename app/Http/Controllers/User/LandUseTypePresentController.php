<?php

namespace App\Http\Controllers\User;

use App\Models\LandUsePresent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LandUseTypePresentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $fluts = LandUsePresent::orderBy('created_at','desc')->paginate($recordsPerPage);
            return view('user.landUsePresent.index', [
                'model' => $fluts,
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
        return view('user.landUsePresent.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plut_name'    =>  'required'
        ]);

        DB::beginTransaction();
        try{
            $plut = new LandUsePresent();
            $plut->plut_name = $request->plut_name;
            $plut->created_by = Auth::user()->id;
            $plut->created_ip = $request->ip();
            $plut->save();
            DB::commit();
            return redirect()->route('LandUsePresent')->with('success_msg', 'জমির বর্তমান অবস্থা ধরণ যোগ করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

//    public function show($id)
//    {
//        return view('user::show');
//    }
//
    public function edit($id)
    {
        $plut = LandUsePresent::findOrFail($id);
        return view('user.landUsePresent.edit',['model'=>$plut]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'plut_name'    =>  'required'
        ]);

        DB::beginTransaction();
        try{
            $plut = LandUsePresent::findOrFail($id);
            $plut->plut_name = $request->plut_name;
            $plut->updated_by = Auth::user()->id;
            $plut->updated_ip = $request->ip();
            $plut->save();
            DB::commit();
            return redirect()->route('LandUsePresent')->with('success_msg', 'জমির বর্তমান অবস্থা ধরণ সম্পাদন করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $plut = LandUsePresent::findOrFail($id);
            $plut->delete();
            DB::commit();
            return redirect()->route('LandUsePresent')->with('success_msg', 'জমির বর্তমান অবস্থা ধরণ মুছে ফেলা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function enable($id)
    {
        DB::beginTransaction();
        try{
            $plut = LandUsePresent::find($id);
            $plut->status = 1;
            $plut->save();
            DB::commit();
            return redirect()->route('LandUsePresent')->with('success_msg', 'জমির বর্তমান অবস্থার ধরণ সক্ষম করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function disable($id)
    {
        DB::beginTransaction();
        try{
            $plut = LandUsePresent::find($id);
            $plut->status = 0;
            $plut->save();
            DB::commit();
            return redirect()->route('LandUsePresent')->with('success_msg', 'জমির বর্তমান অবস্থার ধরণ অক্ষম করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }
}
