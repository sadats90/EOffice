@extends('layouts.master')
@section('title', 'উৎকর্ষ ফি রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50">উৎকর্ষ ফি রেজিস্টার</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card">
        <div class="card-header">
          <div class="row">
              <div class="col-md-6">
                  <span class="card-title">বাছাই করুন</span>
              </div>
              <div class="col-md-6 text-right">
                 <form action="{{ route('report/bettermentFee') }}">
                     <div class="input-group input-group-sm mb-0">
                         <select class="form-control form-control-sm" name="project_id">
                             <option value="">-সব প্রকল্প-</option>
                             @foreach($projects as $project)
                                 <option value="{{ $project->id }}" @if(request()->input('project_id') == $project->id) selected @endif>{{ $project->name }}</option>
                             @endforeach
                         </select>
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
                        <th class="text-center">তারিখ</th>
                        <th class="text-center">আবেদন আইডি</th>
                        <th class="text-center">আবেদনের ধরণ</th>
                        <th class="text-center">প্রকল্প</th>
                        <th>আবেদনকারী</th>
                        <th>ভবিষ্যৎ ব্যবহার</th>
                        <th>মৌজা</th>
                        <th class="text-center">টাকার পরিমান</th>
                        <th class="text-center">পরিশোধের বিবরণ</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($letters as $i => $letter)
                            <tr>
                                <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }}</td>
                                <td class="text-center align-middle">০৪০.০০৩.০০২.০০০.০০০.{{ \App\Http\Helpers\Helper::ConvertToBangla($letter->application->app_id) }}.{{ \App\Http\Helpers\Helper::ConvertToBangla($letter->sl_no) }}</td>
                                <td class="text-center align-middle">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->issue_date))) }}</td>
                                <td class="text-center align-middle"><a href="{{ route('report/position/details', ['id' => $letter->application->id, 'type' => $letter->application->is_new == 1 ? 'new' : 'fw']) }}" class="btn-link" target="_blank"> {{ \App\Http\Helpers\Helper::ConvertToBangla($letter->application->app_id) }}</a></td>
                                <td class="text-center align-middle">
                                    @if($letter->application->app_type == 'Emergency')
                                        <span class="bg-gray-300 px-2 text-danger"> জরুরী </span>
                                    @else
                                        <span>সাধারণ </span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{ $letter->betterment_fee->project->name }}</td>
                                <td class="align-middle">{{ $letter->application->user->name }}</td>
                                <td class="text-center align-middle">
                                    {{ \App\Models\LandUseFuture::findOrFail($letter->application->landInfo->land_future_use)->flut_name }}
                                </td>
                                <td class="align-middle"> {{ $letter->application->landInfo->area_name }}</td>
                                <td class="text-center align-middle">
                                    {{ \App\Http\Helpers\Helper::ConvertToBangla($letter->betterment_fee->betterment_fee )}}

                                </td>
                                <td>
                                    <ul>
                                        <li>{{ $letter->betterment_fee_payment->trxn_id }}</li>
                                        <li>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->betterment_fee_payment->payment_date))) }}</li>
                                        <li>{{ $letter->betterment_fee_payment->payment_method }}</li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
