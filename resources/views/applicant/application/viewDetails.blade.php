@extends('applicant.layouts.master')
@section('title', 'পুর্নাঙ্গ আবেদন')
@section('content')
    <p>পুর্নাঙ্গ আবেদন</p><hr>
    <div style="font-family: kalpurush;">
        @include('includes.message')
        <div class="card" style="color: #000000;">
            <div class="card-header p-3">
                <div class="row">
                    <div class="col-md-6">পুর্নাঙ্গ আবেদন</div>
                </div>
            </div>
            <div class="card-body pt-0 mr-1 pl-3">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 text-center" style="border-bottom: solid 1px #999">
                                <button class="m-2 btn btn-secondary btn-sm" onclick="Print('application-details')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                            </div>
                        </div>
                        <div class="row mt-3" id="application-details">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <span style="padding: 5px;border: solid 1px;">নথি নং ০৪০.০০৩০০২.০০০.০০০.{{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}</span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 text-right">
                                        <span style="padding: 5px;border: solid 1px;">ক্রমিক নং {{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}</span>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12 text-center">
                                        <img class="img-fluid mb-1" src="{{ asset('images/rda-logo.PNG') }}" alt="RDA Logo" width="90">
                                        <h2>রাজশাহী উন্নয়ন কর্তৃপক্ষ</h2>
                                        <h5>ভূমি ব্যবহার ছাড়পত্রের জন্য আবেদনপত্র</h5>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 style="background-color: #e4e4e4;padding: 10px 5px;">আবেদনকারীর তথ্য</h4>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <th class="w-25 text-right">আবেদনকারী/আবেদনকারীগণ নামঃ</th>
                                                        <td class="text-left">
                                                            <table class="table-sm table table-bordered">
                                                                <tr>
                                                                    <th>নাম</th>
                                                                    <th>পিতার নাম</th>
                                                                    <th>এনআইডি নাম্বার</th>
                                                                    <th class="text-center">এনআইডি</th>
                                                                </tr>
                                                                @if(!empty($application->personalInfo))
                                                                    @foreach($application->personalInfo->applicants as $applicant)
                                                                        <tr>
                                                                            <td>{{ $applicant->applicant_name }}</td>
                                                                            <td>{{ $applicant->father_name }}</td>
                                                                            <td>{{ $applicant->nid_number }}</td>
                                                                            <td class="text-center">
                                                                                <a data-fancybox data-type="iframe" data-src="{{ asset($applicant->nid_path) }}" href="javascript:;" class="ml-1">
                                                                                    <img alt="attachment" class="img-fluid img-thumbnail" src="{{ asset('images/file-icon.png') }}" width="20">
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </table>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="w-25 text-right">বর্তমান যোগাযোগ ঠিকানাঃ</th>
                                                        <td class="text-left">
                                                            বাসা নং {{ $application->personalInfo->ta_house_no }},
                                                            রাস্তার নাম/রাস্তার নং {{ $application->personalInfo->ta_road_no }},
                                                            সেক্টর নং {{ $application->personalInfo->ta_sector_no }},
                                                            গ্রাম/ওয়ার্ড/এলাকাঃ {{ $application->personalInfo->ta_area }},
                                                            পোস্টঃ {{ $application->personalInfo->ta_post }},
                                                            পোস্ট কোডঃ {{ $application->personalInfo->ta_post_code }},
                                                            থানা/উপজেলাঃ {{ $application->personalInfo->ta_thana }},
                                                            জেলাঃ {{ $application->personalInfo->ta_district }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="w-25 text-right">আবেদনকারীর টেলিফোন/মোবাইল নং</th>
                                                        <td class="text-left">@if(!empty($application->personalInfo)){{ \App\Http\Helpers\Helper::ConvertToBangla($application->personalInfo->mobile) }}@endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="w-25 text-right">স্থায়ী ঠিকানাঃ</th>
                                                        <td class="text-left">
                                                            বাসা নং {{ $application->personalInfo->pa_house_no }},
                                                            রাস্তার নাম/রাস্তার নং {{ $application->personalInfo->pa_road_no }},
                                                            সেক্টর নং {{ $application->personalInfo->pa_sector_no }},
                                                            গ্রাম/ওয়ার্ড/এলাকাঃ {{ $application->personalInfo->pa_area }},
                                                            পোস্টঃ {{ $application->personalInfo->pa_post }},
                                                            পোস্ট কোডঃ {{ $application->personalInfo->pa_post_code }},
                                                            থানা/উপজেলাঃ {{ $application->personalInfo->pa_thana }},
                                                            জেলাঃ {{ $application->personalInfo->pa_district }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 style="background-color: #e4e4e4;padding: 10px 5px;" class="mt-3">যে জমির জন্য অনিস্পত্তি পেতে ইচ্ছুক তার তফসীলঃ</h4>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <th class="w-25 text-right">আরডিএ এর নিজস্ব প্রকল্প কিনা</th>
                                                        <td class="text-left">{{ $application->landInfo->is_own_project }}</td>
                                                    </tr>
                                                    @if($application->landInfo->is_own_project == 'হ্যাঁ')
                                                        <tr>
                                                            <th class="w-25 text-right">প্রকল্প/এলাকার নাম</th>
                                                            <td class="text-left">{{ $application->landInfo->own_project_info->project->name }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th class="w-25 text-right">প্লট নং</th>
                                                            <td class="text-left">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->own_project_info->plot_no) }}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <th class="w-25 text-right">জমির তফসিল</th>
                                                            <td class="text-left">
                                                                <table class="table table-sm mb-0">
                                                                    <tr>
                                                                        <th>উপজেলা</th>
                                                                        <th>মৌজা/এলাকা</th>
                                                                        <th>জে.এল</th>
                                                                        <th>আর এস দাগ নং</th>
                                                                    </tr>
                                                                    @foreach($application->landInfo->not_own_project_info->not_own_project_extra_infos as $tafsil)
                                                                        <tr>
                                                                            <td>{{ $tafsil->mouzaArea->upazila->name }}</td>
                                                                            <td>{{ $tafsil->mouzaArea->name }}</td>
                                                                            <td>{{ $tafsil->mouzaArea->jl_name }}</td>
                                                                            <td>{{ $tafsil->rs_line_no }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-25 text-right">সরকারী কোন সংস্থা হতে অধিগ্রহণ হয়েছে কি না?</th>
                                                            <td class="text-left">{{ $application->landInfo->not_own_project_info->is_acquisition }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th class="w-25 text-right">জমির পরিমান (একর)</th>
                                                        <td class="text-left">
                                                            {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount) }}
                                                            ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->land_amount, 3)) }} কাঠা)
                                                        </td>
                                                    </tr>
                                                    @if($application->landInfo->not_own_project_info != null)
                                                        @if($application->landInfo->not_own_project_info->is_acquisition == 'হ্যাঁ')
                                                            <tr>
                                                                <th class="w-25 text-right">অধিগ্রহনের পরিমান(একর)</th>
                                                                <td class="text-left">
                                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->not_own_project_info->acquisition_amount) }}
                                                                    ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->not_own_project_info->acquisition_amount, 3)) }} কাঠা)
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-25 text-right">অবশিষ্ট জমির পরিমান(একর)</th>
                                                                <td class="text-left">
                                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount) }}
                                                                    ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) * ($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount), 3)) }} কাঠা)
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-25 text-right">অধিগ্রহনের ডকুমেন্ট</th>
                                                                <td class="text-left">
                                                                    <a data-fancybox data-type="iframe" data-src="{{ asset($application->landInfo->not_own_project_info->document_path) }}" href="javascript:;" class="ml-1">
                                                                        <img class="img-fluid img-thumbnail" src="{{ asset('images/file-icon.png') }}" width="45">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endIf
                                                    @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 style="padding: 10px 5px;border-bottom: solid 1px #999;font-size: 14px;" class="mt-3">আবেদনকৃত জমি বর্তমানে কি হিসেবে ব্যবহৃত হচ্ছে</h6>
                                                <p><strong>@if(!empty($application->landInfo)){{ $application->landInfo->plut_name }} @endif</strong></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 style="padding: 10px 5px;border-bottom: solid 1px #999;font-size: 14px;" class="mt-3">আবেদনকৃত জমি ভবিষ্যতে কি হিসেবে ব্যবহৃত হবে</h6>
                                                <p><strong>@if(!empty($application->landInfo)){{ $application->landInfo->flut_name }} @endif</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
