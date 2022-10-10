@extends('applicant.layouts.master')
@section('title', 'চিঠির বিস্তারিত')
@section('content')
    <p class="m-0 text-black-50">চিঠির বিস্তারিত</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            চিঠির বিস্তারিত
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary btn-sm" type="button" onclick="Print('print_this')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    @include('includes.view-letter')

                </div>
            </div>
        </div>
    </div>
@endsection
