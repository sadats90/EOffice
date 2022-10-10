@extends('layouts.master')
@section('title', 'ডাউনলোড ডাটাবেজ')
@section('content')
    <p class="m-0 text-black-50">ডাউনলোড ডাটাবেজ</p>
    <hr>
    <!-- Top Statistics -->
   <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                   ডাউনলোড ডাটাবেজ
               </div>
               <div class="card-body">
               @include('includes.message')<!-- Message template -->
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                           <div class="row justify-content-center">
                               <div class="col-lg-8 col-md-8">
                                   <h5 class="text-center text-success">Database backup file is ready</h5>
                                   <p class="text-center"><a href="{{ route('database/DownloadDatabase') }}" class="btn btn-success"><i class="fa fa-file-download"></i> Download Database</a></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection
