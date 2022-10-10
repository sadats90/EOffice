@extends('applicant.layouts.master')
@section('title', 'আবেদন পূরণ')
@section('content')
    <p>আবেদন পূরণ করুণ</p>
    <hr>
    @include('includes.message')

    <!-- Top Statistics -->

    <div class="card card-default mb-2">
        <div class="card-body pt-0 mr-1 pl-3 pb-0">
            <div class="alert alert-warning text-center mt-1" id="warning-alert">
                <span style="font-size:20px;">--- উক্ত আবেদন ফরমের সকল তথ্য আবশ্যিকভাবে বাংলায় পূরণ করতেই হবে ---</span>
            </div>
            <ul class="nav nav-tabs  mt-1" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">ব্যক্তির তথ্য</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="land-tab" data-toggle="tab" href="#land" role="tab" aria-controls="land" aria-selected="false">জমির তথ্য</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="document-tab" data-toggle="tab" href="#document" role="tab" aria-controls="document" aria-selected="false">ডকুমেন্ট সমূহ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="submission-tab" data-toggle="tab" href="#submission" role="tab" aria-controls="submission" aria-selected="false">ফরম জমা দানের অবস্থা</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">

                <!--personal tab content here -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="home-tab">

                    <form @if($app->is_submit == 0) action="{{ route('applicant/applications/Store/PersonalInfo',['app_id'=> encrypt($application_id)]) }}" method="POST" @endif class="mt-3" autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" value="{{ $apian }}" id="data">

                        <div class="form-group row" style="padding-right: 14px;">
                            <label class="col-sm-12 col-form-label bg-light-gray text-left" style="color: #003399;">যদি একাধিক আবেদনকারী হয় তাহলে যোগ করুণ</label>
                        </div>
                        <div id="sheepItForm">
                            <div class="form-group row mb-0">
                                <div class="col-sm-3">
                                    <label for="sheepItForm_#index#_applicant_name">আবেদনকারীর নামঃ  </label>
                                </div>
                                <div class="col-sm-3">
                                    <label for="sheepItForm_#index#_father_name">পিতার নামঃ </label>
                                </div>
                                <div class="col-sm-3">
                                    <label for="sheepItForm_#index#_nid">এনআইডি নং</label>
                                </div>
                                <div class="col-sm-2">
                                    <label for="sheepItForm_#index#_nid">এনআইডি</label>
                                </div>
                                <div class="col-sm-1">

                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <input type="text" name="applicant_name[]" class="form-control" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}" required id="_applicant_name"  readonly>
                                    <span class="text-danger">{{ $errors->has('applicant_name.0') ? $errors->first('applicant_name.0') : '' }}</span>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="father_name[]" class="form-control" required id="father_name" @if(!empty($personal_info)) value="{{ $apian[0]->father_name }}" @endif @if($app->is_submit == 1) readonly @endif>
                                    {{--<small class="form-text text-muted">If your applicant is more you can add more</small>--}}
                                    <span class="text-danger">{{ $errors->has('father_name.0') ? $errors->first('father_name.0') : '' }}</span>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="nid[]" class="form-control" id="_nid" required @if(!empty($personal_info)) value="{{ $apian[0]->nid_number }}" @endif @if($app->is_submit == 1) readonly @endif>
                                    <span class="text-danger">{{ $errors->has('nid.0') ? $errors->first('nid.0') : '' }}</span>
                                </div>
                                <div class="col-sm-2">
                                    <input type="file" name="nid_file[]" class="form-control" id="_nid_file" required @if($app->is_submit == 1) readonly @endif>
                                    <span class="text-danger">{{ $errors->has('nid_file.0') ? $errors->first('nid_file.0') : '' }}</span>
                                </div>
                                <div class="col-sm-1">

                                </div>

                            </div>
                            <div class="form-group row" id="sheepItForm_template">
                                <div class="col-sm-3">
                                    <input type="text" name="applicant_name[]" class="form-control" required id="sheepItForm_#index#_applicant_name"  @if($app->is_submit == 1) readonly @endif>
                                    <span class="text-danger">{{ $errors->has('applicant_name.0') ? $errors->first('applicant_name.0') : '' }}</span>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="father_name[]" class="form-control" required id="sheepItForm_#index#_father_name" @if($app->is_submit == 1) readonly @endif>
                                    {{--<small class="form-text text-muted">If your applicant is more you can add more</small>--}}
                                    <span class="text-danger">{{ $errors->has('father_name.0') ? $errors->first('father_name.0') : '' }}</span>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="nid[]" class="form-control" id="sheepItForm_#index#_nid" required @if($app->is_submit == 1) readonly @endif>
                                    <span class="text-danger">{{ $errors->has('nid.0') ? $errors->first('nid.0') : '' }}</span>
                                </div>
                                <div class="col-sm-2">
                                    <input type="file" name="nid_file[]" class="form-control" id="sheepItForm_#index#_nid_file" required @if($app->is_submit == 1) readonly @endif>
                                    <span class="text-danger">{{ $errors->has('nid_file.0') ? $errors->first('nid_file.0') : '' }}</span>
                                </div>
                                <div class="col-sm-1">
                                    <a id="sheepItForm_remove_current" name="sheepItForm_remove_current">
                                        <img class="delete" src="{{ asset('assets/plugins/sheepit-master/images/cross.png') }}" width="16" height="16" border="0" style="margin-top: 10px;" />
                                    </a>
                                </div>

                            </div>

                            <!-- No forms template -->
                            <div id="sheepItForm_noforms_template">
                                কোন তথ্য নেই
                            </div><!-- /No forms template-->
                        </div>
                        <div class="row" id="sheepItForm_controls" style="margin-top: -10px; margin-bottom: 20px; margin-right: 64px">
                            <div class="col-lg-12 text-right">
                                <a id="sheepItForm_remove_all" class="btn btn-danger text-white"><span>সব মুছে ফেলুন</span></a>
                                <a id="sheepItForm_remove_last" class="btn btn-light btn-sm text-danger"><span> মুছে ফেলুন</span></a>
                                <a id="sheepItForm_add" class="btn btn-light btn-sm text-primary" style="margin-right: 13px;"><span>যোগ করুন</span></a>
                            </div>
                        </div><!-- /Controls -->


                        {{-- Present address --}}
                        <div class="form-group row" style="padding-right: 14px;">
                            <label class="col-sm-12 col-form-label bg-light-gray text-left" style="color: #003399;">বর্তমান ঠিকানাঃ</label>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="ta_house_no" class="col-form-label text-right">বাসা/হোল্ডিং নং <span class="text-danger">*</span></label>
                                <input name="ta_house_no" value="@if(!empty($personal_info)) {{ $personal_info->ta_house_no }} @endif" type="text" class="form-control" id="ta_house_no" @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_house_no') ? $errors->first('ta_house_no') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="ta_road_no" class="col-form-label text-right">রাস্তার নাম/নং</label>
                                <input name="ta_road_no" value="@if(!empty($personal_info)) {{ $personal_info->ta_road_no }} @endif" type="text" class="form-control" id="ta_road_no"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_road_no') ? $errors->first('ta_road_no') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="ta_sector_no" class="col-form-label text-right">সেক্টর নং</label>
                                <input name="ta_sector_no" value="@if(!empty($personal_info)) {{ $personal_info->ta_sector_no }} @endif" type="text" class="form-control" id="ta_sector_no" @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_sector_no') ? $errors->first('ta_sector_no') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="ta_area" class="col-form-label text-right">গ্রাম/ওয়ার্ড/এলাকাঃ<span class="text-danger">*</span></label>
                                <input name="ta_area" value="@if(!empty($personal_info)) {{ $personal_info->ta_area }} @endif" type="text" class="form-control" id="ta_area"@if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_area') ? $errors->first('ta_area') : '' }}</span>
                            </div>

                            <div class="col-md-3">
                                <label for="ta_post" class="col-form-label text-right">পোস্টঃ<span class="text-danger">*</span></label>
                                <input name="ta_post" value="@if(!empty($personal_info)) {{ $personal_info->ta_post }} @endif" type="text" class="form-control" id="ta_post"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_post') ? $errors->first('ta_post') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="ta_post_code" class="col-form-label text-right">পোস্ট কোডঃ <span class="text-danger">*</span></label>
                                <input name="ta_post_code" value="@if(!empty($personal_info)) {{ $personal_info->ta_post_code }} @endif" type="text" class="form-control" id="ta_post_code"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_post_code') ? $errors->first('ta_post_code') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="ta_thana" class="col-form-label text-right">থানা/উপজেলাঃ <span class="text-danger">*</span></label>
                                <input name="ta_thana" value="@if(!empty($personal_info)) {{ $personal_info->ta_thana }} @endif" type="text" class="form-control" id="ta_thana"@if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_thana') ? $errors->first('ta_thana') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="ta_district" class="col-form-label text-right">জেলাঃ <span class="text-danger">*</span></label>
                                <input name="ta_district" value="@if(!empty($personal_info)) {{ $personal_info->ta_district }} @endif" type="text" class="form-control" id="ta_district"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('ta_district') ? $errors->first('ta_district') : '' }}</span>
                            </div>
                        </div>


                        {{-- Permanent Address --}}
                        <div class="form-group mt-4 row" style="padding-right: 14px;">
                            <label class="col-sm-12 col-form-label bg-light-gray text-left" style="color: #003399;">
                                আবেদনকারীর স্থায়ী ঠিকানা
                                <div class="form-check mt-1">
                                    <input type="checkbox" class="form-check-input" id="pa-same-as-ta">
                                    <label class="form-check-label" for="pa-same-as-ta">অনুগ্রহ করে টিক দিন যদি স্থায়ী ও বর্তমান ঠিকানা একই হয়</label>
                                </div>
                            </label>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="pa_house_no" class="col-form-label text-right">বাসা/হোল্ডিং নং <span class="text-danger">*</span></label>
                                <input name="pa_house_no" value="@if(!empty($personal_info)) {{ $personal_info->pa_house_no }} @endif" type="text" class="form-control" id="pa_house_no" @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_house_no') ? $errors->first('pa_house_no') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="pa_road_no" class="col-form-label text-right">রাস্তার নাম/নং</label>
                                <input name="pa_road_no" value="@if(!empty($personal_info)) {{ $personal_info->pa_road_no }} @endif" type="text" class="form-control" id="pa_road_no"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_road_no') ? $errors->first('pa_road_no') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="pa_sector_no" class="col-form-label text-right">সেক্টর নং</label>
                                <input name="pa_sector_no" value="@if(!empty($personal_info)) {{ $personal_info->pa_sector_no }} @endif" type="text" class="form-control" id="pa_sector_no"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_sector_no') ? $errors->first('pa_sector_no') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="pa_area" class="col-form-label text-right">গ্রাম/ওয়ার্ড/এলাকাঃ <span class="text-danger">*</span></label>
                                <input name="pa_area" value="@if(!empty($personal_info)) {{ $personal_info->pa_area }} @endif" type="text" class="form-control" id="pa_area"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_area') ? $errors->first('pa_area') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="pa_post" class="col-form-label text-right">পোস্টঃ <span class="text-danger">*</span></label>
                                <input name="pa_post" value="@if(!empty($personal_info)) {{ $personal_info->pa_post }} @endif" type="text" class="form-control" id="pa_post"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_post') ? $errors->first('pa_post') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="pa_post_code" class="col-form-label text-right">পোস্ট কোডঃ <span class="text-danger">*</span></label>
                                <input name="pa_post_code" value="@if(!empty($personal_info)) {{ $personal_info->pa_post_code }} @endif" type="text" class="form-control" id="pa_post_code"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_post_code') ? $errors->first('pa_post_code') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="pa_thana" class="col-form-label text-right">থানা/উপজেলাঃ <span class="text-danger">*</span></label>
                                <input name="pa_thana" value="@if(!empty($personal_info)) {{ $personal_info->pa_thana }} @endif" type="text" class="form-control" id="pa_thana"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_thana') ? $errors->first('pa_thana') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="pa_district" class="col-form-label text-right">জেলাঃ<span class="text-danger">*</span></label>
                                <input name="pa_district" value="@if(!empty($personal_info)) {{ $personal_info->pa_district }} @endif" type="text" class="form-control" id="pa_district"  @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('pa_district') ? $errors->first('pa_district') : '' }}</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-sm-12 text-right mt-3">
                                @if($app->is_submit == 0)
                                    <button type="submit" class="btn btn-secondary" style="background-color: #8C489F"><i class="mdi mdi-cloud"></i> সংরক্ষন করুন</button>
                                @endif
                                @if($app->is_submit == 1)
                                    <button class="btn btn-success" disabled="disabled">ব্যক্তিগত তথ্য সংরক্ষন করা আছে</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!--Land info content here-->
                <div class="tab-pane fade" id="land" role="tabpanel" aria-labelledby="land-tab">
                    @include('applicant.inc._landInfoForm')
                </div>

                <!--Document info content here-->
                <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                    <form @if($app->is_submit == 0) action="{{ route('applicant/applications/Store/documentInfo', ['app_id'=>encrypt($application_id)]) }}" method="POST" @endif enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td style="width: 50%" class="text-primary">
                                    <label style="text-align:justify;" for="Land_document">
                                        জমির দলিল <span class="text-danger">*</span><br>
                                        <small class="text-muted;">আবেদনপত্রের সাথে আবেদনকৃত <span style="color:red;">জমির দলিলের মূল কপি/ সার্টিফাইড কপির স্ক্যান কপি</span> (<span style="color:red;">ফটোকপি হতে স্ক্যান কপি গ্রহণযোগ্য নহে</span>)। আবেদিত জমি সরকার কর্তৃক গৃহীত উন্নয়ন পরিকল্পনা থাকলে আবেদিত <span style="color:red;">জমির দলিল, খতিয়ান, খাজনার রশিদ অথবা ভূমি অধিগ্রহণের প্রশাসনিক অনুমোদন এর স্ক্যান কপি</span> দাখিল করতে হবে।
                                        </small>
                                    </label>
                                </td>
                                <td id="land_documents">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="land_document[]" id="Land_document" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="add_land_document" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 1)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 1) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary">
                                    <label for="rs_khatiyan">
                                        প্রস্তাবিত আর এস খতিয়ান <span class="text-danger">*</span><br>
                                        <small class="text-muted">আবেদনকৃত জমির <span style="color:red;">খারিজ খতিয়ান (মূল কপি/ সার্টিফাইড কপির স্ক্যান কপি</span> সংযোজন করতে হবে। কোনরূপ <span style="color:red;">ফটোকপি হতে স্ক্যান কপি</span> গ্রহণযোগ্য নহে)</small>
                                    </label>
                                </td>
                                <td id="khatiyan">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="rs_khatiyan[]" id="rs_khatiyan" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="rs" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 2)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 2) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary" >
                                    <label for="treasury_receipt">
                                        খাজনার রশিদ <span class="text-danger">*</span><br>
                                        <small class="text-muted">আবেদনকৃত <span style="color:red;">জমির খাজনার রশিদ (মূল কপির স্ক্যান কপি</span> সংযোজন করতে হবে। কোনরূপ <span style="color:red;">ফটোকপি হতে স্ক্যান কপি</span> গ্রহণযোগ্য নহে)</small>
                                    </label>
                                </td>
                                <td id="treasure">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="treasury_receipt[]" id="treasury_receipt" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="treasure_add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 3)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 3) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary">
                                    <label for="dismissal_receipt">
                                        খারিজের রশিদ/ডিসিআর<span class="text-danger">*</span><br>
                                        <small class="text-muted">আবেদনকৃত <span style="color:red;">জমির খারিজ রশিদ (মূল কপির স্ক্যান কপি</span> সংযোজন করতে হবে। কোনরূপ <span style="color:red;">ফটোকপি হতে স্ক্যান কপি</span> গ্রহণযোগ্য নহে)</small>
                                    </label>
                                </td>
                                <td id="dismissal">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="dismissal_receipt[]" id="dismissal_receipt" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="dismissal_add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 4)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 4) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary">
                                    <label style="text-align:justify;" for="mouza_map">
                                        মৌজা ম্যাপ (৮" x ১২") / প্লট লেআউট <span class="text-danger">*</span><br>
                                        <small class="text-muted">আবেদনকৃত <span style="color:red;">জমির অবস্থান আর.এস মৌজা নক্সার উপর (আবেদনকৃত দাগ বা অংশ বা দাগসমূহ লাল কালি</span> দিয়ে চিহ্নিত করতে হবে)<span style="color:red;">
                                                    প্রতিস্থাপন করে এর স্ক্যান কপি দাখিল করতে হবে। </span> প্রয়োজনবোধে মৌজা নকশার সাইজ বড় হতে পারে।
                                        </small>
                                    </label>
                                </td>
                                <td id="mouja">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="mouza_map[]" id="mouza_map" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="mouja_add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 5)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 5) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary">
                                    <label style="text-align:justify;" for="location_map">
                                        অবস্থান ম্যাপ/হাত নকশা <span class="text-danger">*</span><br>
                                        <small class="text-muted">(আবেদনকৃত <span style="color:red;">জমির অবস্থান হাত নক্সা/ স্কেচ ম্যাপ স্ক্যান</span> করে দাখিল করতে হবে। <span style="color:red;">হাত নক্সা/ স্কেচ ম্যাপে</span> প্রস্তাবিত জমির পরিমাপ, জমি সংলগ্ন রাস্তার প্রশস্থতা, আশে-পাশের ভূমি ব্যবহার, উত্তর-দক্ষিণ দিক নির্দেশনাসহ কোন সর্বজন পরিচিত ইমারত, রাস্তা, মোড়, মসজিদ, পুকুর, রেলপথ, অফিস, স্কুল ইত্যাদি হতে জমিটি কোন দিকে, কত দূরে অবস্থিত তা বিস্তারিতভাবে উল্লেখ করতে হবে) </small>
                                    </label>
                                </td>
                                <td id="location">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="location_map[]" id="location_map" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="location_add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 6)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 6) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <td class="text-primary">
                                    <label for="positionalCertificate">
                                        অঙ্গিকারনামা
                                    </label>
                                </td>
                                <td id="Commitments">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="Commitments[]" id="Commitment" accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="Commitment_add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 7)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 7) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary">
                                    <label for="positionalCertificate">
                                        অবস্থানগত এনওসি সনদপত্র
                                    </label>
                                </td>
                                <td id="certificates">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="positional_certificate[]" id="positionalCertificate" accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="certificate_add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 8)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 8) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary">
                                    <label for="others">
                                        অন্যান্য
                                    </label>
                                </td>
                                <td id="others">
                                    <div class="form-group form-row">
                                        <input type="file" class="col-md-10 form-control form-control-sm" name="others[]" id="others" accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-success btn-sm" id="other_add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                        </div>
                                    </div>
                                    @if($app->is_document_info == 1)
                                        @if(count($app_documents->where('document_type_id', 9)) > 0)
                                            <hr>
                                            <div class="row">
                                                @foreach($app_documents->where('document_type_id', 9) as $app_document)
                                                    <div class="col-md-3 text-center">
                                                        <a href="{{ route('applicant/applications/Store/document/view', ['id' => $app_document->id]) }}" class="text-success" target="_blank" data-toggle="tooltip" title="View">
                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="80">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right">
                                    @if($app->is_submit == 0)
                                        <button type="submit" class="btn btn-secondary" style="background-color: #69419f"><i class="mdi mdi-cloud"></i> সংরক্ষন করুন</button>
                                    @endif
                                    @if($app->is_submit == 1)
                                        <button class="btn btn-success" disabled="disabled"> জমির তথ্য সংরক্ষন করুন</button>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!--Document info content here-->
                <div class="tab-pane fade" id="submission" role="tabpanel" aria-labelledby="submission-tab">
                    <div class="row justify-content-center mb-2 mt-2">
                        @if(($app->is_personal_info == 1) && ($app->is_land_info == 1) && ($app->is_document_info == 1))
                            @if($app->is_submit == 0)
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <p style="color:#009E0F;text-align: center">
                                            <strong>অভিনন্দন !</strong> আপনি সকল ধাপ সফলভাবে সম্পন্ন করেছেন
                                            <br>
                                            "জমা দিন" বোতামটি ক্লিক করে আপনার আবেদন জমা দিন.
                                        </p>
                                        <form action="{{ route('applicant/applications/submit', ['app_id' => encrypt($application_id)]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-info" style="background-color: #8C489F"><i class="mdi mdi-invoice"></i>জমা দিন</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            @if($app->is_submit == 1)
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <p style="color:#009E0F;text-align: center">
                                            <strong>অভিনন্দন !</strong> আপনি সকল ধাপ সফলভাবে সম্পন্ন করেছেন
                                        </p>
                                        <button type="submit" class="btn btn-success" disabled="disabled">জমা দিন</button>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="row mt-3">
                                <div class="col">
                                    <p class="mb-4">আবেদন জমাদেয়ার জন্য উল্লেখিত ধাপসমূহ সম্পূর্ণ করতে হবে</p>

                                    @if($app->is_personal_info == 1)
                                        <p style="color: #2db913"><b>{{ \App\Http\Helpers\Helper::ConvertToBangla(1) }}. ব্যক্তির তথ্য</b></p>
                                    @else
                                        <p style="color: #CF2A27"><b>{{ \App\Http\Helpers\Helper::ConvertToBangla(1) }}. ব্যক্তির তথ্য</b></p>
                                    @endif

                                    @if($app->is_land_info == 1)
                                        <p style="color: #2db913"><b>{{ \App\Http\Helpers\Helper::ConvertToBangla(2) }}. জমির তথ্য</b></p>
                                    @else
                                        <p style="color: #CF2A27"><b>{{ \App\Http\Helpers\Helper::ConvertToBangla(2) }}. জমির তথ্য</b></p>
                                    @endif

                                    @if($app->is_document_info == 1)
                                        <p style="color: #2db913"><b>{{ \App\Http\Helpers\Helper::ConvertToBangla(3) }}. ডকুমেন্টের তথ্য</b></p>
                                    @else
                                        <p style="color: #CF2A27"><b>{{ \App\Http\Helpers\Helper::ConvertToBangla(3) }}. ডকুমেন্টের তথ্য</b></p>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>
        $(document).ready(function(){
            var maxField = 5;
            //Land document dynamic multiple form
            var l = 1;
            $('#add_land_document').click(function(){
                if(l < maxField){
                    l++;
                    $('#land_documents').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="land_document[]" id="Land_document" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="remove_land_document" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#land_documents').on('click', '#remove_land_document', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                l--;
            });

            //RS Khatiyan dynamic multiple form
            var k = 1;
            $('#rs').click(function(){
                if(k < maxField){
                    k++;
                    $('#khatiyan').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="rs_khatiyan[]" id="rs_khatiyan" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="remove_khatiyan" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#khatiyan').on('click', '#remove_khatiyan', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                k--;
            });

            //RS treasure dynamic multiple form
            var t = 1;
            $('#treasure_add').click(function(){
                if(t < maxField){
                    t++;
                    $('#treasure').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="treasury_receipt[]" id="treasury_receipt" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="treasure_remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#treasure').on('click', '#treasure_remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                t--;
            });

            //RS dismissal dynamic multiple form
            var d = 1;
            $('#dismissal_add').click(function(){
                if(d < maxField){
                    d++;
                    $('#dismissal').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="dismissal_receipt[]" id="dismissal_receipt" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="dismissal_remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#dismissal').on('click', '#dismissal_remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                d--;
            });

            //RS mouja dynamic multiple form
            var m = 1;
            $('#mouja_add').click(function(){
                if(m < maxField){
                    m++;
                    $('#mouja').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="mouza_map[]" id="mouza_map" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="mouja_remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#mouja').on('click', '#mouja_remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                m--;
            });

            //RS location dynamic multiple form
            var n = 1;
            $('#location_add').click(function(){
                if(n < maxField){
                    n++;
                    $('#location').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="location_map[]" id="location_map" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="location_remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#location').on('click', '#location_remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                n--;
            });


            //RS stamps dynamic multiple form
            var s = 1;
            $('#certificate_add').click(function(){
                if(s < maxField){
                    s++;
                    $('#certificates').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="positional_certificate[]"  required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="certificate_remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#certificates').on('click', '#certificate_remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                s--;
            });

            //RS stamps dynamic multiple form
            var cm = 1;
            $('#Commitment_add').click(function(){
                if(cm < maxField){
                    cm++;
                    $('#Commitments').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="Commitments[]"  required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="Commitment_remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#Commitments').on('click', '#Commitment_remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                cm--;
            });


            var o = 1;
            $('#other_add').click(function(){
                if(o < maxField){
                    o++;
                    $('#others').append(`
                    <div class="form-group form-row">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="others[]"  required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm" id="other_remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#others').on('click', '#other_remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                o--;
            });

        });

        var $wcolor = 'red';
        setInterval(function(){
            $('#warning-alert').css({'border':'solid 1px '+$wcolor, 'color':$wcolor});
            if($wcolor == 'red'){
                $wcolor = '#806520';
            }
            else {
                $wcolor = 'red';
            }
        },1000);


        $('#pa-same-as-ta').click(function(){
            if($(this).is(':checked')){
                $('#pa_house_no').val($('#ta_house_no').val());
                $('#pa_post_code').val($('#ta_post_code').val());
                $('#pa_road_no').val($('#ta_road_no').val());
                $('#pa_sector_no').val($('#ta_sector_no').val());
                $('#pa_area').val($('#ta_area').val());
                $('#pa_post').val($('#ta_post').val());
                $('#pa_thana').val($('#ta_thana').val());
                $('#pa_district').val($('#ta_district').val());
            }
            else {
                $('#pa_house_no').val('');
                $('#pa_post_code').val('');
                $('#pa_road_no').val('');
                $('#pa_sector_no').val('');
                $('#pa_area').val('');
                $('#pa_post').val('');
                $('#pa_thana').val('');
                $('#pa_district').val('');
            }
        });

        // make a field for number and float
        onload =function(){
            var ele = document.querySelectorAll('.number-only')[0];
            ele.onkeypress = function(e) {
                if(isNaN(this.value+""+String.fromCharCode(e.charCode)))
                    return false;
            }
            ele.onpaste = function(e){
                e.preventDefault();
            }
        }

        let sheepItForm = $('#sheepItForm').sheepIt({
            separator: '',
            allowRemoveLast: true,
            allowRemoveCurrent: true,
            allowRemoveAll: true,
            allowAdd: true,
            allowAddN: true,
            maxFormsCount: 1000,
            minFormsCount: 0,
            iniFormsCount: 0,
            continuousIndex: true
        });

        const data  = $('#data').val();

        if(data !== ''){
            let dataObj = JSON.parse(data);
            for(let j in dataObj){
               if(parseInt(j) !== 0){
                   let dataIndex = parseInt(j) - 1;
                   $('#sheepItForm_add').trigger('click');
                   $('#sheepItForm_'+dataIndex+'_applicant_name').val(dataObj[j]['applicant_name']);
                   $('#sheepItForm_'+dataIndex+'_father_name').val(dataObj[j]['father_name']);
                   $('#sheepItForm_'+dataIndex+'_nid').val(dataObj[j]['nid_number']);
               }
            }
        }
    </script>
@endsection
