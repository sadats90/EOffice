@extends('layouts.master')
@section('title', 'আবেদন রিপোর্ট')
@section('content')
    <p class="m-0 text-black-50">আবেদন রিপোর্ট</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                   <div class="row">
                       <div class="col-md-6">
                           আবেদন রিপোর্ট
                       </div>
                       <div class="col-md-6 text-right">
                           <button onclick="Print('application-report')" class="btn btn-sm btn-secondary"><i class="fas fa-print"></i> Print</button> |
                           <a href="{{ route('failed') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> অনিস্পত্তি আবেদন সমূহ</a>
                       </div>
                   </div>
               </div>
               <div class="card-body">
                  @include('user.inc.report_view')
               </div>
           </div>
       </div>
    </div>
@endsection
