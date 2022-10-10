@extends('layouts.master')
@section('title', ' অনিস্পত্তি আবেদন সমূহ')
@section('content')
    <p class="m-0 text-black-50"> অনিস্পত্তি আবেদন সমূহ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                   <div class="row">
                       <div class="col-md-6">
                           অনিস্পত্তি আবেদন সমূহ
                       </div>
                       <div class="col-md-6">
                           <form action="{{ route('failed') }}" method="get" autocomplete="off">
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
                                       <td class="text-center"><a href="{{ route('failed/report_view',['id'=>encrypt($na->id)]) }}"> {{ \App\Http\Helpers\Helper::ConvertToBangla($na->app_id) }} </a></td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($na->submission_date))) }}</td>
                                       <td class="text-center">
                                           @if($na->app_type == 'Emergency')
                                               <span class="bg-gray-300 px-2 text-success"> জরুরী </span>
                                           @else
                                              <span>সাধারণ </span>
                                           @endif
                                       </td>
                                       <td class="text-center"><span class="text-danger">অনিস্পত্তি আবেদন</span> </td>
                                       <td class="text-center">{{ $na->user->name }} </td>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(\App\User::find($na->user_id)->mobile) }} </td>
                                       <td class="text-center">
                                           <div class="dropdown show">
                                               <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                                  কার্যক্রম
                                               </button>
                                               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                   <a class="dropdown-item" href="{{ route('failed/app_view',['id'=>encrypt($na->id)]) }}"><i class="fas fa-file-alt"></i> আবেদন পর্যালোচনা</a>
                                                   <a class="dropdown-item" href="{{ route('failed/paper_view',['id'=>encrypt($na->id)]) }}"><i class="fas fa-file"></i> ডকুমেন্ট পর্যালোচনা</a>
                                                   <a class="dropdown-item" href="{{ route('failed/report_view',['id'=>encrypt($na->id)]) }}"><i class="far fa-clipboard"></i> আবেদন রিপোর্ট</a>
                                                   <a class="dropdown-item" href="{{ route('failed/letters',['id'=>encrypt($na->id)]) }}"><i class="far fa-envelope"></i> চিঠি সমূহ</a>
                                                   <button class="dropdown-item" onclick="return RestorePopup('{{ route("failed/Restore", ['id'=>encrypt($na->id)]) }}', 'আবেদন পুনরুদ্ধার')" data-toggle="tooltip" data-placement="top" title="আবেদন পুনরুদ্ধার"><i class="far fa-window-restore"></i> আবেদন পুনরুদ্ধার</button>

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

    <div class="modal fade" id="restore-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 35% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    RestorePopup = (url, title) => {
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                $('#restore-modal .modal-title').html(title);
                $('#restore-modal .modal-body').html(res);
                $('#restore-modal').modal("show");
            }
        });
    }
</script>
