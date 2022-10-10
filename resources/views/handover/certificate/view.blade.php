@extends('layouts.master')

@section('title', 'এনওসি সনদপত্র')

@section('content')
    <p class="m-0 text-black-50"> এনওসি সনদপত্র</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-10 offset-1">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">এনওসি সনদপত্র</div>
                      @can('isInTask', 'admin:cd')
                      <div class="col-md-6 text-right">
                          <button class="btn btn-secondary btn-sm" type="button" onclick="Print('print_this')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                      </div>
                      @endcan
                  </div>
               </div>
               @include('user.inc.certificate_view')
           </div>
       </div>
    </div>
@endsection
