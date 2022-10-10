@extends('layouts.master')
@section('title', 'নতুন আবেদন')
@section('content')
    <p class="m-0 text-black-50">নতুন আবেদন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                   <div class="row">
                       <div class="col-md-6">
                           নতুন আবেদন সমূহ
                       </div>
                       <div class="col-md-6">
                           <form action="{{ route('newApplication') }}" method="get" autocomplete="off">
                               <div class="input-group input-group-sm m-0">
                                   <select class="form-control form-control-sm" id="app_type" name="app_type">
                                       <option value="">সব ধরণ</option>
                                       <option value="Normal" @if(request()->input('app_type') == 'Normal') selected @endif>সাধারণ</option>
                                       <option value="Emergency" @if(request()->input('app_type') == 'Emergency') selected @endif>জরুরী</option>
                                   </select>
                                   <input type="text" name="app_id" id="app_id" class="form-control form-control-sm" placeholder="আবেদন আইডি" value="{{ request()->input('app_id') }}" >
                                   <input type="text" name="mobile" id="mobile" class="form-control form-control-sm" placeholder="মোবাইল নং" value="{{ request()->input('mobile') }}">
                                   <div class="input-group-append">
                                       <button class="input-group-text" ><i class="fas fa-search mr-1"></i> খুঁজুন</button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
               <div class="card-body">
               @include('includes.message')<!-- Message template -->
                   <div class="table-responsive" style="min-height: 150px; padding-top: 10px;">
                       @if(count($new_application) > 0)
                           <table class="table table-bordered table-sm pb-5">
                               <thead class="thead-light">
                               <tr>
                                   <th class="text-center">ক্র নং</th>
                                   <th class="text-center">আবেদন আইডি</th>
                                   <th class="text-center"> আবেদনের তারিখ</th>

                                   <th class="text-center">আবেদনের ধরণ</th>
                                   <th class="text-center">আবেদনের প্রকার</th>
                                   <th>আবেদনকারীর নাম</th>
                                   <th class="text-center">মোবাইল নম্বর</th>
                                   <th class="text-center">অবস্থা</th>
                               </tr>
                               </thead>
                               <tbody>
                               @php( $initialNumber = (($new_application->currentPage() -1) * $new_application->perPage())+1)

                               @foreach($new_application as $i => $na)
                                   <tr>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($initialNumber)  }}</td>
                                       <td class="text-center">
                                           @if($na->app_type == 'Emergency' || $initialNumber == 1)
                                               <a class="btn btn-sm btn-link" href="{{ route('application/forward',['id'=>encrypt($na->id),'type'=>'new']) }}">{{ \App\Http\Helpers\Helper::ConvertToBangla($na->app_id) }}</a>
                                           @else
                                               {{ \App\Http\Helpers\Helper::ConvertToBangla($na->app_id) }}
                                           @endif

                                       </td>

                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y H:i:s', strtotime($na->submission_date))) }}</td>
                                       <td class="text-center">
                                           @if($na->app_type == 'Emergency')
                                               <span class="bg-gray-300 px-2 text-danger"> জরুরী </span>
                                           @else
                                              <span>সাধারণ </span>
                                           @endif
                                       </td>
                                       <td class="text-center">@if($na->is_failed == 0) <span class="text-success">নতুন</span> @endif @if($na->is_failed == 1) <span class="text-danger">অনুত্তীর্ণ</span> @endif </td>
                                       <td>{{ $na->applicant_name }} </td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(\App\User::find($na->user_id)->mobile) }} </td>
                                       <td class="text-center">
                                           <div class="dropdown show">
                                               <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                                  কার্যক্রম
                                               </button>
                                               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                   <a class="dropdown-item" href="{{ route('application/view',['id'=>encrypt($na->id),'type'=>'new']) }}"><i class="fas fa-file-alt"></i> আবেদন পর্যালোচনা</a>
                                                   <a class="dropdown-item" href="{{ route('application/viewPaper',['id'=>encrypt($na->id),'type'=>'new']) }}"><i class="fas fa-file"></i> ডকুমেন্ট পর্যালোচনা</a>
                                                   @if($na->app_type == 'Emergency' || $initialNumber == 1)
                                                   <a class="dropdown-item" href="{{ route('application/forward',['id'=>encrypt($na->id),'type'=>'new']) }}"><i class="fas fa-check-square"></i> আবেদন যাচাইকরণ</a>
                                                   @endif
                                               </div>
                                           </div>
                                       </td>
                                   </tr>
                                   @php($initialNumber++)
                               @endforeach

                               </tbody>
                           </table>
                       @else
                           <h4 class="text-center text-secondary">আবেদন খালি !</h4>
                       @endif
                   </div>

                   <!--Pagination start-->
                   <div>
                       <ul class="pagination justify-content-end">
                           {{ $new_application->links() }}
                       </ul>
                   </div>
                   <!--Pagination end-->
               </div>
           </div>
       </div>
    </div>
@endsection
