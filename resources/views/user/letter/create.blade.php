@extends('layouts.master')
@section('title', 'চিঠি তৈরি')
@section('content')
    <p class="m-0 text-black-50">চিঠি তৈরি</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-10 offset-1">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6 card-title mb-0">
                          চিঠি তৈরি
                      </div>
                      <div class="col-md-6 text-right">
                          @if($hit == 'list')
                              <a href="{{ route('letter', ['id' => $id, 'type' => $type]) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> চিঠি সমূহ</a>
                          @else
                              <a href="{{ route('application/forward', ['id' => $id, 'type' => $type]) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফিরে যান</a>
                          @endif
                      </div>
                  </div>
               </div>
               <div class="card-body p-4">
               @include('includes.message')<!-- Message template -->
                    <div class="row">
                        <div class="col-12">
                            @include('user.letter._letter_form')
                        </div>
                    </div>
               </div>
           </div>
       </div>
    </div>
@endsection
@section('script')
    @include('user.inc.letter_create_js')

@endsection
