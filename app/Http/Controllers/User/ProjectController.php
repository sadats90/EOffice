<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $projects = Project::paginate($recordsPerPage);
            return view('user.project.index', [
                'projects' => $projects,
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
        return view('user.project.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "project_type" => 'required',
        ]);

        try {
            $project = new Project();
            $project->name = $request->name;
            $project->project_type = $request->project_type;

            $project -> save();
            return redirect()->route('Project')->with('success_msg', 'প্রকল্প যোগ করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try{
            $project = Project::findOrFail($id);
            return View('user.project.edit',
                [
                    'project' => $project
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
            $project = Project::findOrfail($id);
            $project->name = $request->name;
            $project -> save();
            return redirect()->route('Project')->with('success_msg', 'প্রকল্প সম্পাদন করা সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $project = Project::findorfail($id);
            $project->delete();
            return redirect()->route('Project')->with('success_msg', 'প্রকল্প মুছে ফেলা সফল হয়েছে');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
