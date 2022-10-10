@extends('layouts.master')
@section('title', 'বাতিল আবেদন সমূহ')
@section('content')
    <p class="m-0 text-black-50"> বাতিল আবেদন সমূহ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                   <div class="row">
                       <div class="col-md-6">
                           বাতিল আবেদন সমূহ
                       </div>
                       <div class="col-md-6">
                           <form action="{{ route('Cancel') }}" method="get" autocomplete="off">
                               <div class="input-group input-group-sm m-0">
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
                       @if(count($application) > 0)
                           <table class="table table-bordered table-sm pb-5">
                               <thead class="thead-light">
                               <tr>
                                   <th class="text-center">ক্র নং</th>
                                   <th class="text-center">আবেদন আইডি</th>
                                   <th class="text-center"> আবেদনের তারিখ</th>

                                   <th class="text-center">আবেদনের ধরণ</th>
                                   <th class="text-center">আবেদনের প্রকার</th>
                                   <th class="text-center">আবেদনকারীর নাম</th>
                                   <th class="text-center">মোবাইল নম্বর</th>
                                   <th class="text-center">অবস্থা</th>
                               </tr>
                               </thead>
                               <tbody>
                               @php( $initialNumber = (($application->currentPage() -1) * $application->perPage())+1)
                               @foreach($application as $na)
                                   <tr>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($initialNumber++)  }}</td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($na->app_id) }} </td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($na->submission_date))) }}</td>
                                       <td class="text-center">
                                           @if($na->app_type == 'Emergency')
                                               <span class="bg-gray-300 px-2 text-success"> জরুরী </span>
                                           @else
                                              <span>সাধারণ </span>
                                           @endif
                                       </td>
                                       <td class="text-center"><span class="text-danger">বাতিল আবেদন</span> </td>
                                       <td class="text-center">{{ $na->user->name }} </td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(\App\User::find($na->user_id)->mobile) }} </td>
                                       <td class="text-center">
                                           <div class="dropdown show">
                                               <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                                  কার্যক্রম
                                               </button>
                                               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                   <a class="dropdown-item" href="{{ route('Cancel/app_view',['id'=>encrypt($na->id)]) }}"><i class="fas fa-file-alt"></i> আবেদন পর্যালোচনা</a>
                                                   <a class="dropdown-item" href="{{ route('Cancel/paper_view',['id'=>encrypt($na->id)]) }}"><i class="fas fa-file"></i> ডকুমেন্ট পর্যালোচনা</a>
                                                   <form  action="{{ route('Cancel/RestoreApplication',['id'=>encrypt($na->id)]) }}" method="post" id="cancel_app_form_{{ $na->invoiceInfo->id }}">
                                                       @csrf
                                                       @method('post')
                                                       <button type="submit" class="dropdown-item" onclick="return ConfirmForm('cancel_app_form_'+{{ $na->invoiceInfo->id }});"><i class="fas fa-check-circle"></i> আবেদন পুনরুদ্ধার </button>

                                                   </form>

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
                           {{ $application->links() }}
                       </ul>
                   </div>
                   <!--Pagination end-->
               </div>
           </div>
       </div>
    </div>


@endsection

