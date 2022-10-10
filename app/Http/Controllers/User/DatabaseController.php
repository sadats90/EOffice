<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\RecievedApplication;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user.dashboard.index');
    }

    public function BackupDatabase()
    {
        try {
            Artisan::call('backup:database');
            return redirect()->route('database/ProcessDatabase')->with('db_backup','yes');
        }
        catch (QueryException $x) {
            return $x;
        }

    }

    public function ProcessDatabase()
    {
        if(session('db_backup') == 'yes')
            return view('user.database.download_db');
        else
            return redirect('/user/dashboard');
    }

    public function DownloadDatabase()
    {
        return response()->download(base_path('database/dump.sql'), 'backup-database-'.date('d-m-Y').'.sql');
    }
}
