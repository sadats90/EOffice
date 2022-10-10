@extends('layouts.master')
@section('title', ' স্বারক প্রতিস্থাপন অনুরোধ সমূহ')
@section('content')
    <p class="m-0 text-black-50"> স্বারক প্রতিস্থাপন অনুরোধ সমূহ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">

                      </div>
                      <div class="col-md-6">
                          <form action="{{ route('SwarakReplacement/request') }}" method="get" autocomplete="off">
                              <div class="input-group input-group-sm m-0">
                                  <input type="text" name="app_id" id="app_id" class="form-control form-control-sm" placeholder="আবেদন আইডি" value="{{ request()->input('app_id') }}" >
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
                       @if(count($replacementRequests) > 0)
                           <table class="table table-bordered table-sm pb-5">
                               <thead class="thead-light">
                               <tr>
                                   <th class="text-center">ক্র নং</th>
                                   <th class="text-center">আবেদন আইডি</th>
                                   <th class="text-center"> অনুরোধের তারিখ</th>
                                   <th class="text-left"> বিষয়</th>
                                   <th class="text-center">আবেদনের ধরণ</th>
                                   <th class="text-center">আবেদনকারীর নাম</th>
                                   <th class="text-center">মোবাইল নম্বর</th>
                                   <th class="text-center">অবস্থা</th>
                               </tr>
                               </thead>
                               <tbody>
                               @php( $initialNumber = (($replacementRequests->currentPage() -1) * $replacementRequests->perPage())+1)
                               @foreach($replacementRequests as $replacementRequest)
                                   <tr>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($initialNumber++)  }}</td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($replacementRequest->application->app_id) }} </td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($replacementRequest->submitted_at))) }}</td>
                                       <td class="text-left">{{ $replacementRequest->subject }} </td>
                                       <td class="text-center">
                                           @if($replacementRequest->application->app_type == 'Emergency')
                                               <span class="bg-gray-300 px-2 text-danger"> জরুরী </span>
                                           @else
                                              <span>সাধারণ </span>
                                           @endif
                                       </td>
                                       <td class="text-center">{{ $replacementRequest->application->user->name }} </td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(\App\User::find($replacementRequest->application->user_id)->mobile) }} </td>
                                       <td class="text-center">
                                           <div class="dropdown show">
                                               <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                                  কার্যক্রম
                                               </button>
                                               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                   <a class="dropdown-item" href="{{ route('SwarakReplacement/review',['id'=>encrypt($replacementRequest->application->id)]) }}"><i class="fas fa-file-alt"></i> অনুরোধ পর্যালোচনা</a>
                                                   <a class="dropdown-item  confirm-alert" href="{{ route('SwarakReplacement/cancel',['id'=>encrypt($replacementRequest->application->id)]) }}"><i class="fas fa-file"></i> অনুরোধ বাতিল করুন</a>
                                               </div>
                                           </div>
                                       </td>
                                   </tr>
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
                           {{ $replacementRequests->links() }}
                       </ul>
                   </div>
                   <!--Pagination end-->
               </div>
           </div>
       </div>
    </div>
@endsection
