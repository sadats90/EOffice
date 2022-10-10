@extends('layouts.master')
@section('title', 'আবেদন যাচাইকরণ')
@section('content')
    <p class="m-0 text-black-50"> আবেদন যাচাইকরণ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          <span class="card-title"> <strong class="text-danger">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}</strong> নং আবেদন যাচাইকরণ <span class="text-danger">{{ $application->user->name }}</span></span>
                      </div>
                      <div class="col-md-6 text-right">
                          <a href="{{ route('report/position') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> অবস্থান রিপোর্ট</a>
                      </div>
                  </div>
               </div>
               <div class="card-body">
                   @include('includes.message')
                   <div class="row">
                       <div class="col-md-6 col-lg-6 col-sm-12">
                               <div class="form-group row">
                                   <div class="col-sm-12">
                                       <div class="card">
                                           <div class="card-body" style="max-height: 550px;overflow-y: auto;">
                                               @if($type == 'new')
                                                   @can('isInTask', 'admin:na')
                                                       <table class="table table-sm table-bordered">

                                                           @if($application->landInfo->is_own_project == 'না')
                                                               <tr>
                                                                   <th class="text-right">জমির তফসিল</th>
                                                                   <td class="text-left">
                                                                       <table class="table table-sm mb-0">
                                                                           <tr>
                                                                               <th>মৌজা/এলাকা</th>
                                                                               <th>জে.এল</th>
                                                                               <th>আর এস দাগ নং</th>
                                                                           </tr>
                                                                           @foreach($application->landInfo->not_own_project_info->not_own_project_extra_infos as $tafsil)
                                                                               <tr>
                                                                                   <td>{{ $tafsil->mouzaArea->name }}</td>
                                                                                   <td>{{ $tafsil->mouzaArea->jl_name }}</td>
                                                                                   <td>{{ \App\Http\Helpers\Helper::ConvertToBangla($tafsil->rs_line_no) }}</td>
                                                                               </tr>
                                                                           @endforeach
                                                                       </table>
                                                                   </td>
                                                               </tr>
                                                               <tr>
                                                                   <th class="text-right">সরকারী কোন সংস্থা হতে অধিগ্রহণ হয়েছে কি না?</th>
                                                                   <td class="text-left">{{ $application->landInfo->not_own_project_info->is_acquisition }}</td>
                                                               </tr>
                                                           @endif
                                                           <tr>
                                                               <th class="text-right">জমির পরিমান (একর)</th>
                                                               <td class="text-left">
                                                                   {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount) }}
                                                                   ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->land_amount, 3)) }} কাঠা)
                                                               </td>
                                                           </tr>
                                                           @if($application->landInfo->not_own_project_info != null)
                                                               @if($application->landInfo->not_own_project_info->is_acquisition == 'হ্যাঁ')
                                                                   <tr>
                                                                       <th class="text-right">অধিগ্রহনের পরিমান(একর)</th>
                                                                       <td class="text-left">
                                                                           {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->not_own_project_info->acquisition_amount) }}
                                                                           ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->not_own_project_info->acquisition_amount, 3)) }} কাঠা)
                                                                       </td>
                                                                   </tr>

                                                                   <tr>
                                                                       <th class="text-right">অবশিষ্ট জমির পরিমান(একর)</th>
                                                                       <td class="text-left">
                                                                           {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount) }}
                                                                           ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) * ($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount), 3)) }} কাঠা)
                                                                       </td>
                                                                   </tr>
                                                                   <tr>
                                                                       <th class="text-right">অধিগ্রহনের ডকুমেন্ট</th>
                                                                       <td class="text-left">
                                                                           <a data-fancybox data-type="iframe" data-src="{{ asset($application->landInfo->not_own_project_info->document_path) }}" href="javascript:;" class="ml-1">
                                                                               <img class="img-fluid img-thumbnail" src="{{ asset('images/file-icon.png') }}" width="45">
                                                                           </a>
                                                                       </td>
                                                                   </tr>
                                                               @endIf
                                                           @endif
                                                       </table>
                                                   @endcan
                                               @else
                                                   @include('user.inc.report_view')
                                               @endif
                                           </div>
                                       </div>
                                   </div>
                               </div>
                       </div>
                       <div class="col-md-6 col-lg-6 col-sm-12">
                           <div class="card">
                               <div class="card-body" style="max-height: 550px;overflow-y: auto;">
                                   <ul class="nav nav-pills mb-1 drafts-verification-application-menu" id="pills-tab" role="tablist">
                                       <li class="nav-item">
                                           <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">আবেদনের তথ্য</a>
                                       </li>
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">জমির তথ্য</a>
                                       </li>
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">কাগজ সমূহ</a>
                                       </li>
                                       @can('isInTask', 'admin:lp:li')
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-letter-tab" data-toggle="pill" href="#pills-letter" role="tab" aria-controls="pills-letter" aria-selected="false">চিঠি</a>
                                       </li>
                                       @endcan
                                       @can('isInTask', 'admin:cm:cv:cs:cd')
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-certificate-tab" data-toggle="pill" href="#pills-certificate" role="tab" aria-controls="pills-certificate" aria-selected="false">এনওসি সনদপত্র</a>
                                       </li>
                                       @endcan
                                   </ul>
                                   <div class="tab-content" id="pills-tabContent">
                                       <!-- Application Information -->
                                       <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                           @include('user.inc.applicationInfo')
                                       </div>
                                       <!-- Land Information -->
                                       <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                           @include('user.inc.landInfo')
                                       </div>
                                       <!-- Document Information -->
                                       <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                          @include('user.inc.documentView')
                                       </div>
                                        @can('isInTask', 'admin:lp:li')
                                           <!-- Letter Information -->
                                           <div class="tab-pane fade" id="pills-letter" role="tabpanel" aria-labelledby="pills-letter-tab" style="min-height: 150px; padding-top: 10px; width: 100%; overflow-y: auto">
                                               <div class="card mt-2">
                                                    <div class="card-header p-1">
                                                        <span class="card-title m-0"> চিঠি সমুহ</span>
                                                    </div>
                                                   <div class="card-body">
                                                       <div class="table-responsive">
                                                           @if(count($application->letter_issues ) > 0)
                                                               <table class="table table-bordered table-striped table-sm">
                                                                   <thead>
                                                                   <tr>
                                                                       <td class="text-center">ক্র নং</td>
                                                                       <td class="text-center">চিঠির ধরণ</td>
                                                                       <td class="text-center">বিষয়</td>
                                                                       <td class="text-center">প্রেরণের তথ্য</td>
                                                                       <td class="text-center">শেষ তারিখ</td>
                                                                       <td class="text-right">কার্যক্রম</td>
                                                                   </tr>
                                                                   </thead>
                                                                   <tbody>
                                                                   @php($sl = 1)
                                                                   @foreach($application->letter_issues as $letter)
                                                                       <tr>
                                                                           <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($sl++) }}</td>
                                                                           <td>{{ $letter->letterType->name }}</td>
                                                                           <td>{{ $letter->subject }}</td>
                                                                           <td>
                                                                               @if($letter->is_issued == 1)
                                                                                   <small>প্রেরণের তারিখঃ {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->issue_date))) }} </small>
                                                                                   <br>
                                                                                   <small>{{ $letter->is_read == 1 ? 'আবেদনকারী দেখেছে' : 'আবেদনকারী দেখেনি' }}</small>
                                                                                   <br>
                                                                                   <small>{{ $letter->is_solved == 1 ? 'সমাধান হয়েছে' : 'সমাধান হয়নি' }}</small>
                                                                               @else
                                                                                   <span class="text-warning">প্রেরণ হয়নি</span>
                                                                               @endif
                                                                           </td>
                                                                           <td class="text-center">
                                                                                {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->expired_date))) }}
                                                                           </td>
                                                                           <td class="text-right">
                                                                               @can('isInTask', 'admin:lp:li')
                                                                                   <button class="btn btn-sm btn-info" onclick="return ShowInPopUp('{{ route("letter/show", ["id" => encrypt($letter->id), "app_id" => encrypt($application->id)]) }}', 'চিঠির বিস্তারিত')" data-toggle="tooltip" data-placement="top" title="বিস্তারিত"><i class="fas fa-desktop"></i></button>

                                                                               @endcan
                                                                           </td>
                                                                       </tr>
                                                                   @endforeach
                                                                   </tbody>
                                                               </table>
                                                           @else
                                                               <h4 class="text-center text-secondary">এই আবেদন এর কোন চিঠি নাই</h4>
                                                           @endif
                                                       </div>
                                                   </div>
                                               </div>
                                       </div>
                                       @endcan

                                       <!--Certificate -->
                                       <div class="tab-pane fade" id="pills-certificate" role="tabpanel" aria-labelledby="pills-certificate-tab">
                                           @if($application->is_certificate_make == 0 )

                                           @else
                                              <div class="text-right">
                                                  @can('isInTask', 'admin:cm:cv:cs:cd')
                                                  <a href="{{ route('certificate/view', ['id' => $application->id, 'type' => $type]) }}" class="btn btn-info btn-sm mb-2" style="border-radius: 0" target="_blank"><i class="fas fa-desktop"></i> বিস্তারিত</a>
                                                  @endcan

                                                  @can('isInTask', 'admin:cd')
                                                  <button type="button" class="btn btn-secondary btn-sm mb-2" style="border-radius: 0" onclick="Print('print_this')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>

                                                  @endcan
                                              </div>
                                                @if($application->certificate->is_issue == 1)
                                                   @include('user.inc.certificate_view')
                                                @endif
                                           @endif
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
@section('script')

@endsection

