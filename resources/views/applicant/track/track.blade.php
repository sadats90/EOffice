@extends('applicant.layouts.master')
@section('title', 'আবেদন ট্র্যাক')
@section('content')
    <p>আবেদন ট্র্যাক</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card p-2">
        <div class="card-header">
            সার্চ করুন
        </div>
        <div class="card-body">
            @include('includes.message')
           <div class="row">
               <div class="col-sm-12 col-md-8 col-lg-8 offset-2 mt-5 mb-5">
                   <form action="{{ route('applicant/applications/trackResult') }}" method="get">
                       <div class="input-group mb-3">
                           <div class="input-group-prepend">
                               <span class="input-group-text">আবেদন নং</span>
                           </div>
                           <input type="text" class="form-control" required name="id">
                           <div class="input-group-append">
                               <button type="submit" class="input-group-text"><i class="fas fa-map-marker-alt mr-2"></i> ট্র্যাক করুন</button>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
        </div>
    </div>

@endsection
