@extends('layouts.master')
@section('title', 'ডকুমেন্ট পর্যালোচনা')
@section('content')
    <p class="m-0 text-black-50"> ডকুমেন্ট পর্যালোচনা</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          ডকুমেন্ট পর্যালোচনা
                      </div>
                      <div class="col-md-6 text-right">
                          <a href="{{ route('failed') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> অনিস্পত্তি আবেদন সমূহ</a>
                      </div>
                  </div>
               </div>
               <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('user.inc.documentView')
                        </div>
                    </div>
               </div>
           </div>
       </div>
    </div>
@endsection
