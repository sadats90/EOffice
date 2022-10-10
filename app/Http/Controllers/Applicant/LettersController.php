<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\ApplicationLandInfo;
use App\Models\ApplicationPersonalInfo;
use App\Models\BettermentFee;
use App\Models\BettermentFeePayment;
use App\Models\District;
use App\Models\FeedbackPaper;
use App\Models\LandUseFuture;
use App\Models\LetterFeedback;
use App\Models\LetterIssue;
use App\Models\LetterPromise;
use App\Models\LetterType;
use App\Models\RecievedApplication;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class LettersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::id();

        $query = LetterIssue::query();

        $query->whereHas('application', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        });
        return view('applicant.letter.index',[
                'letters' => $query->where('is_issued', 1)->orderBy('id', 'desc')->get()
            ]);
    }
    public function show($id, $app_id)
    {
        try {
            $id = decrypt($id);
            $app_id = decrypt($app_id);

            $application = Application::where([['id', $app_id], ['user_id', Auth::id()]])->first();

            //Check application for current user
            if(empty($application)){
                return redirect()->back()->with('error_msg', 'কোন পত্র পাওয়া যায়নি!');
            }

            $personal_info = ApplicationPersonalInfo::where('application_id', $app_id)->first();
            $landInfo = ApplicationLandInfo::where('application_id', $app_id)->first();
            $user = User::findOrFail($application->user_id);

            $letter_issue = LetterIssue::where([['id', $id], ['application_id', $application->id]])->first();

            //Check letter for current user
            if(empty($letter_issue)){
                return redirect()->back()->with('error_msg', 'কোন পত্র পাওয়া যায়নি!');
            }
            $letter_issue->is_read = 1;
            $letter_issue->save();

            $issued_user = User::findOrFail($letter_issue->user_id);

            return view('applicant.letter.view', [
                'personal_info' => $personal_info,
                'land_info' => $landInfo,
                'user' => $user,
                'letter_issue' => $letter_issue,
                'issued_user' => $issued_user
            ]);
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function feedback($id)
    {
        try {
            $id = decrypt($id);

            $letter_issue = LetterIssue::where([['id', $id], ['is_issued', 1],['is_solved', 0]])->first();
            if (!empty($letter_issue)){

                //Check available letter in current user
                $application = Application::where([['id', $letter_issue->application_id], ['user_id', Auth::id()]])->first();
                if(empty($application)){
                    return redirect()->back()->with('error_msg', 'কোন পত্র পাওয়া যায়নি!');
                }

                $letter_issue->is_read = 1;
                $letter_issue->save();
                return view('applicant.letter.feedback', [
                    'application' => $application,
                    'letter_issue' => $letter_issue,
                    'personal_info' =>ApplicationPersonalInfo::where('application_id', $application->id)->first(),
                    'land_info' =>  ApplicationLandInfo::where('application_id', $application->id)->first(),
                    'user' => User::findOrFail($application->user_id),
                    'issued_user' => User::findOrFail($letter_issue->user_id),
                ]);
            }
           return redirect()->back()->with('error_msg', 'কোন উপাত্ত পাওয়া যায়নি!');

        }catch (\Exception $ex){
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function paperSubmit(Request $request, $id)
    {
        $request->validate([
            'document_type_id.*'  =>  'required',
            'file.*'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000',
        ]);

        DB::beginTransaction();
        try {
            $old_papers = FeedbackPaper::where('letter_issue_id', $id)->get();
            foreach ($old_papers as $paper){
                if (File::exists($paper->file))
                    File::delete($paper->file);
                $paper->delete();
            }

            $files = $request->file;
            $document_types_id = $request->document_type_id;

            $current_user = Auth::id();
            for ($i = 0; $i < count($document_types_id); $i++) {

                $old_doc = FeedbackPaper::where('letter_issue_id', $id)->get();
                $old_total = count($old_doc);
                $file = $files[$i];
                $folder = 'uploads/applications/problematic_paper/'. date('M-y');
                $file_name = $current_user.'_'.$id.'_'.($old_total+1).'_papers_' . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $folder . '/' . $file_name;
                $file->move($folder, $file_name);

                $feedbackPaper = new FeedbackPaper();
                $feedbackPaper->letter_issue_id = $id;
                $feedbackPaper->document_type_id = $document_types_id[$i];
                $feedbackPaper->file = $filePath;
                $feedbackPaper->save();
            }

            $letter_issue = LetterIssue::findOrFail($id);
            $letter_issue->is_paper_submit = 1;
            $letter_issue->save();

            DB::commit();
            return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)])->with('success_msg', 'কাগজসমূহ সফলভাবে সংরক্ষন করা হয়েছে!');
        }catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function promiseStore(Request $request, $id)
    {
        $request->validate([
            'promise_file'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000',
        ]);

        DB::beginTransaction();
        try {
            $letter_issue = LetterIssue::findOrFail($id);

            $letter_promise = new LetterPromise();
            if($letter_issue->promise != null){
                $letter_promise = $letter_issue->promise;
                if (File::exists($letter_promise->attachment))
                    File::delete($letter_promise->attachment);
            }else{
                $letter_promise->letter_issue_id = $letter_issue->id;
            }

            $file = $request->promise_file;
            $folder = 'uploads/applications/promise/'. date('M-y');
            $file_name = '_promise_' . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $folder . '/' . $file_name;
            $file->move($folder, $file_name);
            $letter_promise->attachment = $filePath;
            $letter_promise->save();

            DB::commit();
            return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)])->with('success_msg', 'অঙ্গিকারনামা সফলভাবে সংরক্ষন করা হয়েছে!');
        }catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }

    public function feedbackStore(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $letter_issue = LetterIssue::findOrFail($id);

            if ($letter_issue->letter_type_id == 1){
                $papers = FeedbackPaper::where('letter_issue_id', $id)->first();
                if(empty($papers))
                    return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)])->with('error_msg', 'আপনি কাগজসমূহ সংরক্ষন করেননি!');
            }

            if ($letter_issue->letter_type_id == 2){
                if($letter_issue->is_bm_fee_payment == 0){
                    return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)])->with('error_msg', 'আপনি উৎকর্ষ ফি প্রদান করেননি।');
                }
                if($letter_issue->promise == null){
                    return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)])->with('error_msg', 'আপনি অঙ্গিকারনাম সংযুক্ত করেননি!');
                }
            }

            $letterFeedback = new LetterFeedback();
            $letterFeedback->letter_issue_id = $id;
            $letterFeedback->save();

            $letter_issue->is_solved = 1;
            $letter_issue->save();

            $recieveApplication = RecievedApplication::where([['application_id', $letter_issue->application_id]])->first();
            $recieveApplication->is_wait = 0;
            $recieveApplication->save();

            DB::commit();
            return redirect()->route('applicant/letters')->with('success_msg', 'চিঠির স্বীকারোক্তি প্রেরিত হয়েছে!');
        }catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->back()->with('error_msg','Exception: '.$ex->getMessage());
        }
    }


    public function Payment(Request $request, $id)
    {

        $user = Auth::User();
        $paymentMode = env('PAYMENT_MODE');

        if($paymentMode == 'sandbox') {
            $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
        }
        else if($paymentMode == 'securepay') {
            $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
        }
        else {
            return redirect('/applicant/application-forms')->with('error_msg', 'পেমেন্ট মোড ভুল, দোয়াকরে আরডিএ অফিসের সাথে যোগাযোগ করুন।');
        }
        // payment data array --------------------------------------------------
        $post_data = array();
        $post_data['store_id'] = "basic5dd620662547d";
        $post_data['store_passwd'] = "basic5dd620662547d@ssl";

        $letter_issue = LetterIssue::findOrFail($id);

        $vatAmount = ceil(($letter_issue->betterment_fee->betterment_fee * $letter_issue->betterment_fee->vat) / 100);
        $post_data['total_amount'] = $letter_issue->betterment_fee->betterment_fee + $vatAmount;

        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "RDA_NOC_".uniqid();
        $post_data['success_url'] = route('applicant/letter/ConfirmPayment', ['id'=>$id]);
        $post_data['fail_url'] = route('applicant/letter/BackFromPayment', ['id'=>$id, 'msg' => 'ব্যর্থ']);
        $post_data['cancel_url'] = route('applicant/letter/BackFromPayment', ['id'=>$id, 'msg' => 'বাতিল']);

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_add1'] = "রাজশাহী";
        $post_data['cus_add2'] = "রাজশাহী";
        $post_data['cus_city'] = "রাজশাহী";
        $post_data['cus_state'] = "রাজশাহী";
        $post_data['cus_postcode'] = "৬২০০";
        $post_data['cus_country'] = "বাংলাদেশ";
        $post_data['cus_phone'] = $user->mobile;
        $post_data['shipping_method'] = "NO";
        $post_data['emi_option'] = 0;
        $post_data['product_name'] = "NOC Application Form";
        $post_data['product_category'] = "Online Service";
        $post_data['product_profile'] = "non-physical-goods";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url );
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1 );
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);

        $content = curl_exec($handle );
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($code == 200 && !( curl_errno($handle))) {
            curl_close( $handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close( $handle);
            return redirect('/applicant/application-forms')->with('error_msg', 'পেমেন্ট গেটওয়ের সাথে সংযোগ করতে ব্যর্থ হয়েছে৷ আপনার ইন্টারনেট চেক করুন');
        }

        $sslcz = json_decode($sslcommerzResponse, true );
        if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
            //echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
            return redirect($sslcz['GatewayPageURL']);
        } else {
            return redirect('/applicant/application-forms')->with('error_msg', 'পেমেন্ট গেটওয়ে JSON ডেটা পার্সিং ত্রুটি!' .$sslcommerzResponse);
        }

    }

    public function BackFromPayment($id, $msg)
    {
        if ($msg == 'fail')
            return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)])->with('error_msg', 'কোনোভাবে আপনার পেমেন্ট ব্যর্থ হয়েছে. অনুগ্রহপূর্বক আবার চেষ্টা করুন');
        else
            return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)]);
    }

    public function ConfirmPayment(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $this_year = date('Y');

        DB::beginTransaction();
        try{

            $betterment_fee_payment = new BettermentFeePayment();
            $betterment_fee_payment->letter_issue_id = $id;
            $betterment_fee_payment->payment_date = $request->tran_date;
            $betterment_fee_payment->payment_amount = $request->amount;
            $betterment_fee_payment->payment_method = $request->card_type;
            $betterment_fee_payment->trxn_id = $request->tran_id;
            $betterment_fee_payment->save();

            $letter_issue = LetterIssue::findOrFail($id);
            $letter_issue->is_bm_fee_payment = 1;
            $letter_issue->save();

            DB::commit();
            return redirect()->route('applicant/letters/feedback', ['id' => encrypt($id)])->with('success_msg', 'উৎকর্ষ ফি প্রদান সফলভাবে সম্পূর্ণ হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }
} // end of class
