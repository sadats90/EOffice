<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CertificateText;
use App\Models\District;
use App\Models\Project;
use Illuminate\Http\Request;

class CertificateTextController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $recordsPerPage = 20;
            $certificate_text = CertificateText::paginate($recordsPerPage);
            return view('user.CertificateText.index', [
                'certificate_text' => $certificate_text,
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
        return view('user.CertificateText.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => 'required',
            "body_text" => 'required',
        ]);

        try {
            $certificate_text = new CertificateText();
            $certificate_text->title = $request->title;
            $certificate_text->body_text = $request->body_text;

            $certificate_text -> save();
            return redirect()->route('CertificateText')->with('success_msg', 'এনওসি সনদপত্রের শর্তাদি সফলভাবে যোগ হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try{
            $certificateText = CertificateText::findOrFail($id);
            return View('user.CertificateText.edit',
                [
                    'certificate_text' => $certificateText
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
            "title" => 'required',
            "body_text" => 'required',
        ]);

        try {
            $certificateText = CertificateText::findOrfail($id);
            $certificateText->title = $request->title;
            $certificateText->body_text = $request->body_text;
            $certificateText -> save();
            return redirect()->route('CertificateText')->with('success_msg', 'এনওসি সনদপত্রের শর্তাদি সফলভাবে সম্পাদন হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $certificateText = CertificateText::findorfail($id);
            $certificateText->delete();
            return redirect()->route('CertificateText')->with('success_msg', 'এনওসি সনদপত্রের শর্তাদি সফলভাবে মুছে হয়েছে');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
