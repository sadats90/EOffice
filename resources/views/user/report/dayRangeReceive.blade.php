@extends('layouts.master')
@section('title', 'গ্রহন রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50">গ্রহন রেজিস্টার</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card">
        <div class="card-header">
           <div class="row">
               <div class="col-6">বাছাই করুন</div>
               <div class="col-6 text-right">
                   <button class="btn btn-sm btn-secondary" onclick="Print('print_report')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                    <a href="{{ route('report/dayRange') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-alt-circle-up"></i> ফিরে যান</a>
               </div>
           </div>
        </div>
        <div class="card-body text-dark" id="print_report">
            <div class="row">
                <div class="col-12 text-center">
                    @include('user.inc.header') <!-- Header -->
                    <strong>গ্রহন রিপোর্ট</strong>
                </div>
                <div class="col-12 mt-2">
                    <hr class="m-0">
                    <div class="row p-1">
                        <div class="col">
                            <strong>ব্যবহারকারীর নাম:</strong><span> {{ $user }}</span>
                        </div>
                        <div class="col text-center">
                            <strong>প্রেরক: </strong>
                            <span>{{ $receipient }}</span>
                        </div>
                        <div class="col text-right">
                            <strong>তারিখ: </strong><span> {{ $date }}</span> <strong>থেকে: </strong><span> {{ $to_date  }}</span>
                        </div>
                    </div>
                    <hr class="m-0">
                </div>
                @include('user.inc.receive_report_view') <!-- Receive report view template -->
            </div>
        </div>
    </div>
@endsection

