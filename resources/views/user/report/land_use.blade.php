@extends('layouts.master')
@section('title', 'ভূমি ব্যবহার রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50">ভূমি ব্যবহার রেজিস্টার</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">বাছাই করুন</span>
        </div>
        <div class="card-body">
            <form action="{{ route('report/landUse') }}" class="form-row" autocomplete="off">

                <div class="input-group input-group-sm col-3 mb-1 pl-4">
                    <div class="input-group-prepend">
                        <label for="dateFrom" class="input-group-text"> তারিখ</label>
                    </div>
                    <input class="form-control datePicker" type="text" name="dateFrom" id="dateFrom" placeholder="dd/mm/yy" value="{{ request()->input('dateFrom') }}">
                </div>

                <div class="input-group input-group-sm col-3 mb-1">
                    <div class="input-group-prepend">
                        <label for="dateTo" class="input-group-text"> হইতে</label>
                    </div>
                    <input class="form-control datePicker" type="text" name="dateTo" id="dateTo" placeholder="dd/mm/yy" value="{{ request()->input('dateTo') }}">
                </div>
                <div class="input-group input-group-sm col-2 mb-1">
                    <div class="input-group-prepend">
                        <label for="dateTo" class="input-group-text"> আবেদন আইডি</label>
                    </div>
                    <input class="form-control" type="text" name="app_id" id="app_id" value="{{ request()->input('app_id') }}">
                </div>
                <div class="input-group input-group-sm col-3 mb-1">
                    <div class="input-group-prepend">
                        <label for="dateTo" class="input-group-text"> ভূমি ভবিষ্যত ব্যবহার</label>
                    </div>
                    <select class="form-control" name="land_use_type">
                        <option value="">-সব-</option>
                        @foreach($land_future_use_types as $land_use)
                        <option value="{{ $land_use->id  }}" @if(request()->input('land_use_type') == $land_use->id) selected @endif>{{ $land_use->flut_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-1">
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> খুজুন</button>
                </div>
            </form>
        </div>
    </div>


    <div class="card mt-2 text-dark">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <span class="card-title">ভূমি ব্যবহার রিপোর্ট</span>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-secondary" onclick="Print('print_body')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                </div>
            </div>
        </div>
        <div class="card-body" id="print_body">
            <div class="row">
                <div class="col-12 d-print-block d-none text-center">
                @include('user.inc.header') <!-- Header -->
                    <strong> ভূমি ব্যবহার রিপোর্ট</strong>
                </div>
                <div class="col-12">
                    <table class="table table-sm table-bordered text-dark">
                        <thead>
                        <tr>
                            <th class="text-center align-middle">ক্রমিক নং</th>
                            <th class="text-center align-middle">জমার তারিখ</th>
                            <th class="text-center align-middle">আবেদন আইডি</th>
                            <th class="text-center align-middle">আবেদন এর ধরণ</th>
                            <th class="align-middle">আবেদনকারীর নাম ও ঠিকানা</th>
                            <th class="text-center align-middle">জমির বিবরণ (মৌজা, দাগ নং)</th>
                            <th class="text-center align-middle">জমির পরিমান</th>
                            <th class="text-center align-middle">ভবিষ্যৎ ব্যবহার</th>
                            <th class="text-right align-middle">টাকার পরিমান</th>
                            <th class="text-center align-middle">অর্থ প্রদানের বিবরণ</th>
                            <th class="text-center align-middle">অবস্থান</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($total = 0)
                        @foreach($applications as $i => $application)
                            @php($total += $application->form_buy_price)
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
                                <td class="text-right align-middle">
                                    {{\App\Http\Helpers\Helper::ConvertToBangla($application->form_buy_price)}}৳
                                </td>
                                <td class="align-middle">
                                    <p>ট্রানজেকশন নং : {{ $application->trxn_id }}</p>
                                    <p>তারিখ : {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($application->form_buy_date))) }}</p>
                                    <p>পরিশোধ মাধ্যমের ধরণ : {{ $application->payment_method }}</p>
                                </td>
                                <td class="text-center">
                                    @if($application->is_new == 1)
                                        <span class="text-info">নতুন আবেদন</span>
                                    @elseif($application->is_failed)
                                        <span class="text-danger">ব্যর্থ আবেদন</span>
                                    @elseif($application->is_complete)
                                        <span class="text-success">সম্পুর্ন আবেদন</span>
                                    @else
                                        <span>
                                        {{ \App\User::findOrFail($application->receive_application->to_user_id)->name }},  {{ \App\User::findOrFail($application->receive_application->to_user_id)->designation->name }}
                                    </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="8" class="text-right">মোট</th>
                            <th class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($total) }}৳</th>
                            <th class="text-right"></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
@endsection
