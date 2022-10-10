@extends('layouts.master')
@section('title', 'অবস্থান রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50">অবস্থান রেজিস্টার</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card">
        <div class="card-header">
          <div class="row">
              <div class="col-md-8">
                  <span class="card-title">বাছাই করুন</span>
              </div>
              <div class="col-md-4 text-right">
                 <form action="{{ route('report/position') }}">
                     <div class="input-group input-group-sm mb-0">
                         <input class="form-control" name="app_id" placeholder="আবেদন আইডি" value="{{ request()->input('app_id') }}"/>
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
                        <th>জমার তারিখ</th>
                        <th>আবেদন আইডি</th>
                        <th>আবেদনের ধরণ</th>
                        <th>আবেদনকারীর নাম ও ঠিকানা</th>
                        <th class="text-center">জমির বিবরণ (মৌজা, দাগ নং)</th>
                        <th class="text-center">জমির পরিমান</th>
                        <th class="text-center">ভবিষ্যৎ ব্যবহার</th>
                        <th class="text-center">অবস্থান</th>
                        <th class="text-center">নোট</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $i => $application)
                        <tr>
                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }}</td>
                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($application->submission_date))) }}</td>
                            <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}</td>
                            <td class="text-center align-middle">
                                @if($application->app_type == 'Emergency')
                                    <span class="bg-gray-300 px-2 text-danger"> জরুরী </span>
                                @else
                                    <span>সাধারণ </span>
                                @endif
                            </td>
                            <td>
                                <p>{{ $application->user->name }}</p>
                                <p>পিতাঃ {{ $application->personalInfo->fname }}</p>
                                <p>{{ $application->personalInfo->pa_area }}, {{ $application->personalInfo->pa_post}}, {{ $application->personalInfo->pa_thana}} , {{ $application->personalInfo->pa_district}} </p>
                            </td>
                            <td class="text-center align-middle">
                                {{ $application->landInfo->area_name }}, {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->rs_plot_no) }}
                            </td>
                            <td class="text-center align-middle">
                                {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount) }} একর
                            </td>
                            <td class="text-center align-middle">
                                {{ \App\Models\LandUseFuture::findOrFail($application->landInfo->land_future_use)->flut_name }}
                            </td>
                            <td class="text-center">
                                @if($application->is_new == 1)
                                    <span>নতুন আবেদন</span>
                                @elseif($application->is_failed)
                                    <span class="text-danger">ব্যর্থ আবেদন</span>
                                @elseif($application->is_complete)
                                    <span class="text-danger">সম্পুর্ন আবেদন</span>
                                @else
                                    <span>
                                        {{ \App\User::findOrFail($application->receive_application->to_user_id)->name }},  {{ \App\User::findOrFail($application->receive_application->to_user_id)->designation->name }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('report/position/details', ['id' => $application->id, 'type' => $application->is_new == 1 ? 'new' : 'fw']) }}" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-eye"></i> আবেদন এর বিস্তারিত</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
