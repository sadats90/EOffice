<?php

namespace App\Http\Controllers\User;

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

   public function index($id, $type)
   {
       $id = decrypt($id);

       $application = Application::findOrFail($id);
       if (!empty($application)){
           return view('user.letter.index', [
               'application' => $application,
               'letter_issues' => $application->letter_issues,
               'type' => $type,
               'id' => $id
           ]);
       }
       return view('404');
   }

   public function create($id, $type, $hit)
   {
       $id = decrypt($id);

       return view('user.letter.create', [
           'id' => $id,
           'type' => $type,
           'hit' => $hit,
           'application' => Application::findOrFail($id),
           'letter_types' => LetterType::all(),
           'document_types' => DocumentType::all(),
           'projects' => Project::where('project_type', 1)->get()
       ]);
   }

   public function store(Request $request, $id, $type, $hit)
   {
       $request->validate([
           'letter_type_id'   =>  'required',
           'subject'   =>  'required',
           'expired_date'   =>  'required',
       ]);

       DB::beginTransaction();
       try{
           $id = decrypt($id);
           $same_letter_issue = LetterIssue::where([['application_id', $id], ['letter_type_id', $request->letter_type_id], ['is_issued', 0]])->first();
           if ($same_letter_issue)
           {
               if ($hit == 'list')
                    return redirect()->route('letter', ['id' => $id, 'type' => $type])->with('error_msg', 'আগে থেকে চিঠি তৈরি করা আছে!');
                else
                    return redirect()->route('application/forward', ['id' => $id, 'type' => $type])->with('error_msg', 'আগে থেকে চিঠি তৈরি করা আছে!');
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
           $letter_issue->expired_date = date('Y-m-d', strtotime(str_replace('/','-', $request->expired_date)));
           $letter_issue->version = $total_old_letter + 1;
           $letter_issue->save();

           if (!empty($request->implement_project)){
               $betterment_fee = new BettermentFee();
               $betterment_fee->letter_issue_id = $letter_issue->id;
               $betterment_fee->project_id = $request->implement_project;
               $betterment_fee->road_section = $request->road_section;
               $betterment_fee->is_promise_required = $request->promise == null ? 0 : 1;
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
               return redirect()->route('letter', ['id' => encrypt($id), 'type' => $type])->with('success_msg', 'চিঠি তৈরি করা সফল হয়েছে!');
           else
               return redirect()->route('application/forward', ['id' => encrypt($id), 'type' => $type])->with('success_msg', 'চিঠি তৈরি করা সফল হয়েছে!');
       }catch (\Exception $ex){
           DB::rollBack();
           return back()->withError($ex->getMessage());
       }
   }

   public function show($id, $app_id){
       try {

           $id = decrypt($id);
           $app_id = decrypt($app_id);

           $application = Application::findOrFail($app_id);
           $personal_info = ApplicationPersonalInfo::where('application_id', $app_id)->first();
           $landInfo = ApplicationLandInfo::where('application_id', $app_id)->first();
           $user = User::findOrFail($application->user_id);
           $letter_issue = LetterIssue::findOrFail($id);
           $issued_user = '';
           if ($letter_issue->is_issued == 1){
               $issued_user = User::findOrFail($letter_issue->user_id);
           }
           return view('user.letter.view', [
               'personal_info' => $personal_info,
               'land_info' => $landInfo,
               'user' => $user,
               'letter_issue' => $letter_issue,
               'id' => $app_id,
               'issued_user' => $issued_user
           ]);
       }
       catch (\Exception $ex) {
           return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
       }
   }

   public function delete($id, $app_id, $type, $hit)
   {
       try {
           $id = decrypt($id);
           $app_id = decrypt($app_id);

           list($statusCode, $issue_letter) = $this->GetLettersWithBusinessValidations($id, $app_id, $type);
             if ($statusCode == 404)
                 return view('404');

           $issue_letter->delete();
           if ($hit == 'list')
               return redirect()->route('letter', ['id' => encrypt($id), 'type' => $type])->with('success_msg', 'চিঠি মুছে ফেলা সফল হয়েছে!');
           else
               return redirect()->route('application/forward', ['id' => encrypt($app_id), 'type' => $type])->with('success_msg', 'চিঠি মুছে ফেলা সফল হয়েছে!');
       }
       catch (\Exception $ex) {
           return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
       }
   }

   public function edit($id, $app_id, $type, $hit)
   {
       $id = decrypt($id);
       $app_id = decrypt($app_id);

        list($statusCode, $issue_letter) = $this->GetLettersWithBusinessValidations($id, $app_id, $type);

        if ($statusCode == 404)
            return view('404');

       return view('user.letter.edit', [
           'app_id' => $app_id,
           'type' => $type,
           'hit' => $hit,
           'letter_types' => LetterType::all(),
           'document_types' => DocumentType::all(),
           'issue_letter' => $issue_letter,
           'problem_papers' => $issue_letter->problematic_papers,
           'projects' => Project::where('project_type', 1)->get()
       ]);
   }



    public function update(Request $request, $id, $app_id, $type, $hit)
    {
        $request->validate([
            'letter_type_id'   =>  'required',
            'subject'   =>  'required',
            'expired_date'   =>  'required',
        ]);


        DB::beginTransaction();
        try{
            $id = decrypt($id);
            $app_id = decrypt($app_id);

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
            $letter_issue->expired_date = date('Y-m-d', strtotime(str_replace('/','-', $request->expired_date)));
            $letter_issue->save();

            if ($request->letter_type_id == 2){
                $betterment_fee = new BettermentFee();
                $betterment_fee->letter_issue_id = $letter_issue->id;
                $betterment_fee->project_id  = $request->implement_project;
                $betterment_fee->road_section = $request->road_section;
                $betterment_fee->is_promise_required = $request->promise == null ? 0 : 1;;
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
                return redirect()->route('letter', ['id' => encrypt($app_id), 'type' => $type])->with('success_msg', 'চিঠি সম্পাদন করা সফল হয়েছে!');
            else
                return redirect()->route('application/forward', ['id' => encrypt($app_id), 'type' => $type])->with('success_msg', 'চিঠি সম্পাদন করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function sent($id, $app_id, $type, $hit){
        try {
            $id = decrypt($id);
            $app_id = decrypt($app_id);

            list($statusCode, $issue_letter) = $this->GetLettersWithBusinessValidations($id, $app_id, $type);

            if ($statusCode == 404)
                return view('404');

            $old_letters = LetterIssue::where('year', date('Y'))->where('is_issued', 1)->get();
            $total_old_letter = count($old_letters);

            $issue_letter->sl_no = $total_old_letter + 1;
            $issue_letter->is_issued = 1;
            $issue_letter->issue_date = date('Y-m-d');
            $issue_letter->user_id = Auth::id();
            $issue_letter->save();


            if($issue_letter->letter_type_id == 1 || $issue_letter->letter_type_id == 2){
                $recieveApplication = RecievedApplication::where([['application_id', $app_id]])->first();
                $recieveApplication->is_wait = 1;
                $recieveApplication->save();
            }

            /*  Sent Mobile verification SMS  */
            $response = Message::SendSMS($issue_letter->application->user->mobile, 'আপনার অনুকূলে একটি পত্র জারী করা হয়েছে, পত্রের নির্দেশনা মোতাবেক কার্যক্রম গ্রহণের জন্য অণুরোধ করা হল');

            if($response['status'] == 'fail') {
                DB::rollBack();
                return redirect()->back()->with('error_msg','Exception : ' . $response['message']);
            }

            if ($hit == 'list')
                return redirect()->route('letter', ['id' => encrypt($app_id), 'type' => $type])->with('success_msg', 'চিঠি প্রেরণ সফল হয়েছে!');
            else
                return redirect()->route('application/forward', ['id' => encrypt($app_id), 'type' => $type])->with('success_msg', 'চিঠি প্রেরণ সফল হয়েছে!');
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function solveReview($id)
    {
        try {
            $id = decrypt($id);

            $letter_issue = LetterIssue::where([['id', $id], ['is_issued', 1],['is_solved', 1]])->first();
            if (empty($letter_issue))
                return view('404');

            $application = Application::findOrFail($letter_issue->application_id);

            if($application->is_new == 0){
                if (!Gate::allows('isInTask', 'admin')) {
                    if($application->receive_application->to_user_id != Auth::id())
                        return view('404');
                }
            }

            return view('user.letter.solve_review', [
                'application' => $application,
                'letter_issue' => $letter_issue,
                'personal_info' =>ApplicationPersonalInfo::where('application_id', $application->id)->first(),
                'land_info' =>  ApplicationLandInfo::where('application_id', $application->id)->first(),
                'user' => User::findOrFail($application->user_id),
                'issued_user' => User::findOrFail($letter_issue->user_id)
            ]);

        }catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function cancelApplication($id){

        DB::beginTransaction();
        try {
            $id = decrypt($id);
            $application = Application::where([['id', $id], ['is_failed', 0],['is_cancel', 0], ['is_complete', 0]])->first();
            if(empty($application))
                return view('404');

            if($application->is_new == 0){

                if($application->receive_application->is_wait == 1)
                    return view('404');

                if (!Gate::allows('isInTask', 'admin')) {
                    if($application->receive_application->to_user_id != Auth::id())
                        return view('404');
                }
            }
            $application->is_cancel = 1;
            $application->save();
            DB::commit();
            return back()->with('success_msg', 'আবেদন বাতিল করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    //Helper Method
    private function GetLettersWithBusinessValidations($id, $app_id, $type): array
    {
        $statusCode = 200;
        //Check application business validation START:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $application = Application::where([['id', $app_id], ['is_failed', 0], ['is_cancel', 0], ['is_complete', 0]])->first();

        if(empty($application))
            $statusCode = 404;

        if($application->is_new == 0){
            if($application->receive_application->is_wait == 1)
                $statusCode = 404;
            if($application->receive_application->is_back == 0 && $type != 'FW' && $application->receive_application->is_wait == 0)
                $statusCode = 404;

            if($application->receive_application->is_back == 1  && $type != 'FB' && $application->receive_application->is_wait == 0)
                $statusCode = 404;

            if($application->receive_application->is_wait == 1 && $type != 'FWW')
                $statusCode = 404;

            if (!Gate::allows('isInTask', 'admin')) {
                if($application->receive_application->to_user_id != Auth::id())
                    $statusCode = 404;
            }
        }else{
            $firstApplicationId = DB::table('applications')->where([['is_new', 1], ['is_complete', 0], ['is_cancel', 0]])->first()->id;

            if($app_id != $firstApplicationId && $application->app_type != 'Emergency')
                $statusCode = 404;

            if($type != 'new')
                $statusCode = 404;

        }
        //Check application business validation END:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        //Check Letter business validation Start:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $issue_letter =  LetterIssue::where([['id', $id], ['application_id', $app_id], ['is_issued', 0]])->first();
        if(empty($issue_letter))
            $statusCode = 404;

        //Check Letter business validation Start:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        return array($statusCode, $issue_letter);
    }

}

