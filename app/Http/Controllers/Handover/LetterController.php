<?php

namespace App\Http\Controllers\Handover;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Helpers\Message;
use App\LetterLaw;
use App\Models\Application;
use App\Models\ApplicationLandInfo;
use App\Models\ApplicationPersonalInfo;
use App\Models\BettermentFee;
use App\Models\DocumentType;
use App\Models\Fee;
use App\Models\LetterIssue;
use App\Models\LetterType;
use App\Models\ProblematicPaper;
use App\Models\Project;
use App\Models\RecievedApplication;
use App\Models\VatInvoiceForBetterment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Constraint\Count;

class LetterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index($id)
   {
       $application = Application::findOrFail($id);

       if(Gate::check('handoverIsInTask', ['admin:lp:li', $application->receive_application->to_user_id])){
           if (!empty($application)){
               return view('handover.letter.index', [
                   'letter_issues' => $application->letter_issues,
                   'id' => $id,
                   'to_user_id' => $application->receive_application->to_user_id
               ]);
           }
           return view('404');
       }
      return view('404');
   }

   public function create($id, $hit)
   {
       $application =Application::findOrFail($id);
       if(Gate::check('handoverIsInTask', ['admin:lp', $application->receive_application->to_user_id])){
           return view('handover.letter.create', [
               'id' => $id,
               'hit' => $hit,
               'application' => $application,
               'letter_types' => LetterType::all(),
               'document_types' => DocumentType::all(),
               'projects' => Project::all()
           ]);
       }
       return view('404');
   }

   public function store(Request $request, $id, $hit)
   {
       $request->validate([
           'letter_type_id'   =>  'required',
           'subject'   =>  'required',
       ]);

       DB::beginTransaction();
       try{

           $same_letter_issue = LetterIssue::where([['application_id', $id], ['letter_type_id', $request->letter_type_id], ['is_issued', 0]])->first();
           if ($same_letter_issue)
           {
               if ($hit == 'list')
                    return redirect()->route('Handover/Letter', ['id' => $id])->with('error_msg', 'আপনি আগে থেকে একটি অপ্রেরিত পত্র তৈরি করে রেখেছেন!');
                else
                    return redirect()->route('workHandover/application/forward', ['id' => $id])->with('error_msg', 'আপনি আগে থেকে একটি অপ্রেরিত পত্র তৈরি করে রেখেছেন!');
           }

           $old_letters = LetterIssue::all();
           $total_old_letter = count($old_letters);

           $letter_issue = new LetterIssue();
           $letter_issue->application_id = $id;
           $letter_issue->letter_type_id = $request->letter_type_id;
           $letter_issue->subject = $request->subject;
           $letter_issue->year = date('Y');
           $letter_issue->message =$request->message;
           $letter_issue->name =$request->name;
           $letter_issue->address =$request->address;
           if($request->letter_type_id == 4 || $request->letter_type_id == 3){
               $letter_issue->expired_date = date('Y-m-d');
           }else{
               $letter_issue->expired_date = date('Y-m-d', strtotime(str_replace('/','-', $request->expired_date)));
           }

           $letter_issue->version = $total_old_letter + 1;
           $letter_issue->save();

           if (!empty($request->implement_project)){
               $betterment_fee = new BettermentFee();
               $betterment_fee->letter_issue_id = $letter_issue->id;
               $betterment_fee->project_id = $request->implement_project;
               $betterment_fee->road_section = $request->road_section;
               $betterment_fee->vat = Fee::first()->vat;
               if (Helper::IsEnglish($request->betterment_fee))
                   $betterment_fee->betterment_fee = $request->betterment_fee;
               else
                   $betterment_fee->betterment_fee = Helper::ConvertToEnglish($request->betterment_fee);
               $betterment_fee->save();
           }

           $problematic_papers = $request->document_type_id;

           if ($problematic_papers != '')
           {
               foreach ($problematic_papers as $problematic_paper){
                   $papers = new ProblematicPaper();
                   $papers->letter_issue_id = $letter_issue->id;
                   $papers->document_type_id = $problematic_paper;
                   $papers->save();
               }
           }

         if($request->letter_type_id == 4){

            $laws = $request->law;
            foreach ($laws as $law){
                $letter_law = new LetterLaw();
                $letter_law->letter_issue_id = $letter_issue->id;
                $letter_law->law_name = $law;
                $letter_law->save();
            }
         }
           DB::commit();
           if ($hit == 'list')
               return redirect()->route('letter', ['id' => $id])->with('success_msg', 'পত্র তৈরি সফলভাবে সম্পূর্ণ হয়েছে!');
           else
               return redirect()->route('workHandover/application/forward', ['id' => $id])->with('success_msg', 'পত্র তৈরি সফলভাবে সম্পূর্ণ হয়েছে!');

       }catch (\Exception $ex){
           DB::rollBack();
           return back()->withError($ex->getMessage());
       }
   }

   public function show($id, $app_id){
       try {
           $application = Application::findOrFail($app_id);
           if(Gate::check('handoverIsInTask', ['admin:lp:li', $application->receive_application->to_user_id])){
               $personal_info = ApplicationPersonalInfo::where('application_id', $app_id)->first();
               $landInfo = ApplicationLandInfo::where('application_id', $app_id)->first();
               $user = User::findOrFail($application->user_id);
               $letter_issue = LetterIssue::findOrFail($id);
               $issued_user = '';
               if ($letter_issue->is_issued == 1){
                   $issued_user = User::findOrFail($letter_issue->user_id);
               }
               return view('handover.letter.view', [
                   'personal_info' => $personal_info,
                   'land_info' => $landInfo,
                   'user' => $user,
                   'letter_issue' => $letter_issue,
                   'id' => $app_id,
                   'issued_user' => $issued_user
               ]);
           }
          return  view('404');
       }
       catch (\Exception $ex) {
           return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
       }
   }

   public function delete($id, $app_id, $hit, $userId)
   {
       try {
           if(Gate::check('handoverIsInTask', ['admin:lp', $userId])){
               $letterIssue = LetterIssue::findorfail($id);
               if ($letterIssue->is_issued == 1){
                   if ($hit == 'list')
                       return redirect()->route('Handover/Letter', ['id' => $id])->with('error_msg', 'প্রেরিত পত্র মুছে ফেলা সম্ভব নয়।');
                   else
                       return redirect()->route('workHandover/application/forward', ['id' => $app_id])->with('error_msg', 'প্রেরিত পত্র মুছে ফেলা সম্ভব নয়।');
               }

               $letterIssue->delete();
               if ($hit == 'list')
                   return redirect()->route('Handover/Letter', ['id' => $id])->with('success_msg', 'পত্র সফলভাবে মুছে ফেলা হয়েছে।');
               else
                   return redirect()->route('workHandover/application/forward', ['id' => $app_id])->with('success_msg', 'পত্র সফলভাবে মুছে ফেলা হয়েছে।');
           }
          return view('404');
       }
       catch (\Exception $ex) {
           return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
       }
   }

   public function edit($id, $app_id, $hit)
   {
       $issue_letter =  LetterIssue::findOrFail($id);
        if(Gate::check('handoverIsInTask', ['admin:lp:li', $issue_letter->application->receive_application->to_user_id])){
            if ($issue_letter->is_issued == 1){
                if ($hit == 'list')
                    return redirect()->route('Handover/Letter', ['id' => $id])->with('error_msg', 'প্রেরিত পত্র মুছে ফেলা সম্ভব নয়।');
                else
                    return redirect()->route('workHandover/application/forward', ['id' => $app_id])->with('success_msg', 'প্রেরিত পত্র সম্পাদন সম্ভব নয়।');
            }
            return view('handover.letter.edit', [
                'app_id' => $app_id,
                'hit' => $hit,
                'letter_types' => LetterType::all(),
                'document_types' => DocumentType::all(),
                'issue_letter' => $issue_letter,
                'problem_papers' => $issue_letter->problematic_papers,
                'projects' => Project::all()
            ]);
        }
      return view('404');
   }

    public function update(Request $request, $id, $app_id, $hit)
    {
        $request->validate([
            'letter_type_id'   =>  'required',
            'subject'   =>  'required',
        ]);


        DB::beginTransaction();
        try{

            $letter_issue = LetterIssue::findOrFail($id);

            if ($letter_issue->letter_type_id == 2){
                $old_b_fee = BettermentFee::where('letter_issue_id', $letter_issue->id)->first();
                if (!empty($old_b_fee))
                    $old_b_fee->delete();
            }

            if ($letter_issue->letter_type_id == 1){
                $old_p_papers = ProblematicPaper::where('letter_issue_id', $letter_issue->id)->get();
                if (count($old_p_papers) > 0){
                    foreach ($old_p_papers as $old_p_paper){
                        $old_p_paper->delete();
                    }
                }
            }

            if ($letter_issue->letter_type_id == 4){
                $old_p_letter_laws = LetterLaw::where('letter_issue_id', $letter_issue->id)->get();
                if (count($old_p_letter_laws) > 0){
                    foreach ($old_p_letter_laws as $old_p_letter_law){
                        $old_p_letter_law->delete();
                    }
                }
            }

            $letter_issue->letter_type_id = $request->letter_type_id;
            $letter_issue->subject = $request->subject;
            $letter_issue->message =$request->message;
            $letter_issue->name =$request->name;
            $letter_issue->address =$request->address;
            if($request->letter_type_id == 4 || $request->letter_type_id == 3){

                $letter_issue->expired_date = date('Y-m-d');
            }else{

                $letter_issue->expired_date = date('Y-m-d', strtotime(str_replace('/','-', $request->expired_date)));
            }
            $letter_issue->save();

            if ($request->letter_type_id == 2){
                $betterment_fee = new BettermentFee();
                $betterment_fee->letter_issue_id = $letter_issue->id;
                $betterment_fee->project_id  = $request->implement_project;
                $betterment_fee->road_section = $request->road_section;
                $betterment_fee->vat = Fee::first()->vat;
                if (Helper::IsEnglish($request->betterment_fee))
                    $betterment_fee->betterment_fee = $request->betterment_fee;
                else
                    $betterment_fee->betterment_fee = Helper::ConvertToEnglish($request->betterment_fee);
                $betterment_fee->save();
            }

            if ($request->letter_type_id == 1)
            {
                $problematic_papers = $request->document_type_id;
                foreach ($problematic_papers as $problematic_paper){
                    $papers = new ProblematicPaper();
                    $papers->letter_issue_id = $letter_issue->id;
                    $papers->document_type_id = $problematic_paper;
                    $papers->save();
                }
            }

            if($request->letter_type_id == 4){
                $laws = $request->law;
                foreach ($laws as $law){
                    $letter_law = new LetterLaw();
                    $letter_law->letter_issue_id = $letter_issue->id;
                    $letter_law->law_name = $law;
                    $letter_law->save();
                }

                $letter_issue->name =$request->name;
                $letter_issue->address =$request->address;
                $letter_issue->save();
            }

            DB::commit();
            if ($hit == 'list')
                return redirect()->route('Handover/Letter', ['id' => $app_id])->with('success_msg', 'পত্র সফলভাবে সম্পাদিত হয়েছে।');
            else
                return redirect()->route('workHandover/application/forward', ['id' => $app_id])->with('success_msg', 'পত্র সফলভাবে সম্পাদিত হয়েছে।');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function sent($id, $app_id, $hit, $userId){
        try {
            if(Gate::check('handoverIsInTask', ['admin:li', $userId]))
            {
                $letterIssue = LetterIssue::findorfail($id);
                if (!empty($letterIssue)){

                    $old_letters = LetterIssue::where('year', date('Y'))->where('is_issued', 1)->get();
                    $total_old_letter = count($old_letters);

                    $letterIssue->sl_no = $total_old_letter + 1;
                    $letterIssue->is_issued = 1;
                    $letterIssue->issue_date = date('Y-m-d');
                    $letterIssue->user_id = $userId;
                    $letterIssue->on_behalf_of = Auth::id();
                    $letterIssue->save();


                    if($letterIssue->letter_type_id == 1 || $letterIssue->letter_type_id == 2){
                        $recieveApplication = RecievedApplication::where([['application_id', $app_id]])->first();
                        $recieveApplication->is_wait = 1;
                        $recieveApplication->save();
                    }

                    /*  Sent Mobile verification SMS  */
                    $response = Message::SendSMS($letterIssue->application->user->mobile, 'আপনার একটি চিঠি এসেছে');

                    if($response['status'] == 'fail') {
                        DB::rollBack();
                        return redirect()->back()->with('error_msg','Exception : ' . $response['message']);
                    }

                    if ($hit == 'list')
                        return redirect()->route('Handover/Letter', ['id' => $app_id])->with('success_msg', 'তথ্যাদি সংযোজনের নিমিত্ত আপনার অনুকূলে একটি পত্র জারী করা হয়েছে।');
                    else
                        return redirect()->route('workHandover/application/forward', ['id' => $app_id])->with('success_msg', 'পত্র সফলভাবে প্রেরণ হয়েছে!');
                }

            }
            return view('404');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function solveReview($id, $userId)
    {
        try {
            if(Gate::check('handoverIsInTask', ['admin:li:lp', $userId]))
            {
                $letter_issue = LetterIssue::where([['id', $id], ['is_issued', 1],['is_solved', 1]])->first();
                if (!empty($letter_issue)){
                    $application = Application::findOrFail($letter_issue->application_id);

                    return view('handover.letter.solve_review', [
                        'application' => $application,
                        'letter_issue' => $letter_issue,
                        'personal_info' =>ApplicationPersonalInfo::where('application_id', $application->id)->first(),
                        'land_info' =>  ApplicationLandInfo::where('application_id', $application->id)->first(),
                        'user' => User::findOrFail($application->user_id),
                        'issued_user' => User::findOrFail($letter_issue->user_id)
                    ]);
                }
            }
            return view('404');

        }catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }
}
