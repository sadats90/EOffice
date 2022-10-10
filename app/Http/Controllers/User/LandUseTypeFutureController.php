<?php

namespace App\Http\Controllers\User;

use App\Http\Helpers\Helper;
use App\Models\LandUseFuture;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LandUseTypeFutureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $fluts = LandUseFuture::orderBy('created_at','desc')->paginate($recordsPerPage);
            return view('user.landUseFuture.index', [
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
        return view('user.landUseFuture.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'flut_name'    =>  'required',
            'cost'         =>   'required'
        ]);

        DB::beginTransaction();
        try{
            $flut = new LandUseFuture();
            $flut->flut_name = $request->flut_name;
            if (Helper::IsEnglish($request->cost))
                $flut->cost = $request->cost;
            else
                $flut->cost = Helper::ConvertToEnglish($request->cost);

            $flut->created_by = Auth::user()->id;
            $flut->created_ip = $request->ip();
            $flut->save();
            DB::commit();
            return redirect()->route('LandUseFuture')->with('success_msg', 'জমির ভবিষ্যত ব্যবহারের ধরণ যোগ করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function edit($id)
    {
        $flut = LandUseFuture::findOrFail($id);
        return view('user.landUseFuture.edit',['model'=>$flut]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'flut_name'    =>  'required',
            'cost'         =>   'required'
        ]);

        DB::beginTransaction();
        try{
            $flut = LandUseFuture::find($id);
            $flut->flut_name = $request->flut_name;
            if (Helper::IsEnglish($request->cost))
                $flut->cost = $request->cost;
            else
                $flut->cost = Helper::ConvertToEnglish($request->cost);

            $flut->updated_by = Auth::user()->id;
            $flut->updated_ip = $request->ip();
            $flut->save();
            DB::commit();
            return redirect()->route('LandUseFuture')->with('success_msg', 'জমির ভবিষ্যত ব্যবহারের ধরণ সম্পাদন করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $flut = LandUseFuture::findOrFail($id);
            $flut->delete();
            DB::commit();
            return redirect()->route('LandUseFuture')->with('success_msg', 'জমির ভবিষ্যত ব্যবহারের ধরণ মুছে ফেলা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function enable($id)
    {
        DB::beginTransaction();
        try{
            $plut = LandUseFuture::find($id);
            $plut->status = 1;
            $plut->save();
            DB::commit();
            return redirect()->route('LandUseFuture')->with('success_msg', 'জমির ভবিষ্যত ব্যবহারের ধরণ অক্ষম করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function disable($id)
    {
        DB::beginTransaction();
        try{
            $plut = LandUseFuture::find($id);
            $plut->status = 0;
            $plut->save();
            DB::commit();
            return redirect()->route('LandUseFuture')->with('success_msg', 'জমির ভবিষ্যত ব্যবহারের ধরণ অক্ষম করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }
}
