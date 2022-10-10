@extends('applicant.layouts.master')
@section('title', 'একই স্বারকে প্রতিস্থাপনের তথ্য')
@section('content')
    <p>একই স্বারকে প্রতিস্থাপনের তথ্য</p>
    <hr>
    <div style="font-family: kalpurush;">
        <div class="card" style="color: #000000;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-primary btn-sm" type="button" onclick="Print('print_this')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                    </div>
                </div>
            </div>
            <div class="card-body mr-1 pl-3">
                @include('user.inc.correctionRequestView')
            </div>
        </div>
    </div>

@endsection
