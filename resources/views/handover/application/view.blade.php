@extends('layouts.master')

@section('title', 'আবেদন পর্যালচনা')

@section('content')
    <p class="m-0 text-black-50"> আবেদন পর্যালচনা</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          আবেদন পর্যালচনা
                      </div>
                      <div class="col-md-6 text-right">
                          <a href="{{ route('workHandover/Application') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফরওয়ার্ডকৃত আবেদন সমূহ</a>
                      </div>
                  </div>
               </div>
               <div class="card-body">
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                           <h3 class="border-bottom text-dark">ব্যক্তির তথ্য</h3>
                           @include('user.inc.applicationInfo')
                       </div>
                       <div class="col-lg-12 col-md-12 mb-5">
                           <h3 class="border-bottom text-dark">জমির তথ্য</h3>
                           @include('user.inc.landInfo')
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>
@endsection
