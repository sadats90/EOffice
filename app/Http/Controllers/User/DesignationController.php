<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\ApplicationType;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $designation = Designation::where([
                ['name', '<>', 'আইটি এডমিন'], ['name', '<>', 'আবেদনকারী']
            ])->orderBy('priority')->paginate($recordsPerPage);
            return view('user.designation.index', [
                'model' => $designation,
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
        return view('user.designation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'priority'=>'required'
        ]);

        try {
            $designation = new Designation();
            $designation->name = $request->name;
            $designation->priority = $request->priority;
            $designation -> save();

            return redirect()->route('Designation')->with('success_msg', 'পদবী যোগ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try{
            $designation = Designation::findOrFail($id);
            return View('user.designation.edit', ['model' => $designation,]);
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
            'priority'=>'required'
        ]);

        try {
            $designation = Designation::findOrfail($id);
            $designation->name = $request->name;
            $designation->priority = $request->priority;

            $designation -> save();

            return redirect()->route('Designation')->with('success_msg', 'পদবী সম্পাদন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $designation = Designation::findorfail($id);
            $designation->delete();
            return redirect()->route('Designation')->with('success_msg', 'পদবী মুছে ফেলা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
