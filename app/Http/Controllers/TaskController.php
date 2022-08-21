<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    
    public function index()
    {   
       $task = Task::all();

       $inProgress = \DB::table('tasks')
       
            ->where('tasks.is_inProgress', 1 )
            
            ->get();


         $is_done =  \DB::table('tasks')
       
         ->where('tasks.is_done', 1 )
         
         ->get();  

            

       

       return view('task.index',['task' => $task, 'is_inProgress'=> $inProgress , 'is_done' => $is_done ]);
 
    }

    public function add(Request $request)
    {
        $task = new Task();
        $task->task = $request->task;

        $task->save();

        return redirect('index');
    }

    public function assign($id)
    {

        $task = Task::find($id);
        return view('task.update',['task'=> $task]);

    }


    public function change_to_done($id)
    {
        
        $tasks =Task::where('id',$id)->first();
        
        
        $tasks->is_done = '1';
        $tasks->is_inProgress = '0' ; 

        
        $tasks->update();

    return redirect('index');
        
    }


    public function change_to_inProgress($id)
    {
        
        $tasks =Task::where('id',$id)->first();
        
        
        $tasks->is_inProgress = '1';
        $tasks->is_done = '0';

        
        $tasks->update();

    return redirect('index');
        
    }


}
