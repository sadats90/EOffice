<?php

namespace App\Http\Controllers;
use App\Models\Job;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {

        $job = Job::all();
       
        return view('jobs.index',['job'=>$job]);
        

    }

    public function create()
    {
      return view('jobs.create');


    }

    public function store(Request $request)
    {
        $job = new Job;
        $job->name = $request->input('name');
        $job->detail = $request->input('detail');
        $job->save();

        return redirect('/index2');
    }

    public function edit($id)
    {
        $job = Job::find($id);
        return view('jobs.edit',['job'=>$job]);
    }
}
