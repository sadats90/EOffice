@extends('layouts.master')
@section('title', 'এনওসি সনদপত্র ইস্যু নিবন্ধন রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50"> এনওসি সনদপত্র ইস্যু নিবন্ধন রেজিস্টার</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card">
        <div class="card-header">
          <div class="row">
              <div class="col-md-8">
                  <span class="card-title">বাছাই করুন</span>
              </div>
              <div class="col-md-4 text-right">
                 <form action="{{ route('report/certificateIssue') }}">
                     <div class="input-group input-group-sm mb-0">
                         <select class="form-control form-control-sm" name="year">
                             <option value="">-সব বছর-</option>
                             @foreach($years as $year)
                                 <option value="{{ $year->year }}" @if(request()->input('year') == $year->year) selected @endif>{{ \App\Http\Helpers\Helper::ConvertToBangla($year->year) }}</option>
                             @endforeach
                         </select>
                         <div class="input-group-append">
                             <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> খুজুন</button>
                         </div>
                     </div>
                 </form>
              </div>
          </div>
        </div>
        <div class="card-body">
            @include('includes.message')
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">ক্রমিক নং </th>
                        <th class="text-center">স্বারক নং</th>
                        <th class="text-center">ইস্যু তারিখ</th>
                        <th>প্রাপক</th>
                        <th class="text-center">প্রাপকের ঠিকানা</th>
                        <th class="text-center">আবেদন আইডি</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certificates as $i => $certificate)
                        <tr>
                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }}</td>
                            <td class="text-center align-middle">০৪০.০০৩.০০২.০০০.০০০.{{ \App\Http\Helpers\Helper::ConvertToBangla($certificate->application->app_id) }}/{{ \App\Http\Helpers\Helper::ConvertToBangla($certificate->certificate_no) }}</td>
                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($certificate->issue_date))) }}</td>
                            <td>
                                <ul>
                                    <li>{{ $certificate->application->user->name }}, <strong>পিতাঃ  </strong>{{ $certificate->application->personalInfo->fname }}</li>
                                    @foreach($certificate->application->personalInfo->applicants as $applicant)
                                        <li>{{ $applicant->applicant_name }}, <strong>পিতাঃ  </strong>{{ $applicant->father_name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center align-middle">
                                {{ $certificate->application->personalInfo->pa_house_no }},
                                {{ $certificate->application->personalInfo->pa_road_no }},
                                {{ $certificate->application->personalInfo->pa_sector_no }},
                                {{ $certificate->application->personalInfo->pa_area }},
                                {{ $certificate->application->personalInfo->pa_post }},
                                {{ $certificate->application->personalInfo->pa_thana }},
                                {{ $certificate->application->personalInfo->pa_district }},
                            </td>
                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla($certificate->application->app_id) }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
