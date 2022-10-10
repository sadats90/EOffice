<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Helpers\Message;
use App\Http\Helpers\PaperUpload;
use App\Models\Application;
use App\Models\ApplicationApplicant;
use App\Models\ApplicationDocument;
use App\Models\ApplicationDraftman;
use App\Models\ApplicationLandInfo;
use App\Models\ApplicationPaper;
use App\Models\ApplicationPersonalInfo;
use App\Models\ApplicationRoute;
use App\Models\ApplicationType;
use App\Models\Area;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CorrectionRequest;
use App\Models\District;
use App\Models\Fee;
use App\Models\LandUseFuture;
use App\Models\LandUsePresent;
use App\Models\Project;
use App\Models\RecievedApplication;
use App\Models\Upazila;
use App\Models\VatInvoice;
use App\MouzaArea;
use App\NotOwnProjectExtraInfo;
use App\NotOwnProjectInfo;
use App\OwnProjectInfo;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PHPUnit\TextUI\Help;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        try{
            $user_id = Auth::id();
            $recordsPerPage = 20;
            $query = Application::query();
            $query = $query->where('user_id', $user_id);
            $applications = $query->paginate($recordsPerPage);

            //Check Application fail or not
            $applications_check = Application::where('user_id', $user_id)->get();
            foreach ($applications_check as $application)
            {
                foreach ($application->letter_issues as $letter)
                {
                    if ($letter->is_issued == 1 && $letter->is_solved == 0){
                        $exceptIds = [1, 2];
                        if(in_array($letter->letter_type_id, $exceptIds)){
                            if ($letter->expired_date < date('Y-m-d')){
                                $application->is_failed = 1;
                                $application->save();

                                $routApp = ApplicationRoute::where([['application_id', $application->id], ['is_verified', 0]])->first();
                                $routApp->is_fail = 1;
                                $routApp->save();
                            }
                        }
                    }
                }
            }

            return view('applicant.application.index', [
                'model' => $applications,
            ])->with('i', (request()->input('page', 1) - 1) * $recordsPerPage);
        }
        catch (\Exception $ex) {
            return view('templates.exception',[
                'exception' => $ex->getMessage().'<br>'.$ex->getFile().': '.$ex->getLine()
            ]);
        }
    }

    public function form($id)
    {
        $id = decrypt($id);

        $user_id = Auth::id();
        $app = Application::where([['id', $id], ['user_id', Auth::id()]])->first();
        if(!empty($app)){
            if($app->user_id == $user_id){

                //Personal info
                $apian = '';
                $personal_info = ApplicationPersonalInfo::where('application_id',$id)->first();
                if (!empty($personal_info))
                    $apian = ApplicationApplicant::where('application_personal_info_id',$personal_info->id)->get();

                $app_documents = ApplicationDocument::where('application_id', $id)->get();
                //land Info data
                $pluts = LandUsePresent::where('status', 1)->orderBy('created_at', 'desc')->get();
                $fluts = LandUseFuture::where('status', 1)->orderBy('created_at', 'desc')->get();
                $upazilas = Upazila::orderBy('created_at', 'desc')->get();
                $land_info = ApplicationLandInfo::where('application_id', $id)->first();
                $mouzaAreas = new MouzaArea();
                if($land_info->not_own_project_info != null){
                    if(count($land_info->not_own_project_info->not_own_project_extra_infos) > 0){
                        foreach($land_info->not_own_project_info->not_own_project_extra_infos as $extraInfo){
                            $extraInfo->mouzaAreas = MouzaArea::where('upazila_id', $extraInfo->mouzaArea->upazila_id )->get();
                        }
                    }

                }
                return view('applicant.application.form',[
                    'application_id'=>$id,
                    'personal_info'=>$personal_info,
                    'app'=>$app,
                    'apian'=>$apian,
                    'pluts' => $pluts,
                    'fluts' => $fluts,
                    'upazilas' => $upazilas,
                    'land_info' => $land_info,
                    'land_info_json' => $land_info->toJson(),
                    'not_own_project_info' => $land_info->not_own_project_info != null ? $land_info->not_own_project_info->toJson() : $land_info->toJson(),
                    'mouzaAreas' => $mouzaAreas,
                    'app_documents' => $app_documents,
                    'projects' => Project::where('project_type', 2)->get()
                ]);

            }
        }
        return view('user.404');

    }

    public function personalInfo(Request $request, $app_id){
        $request->validate([
            'applicant_name.*' =>  'required',
            'father_name.*' =>  'required',
            'nid.*'        =>  'required',
            'nid_file.*'    =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:4500',
            'ta_house_no'     =>  'required',
            'ta_post_code'             =>  'required',
            'ta_area'             =>  'required',
            'ta_post'             =>  'required',
            'ta_thana'             =>  'required',
            'ta_district'             =>  'required',
            'pa_house_no'             =>  'required',
            'pa_post_code'             =>  'required',
            'pa_area'             =>  'required',
            'pa_post'             =>  'required',
            'pa_thana'             =>  'required',
            'pa_district'             =>  'required',
        ],[
            'ta_house_no.required' => 'হাউস/হোল্ডিং নম্বরটি আবশ্যক',
            'ta_post_code.required' => 'ডাকঘর কোড প্রয়োজন',
            'ta_area.required' => 'গ্রাম/ওয়ার্ড/এলাকা আবশ্যক',
            'ta_post.required' => 'ডাকঘর আবশ্যক',
            'ta_thana.required' => 'থানা/উপজেলা আবশ্যক',
            'ta_district.required' => 'জেলা আবশ্যক',

            'pa_house_no.required' => 'হাউস/হোল্ডিং নম্বরটি আবশ্যক',
            'pa_post_code.required' => 'ডাকঘর কোড প্রয়োজন',
            'pa_area.required' => 'গ্রাম/ওয়ার্ড/এলাকা আবশ্যক',
            'pa_post.required' => 'ডাকঘর আবশ্যক',
            'pa_thana.required' => 'থানা/উপজেলা আবশ্যক',
            'pa_district.required' => 'জেলা আবশ্যক',
        ]);

        DB::beginTransaction();
        try{
            $app_id = decrypt($app_id);

            $old_api = ApplicationPersonalInfo::where('application_id',$app_id)->first();
            if(!empty($old_api)){
                $applicants = $old_api->applicants;
                foreach ($applicants as $applicant){
                    if (File::exists($applicant->nid_path))
                        File::delete($applicant->nid_path);
                }

                $old_api->delete();
            }

            $api = new ApplicationPersonalInfo();
            $api->application_id = $app_id;

            $api->ta_house_no = $request->ta_house_no;
            $api->ta_post_code = $request->ta_post_code;
            $api->ta_road_no = $request->ta_road_no;
            $api->ta_sector_no = $request->ta_sector_no;
            $api->ta_area = $request->ta_area;
            $api->ta_post = $request->ta_post;
            $api->ta_thana = $request->ta_thana;
            $api->ta_district = $request->ta_district;

            $api->pa_house_no = $request->pa_house_no;
            $api->pa_post_code = $request->pa_post_code;
            $api->pa_road_no = $request->pa_road_no;
            $api->pa_sector_no = $request->pa_sector_no;
            $api->pa_area = $request->pa_area;
            $api->pa_post = $request->pa_post;
            $api->pa_thana = $request->pa_thana;
            $api->pa_district = $request->pa_district;

            $api->mobile = Auth::user()->mobile;
            $api->save();
            $applicant_name = $request->applicant_name;
            $father_name = $request->father_name;
            $nid = $request->nid;
            $nid_files = $request->nid_file;

            if(!empty($applicant_name)){
                for ($i = 0; $i < count($applicant_name); $i++) {
                    if($applicant_name[$i] != '') {
                        $apian = new ApplicationApplicant();

                        if($nid_files[$i] != null){
                            $file= $nid_files[$i];
                            $folder = 'noc/uploads/applications/nid/' . date('M-y');
                            $file_name =  $i . '_' . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                            $filePath = $folder . '/' . $file_name;
                            $file->move($folder, $file_name);

                            $apian->nid_path = $filePath;
                        }
                        $apian->applicant_name = $applicant_name[$i];
                        $apian->father_name = $father_name[$i];
                        $apian->nid_number = $nid[$i];
                        $apian->application_personal_info_id = $api->id;
                        $apian->save();
                    }
                }
            }
            $app = Application::find($app_id);
            $app->is_personal_info = 1;
            $app->save();
            DB::commit();
            return redirect()->route('applicant/applications/Form',['id'=>encrypt($app_id)])->with('success_msg', 'আপানার ব্যক্তিগত তথ্য সংরক্ষন করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function landInfo(Request $request, $app_id)
    {
        $request->validate([
            'is_own_project'  =>  'required',
            'land_currently_use'  =>  'required',
            'land_amount'  =>  'required'
        ]);

        if($request->is_own_project === 'হ্যাঁ'){
            $request->validate([
                'project_id'  =>  'required',
                'plot_no'  =>  'required',
            ]);
        }else{
            $request->validate([
                'upazila_id.*'  =>  'required',
                'mouza_area_id.*'  =>  'required',
                'rs_line_no.*'  =>  'required',
                'is_acquisition'  =>  'required',
            ]);

            if($request->is_acquisition === 'হ্যাঁ'){
                $request->validate([
                    'acquisition_land_amount'  =>  'required',
                    'acquisition_document'  =>  'required'
                ]);
            }
        }
        DB::beginTransaction();
        try{
            $app_id = decrypt($app_id);

            $landAmount = $request->land_amount;
            if (!Helper::IsEnglish($landAmount))
                $landAmount = Helper::ConvertToEnglish($landAmount);

            if (!is_numeric($landAmount))
                return back()->with('error_msg', 'জমির পরিমাণ অবশ্যই সংখ্যাই হবে!');

            $applicationLandInfo = ApplicationLandInfo::where('application_id',$app_id)->first();

            $applicationLandInfo->is_own_project = $request->is_own_project;
            $applicationLandInfo->land_amount =$landAmount;
            $applicationLandInfo->land_currently_use =$request->land_currently_use;
            $applicationLandInfo->save();

            //Reverse Operation
            $ownProjectInfo = OwnProjectInfo::where('application_land_info_id', $applicationLandInfo->id)->first();
            if(!empty($ownProjectInfo))
                $ownProjectInfo->delete();

            $notOwnProjectInfo = NotOwnProjectInfo::where('application_land_info_id', $applicationLandInfo->id)->first();
            if(!empty($notOwnProjectInfo))
            {
                if (File::exists($notOwnProjectInfo->document_path))
                    File::delete($notOwnProjectInfo->document_path);

                $notOwnProjectInfo->delete();
            }

            if($request->is_own_project === 'হ্যাঁ'){
                $ownProjectInfo = new OwnProjectInfo();
                $ownProjectInfo->application_land_info_id = $applicationLandInfo->id;
                $ownProjectInfo->project_id  = $request->project_id;
                $ownProjectInfo->plot_no  = $request->plot_no;
                $ownProjectInfo->save();
            }else{
                $notOwnProjectInfo = new NotOwnProjectInfo();
                $notOwnProjectInfo->application_land_info_id = $applicationLandInfo->id;
                $notOwnProjectInfo->is_acquisition = $request->is_acquisition;

                if($request->is_acquisition === 'হ্যাঁ'){

                    $file= $request->acquisition_document;
                    $folder = 'noc/uploads/applications/acquisition_document/' . date('M-y');
                    $file_name =  $app_id . '_' . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $folder . '/' . $file_name;
                    $file->move($folder, $file_name);

                    $notOwnProjectInfo->document_path = $filePath;
                    $notOwnProjectInfo->acquisition_amount = Helper::ConvertToEnglish($request->acquisition_land_amount);
                }

                $notOwnProjectInfo->save();

                $mouza_areas_id = $request->mouza_area_id;
                $rs_line_numbers = $request->rs_line_no;
                for ($i = 0; $i < count($mouza_areas_id); $i++) {
                    if($rs_line_numbers[$i] != '') {
                        $notOwnProjectExtraInfo = new NotOwnProjectExtraInfo();
                        $notOwnProjectExtraInfo->not_own_project_info_id = $notOwnProjectInfo->id;
                        $notOwnProjectExtraInfo->mouza_area_id = $mouza_areas_id[$i];
                        $notOwnProjectExtraInfo->rs_line_no = $rs_line_numbers[$i];
                        $notOwnProjectExtraInfo->save();
                    }
                }

            }
            $app = Application::find($app_id);
            $app->is_land_info = 1;
            $app->save();

            DB::commit();
            return redirect()->route('applicant/applications/Form',['id'=>encrypt($app_id)])->with('success_msg', 'আপনার জমির তথ্য সংরক্ষন করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function documentInfo(Request $request, $app_id)
    {
        $request->validate([
            'land_document.*'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:4500',
            'rs_khatiyan.*'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000',
            'treasury_receipt.*'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000',
            'dismissal_receipt.*'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000',
            'mouza_map.*'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000',
            'location_map.*'  =>  'required|mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000',
            'Commitments.*'  =>  'mimes:jpg,jpeg,png,gif,wmf,pdf|max:1500',
            'positional_certificate.*'  =>  'mimes:jpg,jpeg,png,gif,wmf,pdf|max:1500',
            'others.*'  =>  'mimes:jpg,jpeg,png,gif,wmf,pdf|max:1500',
        ]);

        DB::beginTransaction();
        try{
            $app_id = decrypt($app_id);
            $documents = ApplicationDocument::where('application_id', $app_id)->get();
            foreach ($documents as $document){
                if (File::exists($document->file))
                    File::delete($document->file);
                $document->delete();
            }

            $land_documents = $request->land_document;
            $rs_khatiyans = $request->rs_khatiyan;
            $treasury_receipts = $request->treasury_receipt;
            $dismissal_receipts = $request->dismissal_receipt;
            $mouza_maps = $request->mouza_map;
            $location_maps = $request->location_map;
            $Commitments = $request->Commitments;
            $positional_certificate = $request->positional_certificate;
            $others = $request->others;

            $user_id = Auth::id();
            $counter = 1;
            //land_document file upload & insert
            foreach ($land_documents as $land_document){

                list($filePath, $old_total) = $this->FileUpload($app_id, $land_document, $user_id, $counter, 1, '_land_document_');

                $this->AddApplicationDocument($app_id, $filePath, $old_total, 1);

                $counter++;
            }

            //$rs_khatiyan file upload & insert
            foreach ($rs_khatiyans as $rs_khatiyan){

                list($filePath, $old_total) = $this->FileUpload($app_id, $rs_khatiyan, $user_id, $counter, 2, '_rs_khatiyan_');

                $this->AddApplicationDocument($app_id, $filePath, $old_total, 2);
                $counter++;
            }

            //treasury_receipt file upload & insert
            foreach ($treasury_receipts as $treasury_receipt){

                list($filePath, $old_total) = $this->FileUpload($app_id, $treasury_receipt, $user_id, $counter, 3, '_treasury_receipt_');

                $this->AddApplicationDocument($app_id, $filePath, $old_total, 3);
                $counter++;
            }
            //_dismissal_receipt_ file upload & insert
            foreach ($dismissal_receipts as $dismissal_receipt){

                list($filePath, $old_total) = $this->FileUpload($app_id, $dismissal_receipt, $user_id, $counter, 4, '_dismissal_receipt_');

                $this->AddApplicationDocument($app_id, $filePath, $old_total, 4);
                $counter++;
            }
            //mouza_map file upload & insert
            foreach ($mouza_maps as $mouza_map){

                list($filePath, $old_total) = $this->FileUpload($app_id, $mouza_map, $user_id, $counter, 5, '_mouza_map_');

                $this->AddApplicationDocument($app_id, $filePath, $old_total, 5);
                $counter++;
            }
            //land_document file upload & insert
            foreach ($location_maps as $location_map){

                list($filePath, $old_total) = $this->FileUpload($app_id, $location_map, $user_id, $counter, 6, '_location_map_');

                $this->AddApplicationDocument($app_id, $filePath, $old_total, 6);
                $counter++;
            }

            //Commitments file upload & insert
            if (!empty($Commitments)){
                foreach ($Commitments as $Commitment){

                    list($filePath, $old_total) = $this->FileUpload($app_id, $Commitment, $user_id, $counter, 7, '_commitment_');

                    $this->AddApplicationDocument($app_id, $filePath, $old_total, 7);
                    $counter++;
                }
            }

            //positional_certificate file upload & insert
            if (!empty($positional_certificate)){
                foreach ($positional_certificate as $certificate){

                    list($filePath, $old_total) = $this->FileUpload($app_id, $certificate, $user_id, $counter, 8, '_positional_certificate_');

                    $this->AddApplicationDocument($app_id, $filePath, $old_total, 8);
                    $counter++;
                }
            }

            //others file upload & insert
            if (!empty($others)){
                foreach ($others as $other){

                    list($filePath, $old_total) = $this->FileUpload($app_id, $other, $user_id, $counter, 9, '_other_');

                    $this->AddApplicationDocument($app_id, $filePath, $old_total, 9);
                    $counter++;
                }
            }

            $app = Application::find($app_id);
            $app->is_document_info = 1;
            $app->save();
            DB::commit();
            return redirect()->route('applicant/applications/Form',['id'=>encrypt($app_id)])->with('success_msg', 'আপনার জমির তথ্য সংরক্ষন করা সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function documentView($id)
    {
        $app_doc_file = ApplicationDocument::where('id', $id)->first();
        return view('applicant.application.documentView', [
            'app_doc_file' => $app_doc_file,
        ]);

    }

    public function submit(Request $request, $app_id)
    {
        DB::beginTransaction();
        try {
            $app_id = decrypt($app_id);

            $old_app = Application::where([['year', date('Y')], ['is_submit', 1]])->get();

            $total_app = count($old_app);

            $app = Application::where([['id', $app_id], ['is_personal_info', 1], ['is_land_info', 1], ['is_document_info', 1]])->first();
            if(is_null($app)){
                return back()->withError('Data not found!');
            }
            $app->app_id = date('Y').'.P.'.($total_app + 1);
            $app->is_submit = 1;
            $app->submission_date = Carbon::now();
            $app->is_new = 1;

            $app->save();

            $user = Auth::user();

            /*  Sent Mobile verification SMS  */
            $response = Message::SendSMS($user->mobile, 'আপনার আবেদন জমা হয়েছে, আবেদন আইডি নং '. $app->app_id);

            if($response['status'] == 'fail') {
                DB::rollBack();
                return redirect()->route('applicant/applications/Index')->with('error_msg','Exception : ' . $response['message']);
            }

            DB::commit();
            return redirect()->route('applicant/applications/Index')->with('success_msg', 'আবেদন জমা দেওয়া সফল হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function viewDetails($id)
    {
        $id = decrypt($id);
        $user_id = Auth::user()->id;
        $application = Application::where([['id', $id], ['user_id', $user_id]])->first();
        if (!empty($application)) {
            if(!empty($application->landInfo)){
                $application->landInfo->plut_name = LandUsePresent::findOrFail($application->landInfo->land_currently_use)->plut_name;
                $application->landInfo->flut_name = LandUseFuture::findOrFail($application->landInfo->land_future_use)->flut_name;
            }
            return view('applicant.application.viewDetails',['application'=>$application]);
        }
        return redirect()->back()->with('error_msg', '৪০৪ পাওয়া যায়নি');
    }

    public function correctionRequest($id){
        $id = decrypt($id);
        $user_id = Auth::user()->id;
        $application = Application::where([['id', $id], ['user_id', $user_id], ['is_complete', 1]])->first();
        if (!empty($application)) {
            return view('applicant.application.correctionRequest',['application'=>$application]);
        }
        return redirect()->back()->with('error_msg', '৪০৪ পাওয়া যায়নি');
    }

    public function correctionRequestStore($id, Request $request): RedirectResponse
    {
        $request->validate([
            'subject'  =>  'required',
            'description'  =>  'required',
            'attachment'  =>  'mimes:jpg,jpeg,png,gif,wmf,pdf|max:2000'
        ]);

        $id = decrypt($id);
        $user_id = Auth::user()->id;
        $application = Application::where([['id', $id], ['user_id', $user_id], ['is_complete', 1]])->first();
        if (!empty($application)) {
            $correctionRequest = $application->correction_request;

            $filePath = null;
            if($request->attachment != null){
                $file= $request->attachment;
                $folder = 'noc/uploads/applications/correction_req/' . date('M-y');
                $file_name =  $application->app_id . '_' . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $folder . '/' . $file_name;
                $file->move($folder, $file_name);
            }

            if(empty($correctionRequest)){
                $correctionRequest = new CorrectionRequest();
                $correctionRequest->application_id = $application->id;
            }else{
                if($filePath != null){
                    if (File::exists($correctionRequest->attachment))
                        File::delete($correctionRequest->attachment);
                }else{
                    $filePath = $correctionRequest->attachment;
                }
            }

            $correctionRequest->subject = $request->subject;
            $correctionRequest->description = $request->description;
            $correctionRequest->attachment = $filePath;

            if(empty($application->correction_request)){
                $correctionRequest->save();
            }else{
                $correctionRequest->update();
            }

            return redirect()->back()->with('success_msg', 'সংশোধিত তথ্যাদি সফলভাবে সংরক্ষন করা হয়েছে।');
        }
        return redirect()->back()->with('error_msg', '৪০৪ পাওয়া যায়নি');

    }

    public function correctionRequestPreview($id){
        $id = decrypt($id);
        $correctionRequest = CorrectionRequest::where([['id', $id]])->first();
        if (!empty($correctionRequest)) {

            return view('applicant.application.correctionRequestPreview',['correctionRequest'=>$correctionRequest]);
        }
        return redirect()->back()->with('error_msg', '৪০৪ পাওয়া যায়নি');
    }

    public function correctionRequestSent($id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $id = decrypt($id);
            $correctionRequest = CorrectionRequest::where([['id', $id], ['submitted_at', null]])->first();
            if (!empty($correctionRequest)) {

                $correctionRequest->submitted_at = new \DateTime('now');
                $correctionRequest->update();

                $application = $correctionRequest->application;
                $application->correction_request_status = 1;
                $application->update();

                DB::commit();
                return redirect()->back()->with('success_msg', 'তথ্যাদি সংশোধনের অনুরোধ সফলভাবে সম্পূর্ণ হয়েছে!');
            }
            return redirect()->back()->with('error_msg', '৪০৪ পাওয়া যায়নি');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    public function Buy()
    {
        $fluts = LandUseFuture::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('applicant.application.buy-application', [
            'fluts' => $fluts,
            'fee' => Fee::first()
        ]);
    }

    public function Payment(Request $request)
    {
        $request->validate([
            'term'  =>  'required',
            'app_type'  =>  'required',
            'land_future_use'  =>  'required',
            'total_fee'  =>  'required'
        ]);

        $user = Auth::User();
        $paymentMode = env('PAYMENT_MODE');

        if($paymentMode == 'sandbox') {
            $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
        }
        else if($paymentMode == 'securepay') {
            $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
        }
        else {
            return redirect('/applicant/application-forms')->with('error_msg', 'অবৈধ পেমেন্ট মোড, দয়াকরে আরডিএ অফিসের সাথে যোগাযোগ করুন।');
        }

        $flut = LandUseFuture::findOrFail($request->land_future_use);
        $fee = Fee::first();
//            $total = $flut->cost + $fee->application_fee + ($request->app_type == 'Emergency' ? $fee->emergency_fee : 0);

        // payment data array --------------------------------------------------
        $post_data = array();
        $post_data['total_amount'] = $request->grand_total;
        $post_data['store_id'] = "basic5dd620662547d";
        $post_data['store_passwd'] = "basic5dd620662547d@ssl";
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "rda-noc-".uniqid();
        $post_data['success_url'] = route('applicant/application/ConfirmPayment', ['app_type'=>$request->app_type,'flu'=>$request->land_future_use]);
        $post_data['fail_url'] = route('applicant/application/BackFromPayment');
        $post_data['cancel_url'] = route('applicant/application/BackFromPayment');

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_add1'] = "Rajshahi";
        $post_data['cus_add2'] = "Rajshahi";
        $post_data['cus_city'] = "Rajshahi";
        $post_data['cus_state'] = "Rajshahi";
        $post_data['cus_postcode'] = "6200";
        $post_data['cus_country'] = "Bangladesh";
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
            return redirect('/applicant/application-forms')->with('error_msg', 'পেমেন্ট গেটওয়ে JSON ডেটা পার্সিং ত্রুটি হয়েছে!' .$sslcommerzResponse);
        }

    }

    public function BackFromPayment()
    {
        return redirect()->route('applicant/applications/Index');
    }

    public function ConfirmPayment(Request $request, $appType, $landUsageFuture)
    {
        $user_id = Auth::user()->id;
        $this_year = date('Y');

        DB::beginTransaction();
        try{
            $application = new Application();
            $application->user_id = $user_id;
            $application->app_id = $this_year.'.P.';
            $application->application_for = 'NOC';
            $application->app_type = $appType;
            $application->form_buy_date = $request->tran_date;
            $application->form_buy_price = $request->amount;
            $application->vat = Fee::first()->vat;
            $application->payment_method = $request->card_type;
            $application->trxn_id = $request->tran_id;
            $application->year = $this_year;
            $application->save();

            $ali = new ApplicationLandInfo();
            $ali->application_id = $application->id;
            $ali->land_future_use = $landUsageFuture;
            $ali->save();

            DB::commit();
            return redirect()->route('applicant/applications/Index')->with('success_msg', 'আবেদন ফরম সফলভাবে ক্রয় করা হয়েছে!');
        }catch (\Exception $ex){
            DB::rollBack();
            return back()->withError($ex->getMessage());
        }
    }

    /**
    Get Price in ajax call method
     */
    public function getServiceCharge(Request $request)
    {
        $flut = LandUseFuture::findOrFail($request->id);

        return $flut->cost;

    }
    /**
    Get Branch in ajax call method
     */
    public function getBranches(Request $request)
    {
        $district_id = $request->district_id;
        $bank_id= $request->bank_id;
        $barnches = Branch::where([['district_id', $district_id], ['bank_id', $bank_id]])->get();
        return $barnches;

    }

    /**
     * @param $app_id
     * @param $land_document
     * @param int|null $user_id
     * @param int $counter
     * @return array
     */
    protected function FileUpload($app_id, $land_document, ?int $user_id, int $counter, int $type_id, string $name):array
    {
        $old_doc = ApplicationDocument::where('application_id', $app_id)->where('document_type_id', $type_id)->get();
        $old_total = count($old_doc);
        $file = $land_document;
        $folder = 'noc/uploads/applications/documents/' . date('M-y');
        $file_name =  $app_id . '_' . $counter . '_' . ($old_total + 1) .$name . date('Y-m-d') . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $folder . '/' . $file_name;
        $file->move($folder, $file_name);
        return array($filePath, $old_total);
    }

    /**
     * @param $app_id
     * @param $filePath
     * @param $old_total
     */
    protected function AddApplicationDocument($app_id, $filePath, $old_total, $type_id)
    {
        $applicationDocument = new ApplicationDocument();
        $applicationDocument->application_id = $app_id;
        $applicationDocument->document_type_id = $type_id;
        $applicationDocument->file = $filePath;
        $applicationDocument->version = ($old_total + 1);
        $applicationDocument->save();
    }

}
