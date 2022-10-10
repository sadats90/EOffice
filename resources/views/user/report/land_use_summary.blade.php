@extends('layouts.master')
@section('title', 'ভূমি ব্যবহার রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50">ভূমি ব্যবহার আবেদনের সারাংশ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <span class="card-title">বাছাই করুন</span>
            </div>
            <div class="card-body">
               <div class="container">
                   <form action="{{ route('report/landUseSummary') }}" class="form-row" autocomplete="off">

                       <div class="input-group input-group-sm col-5 mb-1">
                           <div class="input-group-prepend">
                               <label for="dateFrom" class="input-group-text"> তারিখ</label>
                           </div>
                           <input class="form-control datePicker" type="text" name="dateFrom" id="dateFrom" placeholder="dd/mm/yy" value="{{ request()->input('dateFrom') }}">
                       </div>

                       <div class="input-group input-group-sm col-5 mb-1">
                           <div class="input-group-prepend">
                               <label for="dateTo" class="input-group-text"> হইতে</label>
                           </div>
                           <input class="form-control datePicker" type="text" name="dateTo" id="dateTo" placeholder="dd/mm/yy" value="{{ request()->input('dateTo') }}">
                       </div>
                       <div class="col-2">
                           <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> খুঁজুন </button>
                       </div>
                   </form>
               </div>
            </div>
        </div>
        <div class="card mt-2 text-dark">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <span class="card-title">আবেদনের সারাংশ</span>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-sm btn-secondary" onclick="Print('print_body')" type="button"><i class="fas fa-print"></i> প্রিন্ট করুন </button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="print_body">
                <div class="row">
                    <div class="col-8 offset-2">
                        <div class="d-print-block d-none text-center">
                        @include('user.inc.header') <!-- Header -->
                            <strong>আবেদনের সারাংশ</strong>
                        </div>
                        <table class="table table-sm table-bordered text-dark">
                            <tr>
                                <th class="text-center"> আবেদনের ধরণ</th>
                                <th class="text-center">আবেদনের সংখ্যা</th>
                                <th class="text-right">টাকার পরিমান</th>
                            </tr>
                            <tr>
                                <td class="text-center"> নতুন আবেদন</td>
                                <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(count($applications->where('is_submit', 1)->where('is_new', 1))) }} টি</td>
                                <td class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($applications->where('is_submit', 1)->where('is_new', 1)->sum('form_buy_price')) }} ৳</td>
                            </tr>
                            <tr>
                                <td class="text-center"> প্রক্রিয়াধীন আবেদন</td>
                                <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(count($applications->where('is_submit', 1)->where('is_new', 0)->where('is_failed', 0)->where('is_complete', 0))) }} টি</td>
                                <td class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($applications->where('is_submit', 1)->where('is_new', 0)->where('is_failed', 0)->where('is_complete', 0)->sum('form_buy_price')) }} ৳</td>
                            </tr>
                            <tr>
                                <td class="text-center"> অনিস্পত্তি আবেদন</td>
                                <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(count($applications->where('is_submit', 1)->where('is_failed', 1)->where('is_complete', 0))) }} টি</td>
                                <td class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($applications->where('is_submit', 1)->where('is_failed', 1)->where('is_complete', 0)->sum('form_buy_price')) }} ৳</td>
                            </tr>
                            <tr>
                                <td class="text-center"> সম্পুর্ণ আবেদন</td>
                                <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(count($applications->where('is_submit', 1)->where('is_failed', 0)->where('is_complete', 1))) }} টি</td>
                                <td class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($applications->where('is_submit', 1)->where('is_failed', 0)->where('is_complete', 1)->sum('form_buy_price')) }} ৳</td>
                            </tr>
                            <tr>
                                <td class="text-center"> জমা না হওয়া আবেদন</td>
                                <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(count($applications->where('is_submit', 0))) }} টি</td>
                                <td class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($applications->where('is_submit', 0)->sum('form_buy_price')) }} ৳</td>
                            </tr>
                            <tr>
                                <td class="text-center"> মোট আবেদন</td>
                                <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(count($applications)) }} টি</td>
                                <td class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($applications->sum('form_buy_price')) }} ৳</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
