<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function ChangeLanguage($lng)
    {
        Session::put('applocale',$lng);
        return redirect()->back();
    }
}
