@extends('layouts.master')
@section('title', 'চিঠি সমূহ')
@section('content')
    <p class="m-0 text-black-50">চিঠি সমূহ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                   <div class="row">
                       <div class="col-md-6">
                           চিঠি সমূহ
                       </div>
                       <div class="col-md-6 text-right">
                           @can('handoverIsInTask', ['admin:lp:li', $to_user_id])
                           <a href="{{ route('Handover/Letter/Create', ['id' => $id, 'hit' => 'list']) }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> চিঠি তৈরি</a>
                           @endcan
                           <a href="{{ route('workHandover/Application') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফরওয়ার্ডকৃত আবেদন সমূহ</a>
                       </div>
                   </div>
               </div>
               <div class="card-body">
               @include('includes.message')
                   <div class="table-responsive" style="min-height: 150px; padding-top: 10px; width: 100%; overflow-y: auto">
                       @if(count($letter_issues) > 0)
                           <table class="table table-bordered table-striped table-sm">
                               <thead>
                               <tr>
                                   <td class="text-center">ক্র নং</td>
                                   <td class="text-center">চিঠির ধরণ</td>
                                   <td class="text-center">বিষয়</td>
                                   <td class="text-center">প্রেরণের তথ্য</td>
                                   <td class="text-center">শেষ তারিখ</td>
                                   <td class="text-right">কার্যক্রম</td>
                               </tr>
                               </thead>
                               <tbody>
                               @php($sl = 1)
                               @foreach($letter_issues as $letter)
                                   <tr>
                                       <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($sl++) }}</td>
                                       <td>{{ $letter->letterType->name }}</td>
                                       <td>{{ $letter->subject }}</td>
                                       <td>
                                            @if($letter->is_issued == 1)
                                                <small>প্রেরণ হয়েছে</small>
                                                <br>
                                                <small>প্রেরণের তারিখঃ {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->issue_date))) }} </small>
                                                <br>
                                                <small>{{ $letter->is_read == 1 ? 'আবেদনকারী দেখেছে' : 'আবেদনকারী দেখেনি' }}</small>
                                                <br>
                                                <small>{{ $letter->is_solved == 1 ? 'সমাধান হয়েছে' : 'সমাধান হয়নি' }}</small>
                                            @else
                                                <span>প্রেরণ হয়নি</span>
                                            @endif
                                       </td>
                                       <td>
                                           @if($letter->letter_type_id != 4)
                                           {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->expired_date))) }}
                                           @else
                                               -
                                           @endif

                                       </td>
                                       <td class="text-right" style="width: 15%">
                                           @can('handoverIsInTask', ['admin:lp:li', $to_user_id])
                                               <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="return ShowInPopUp('{{ route("Handover/Letter/show", ["id" => $letter->id, "app_id" => $id]) }}', 'চিঠির বিস্তারিত')" data-toggle="tooltip" data-placement="top" title="বিস্তারিত"><i class="fas fa-desktop"></i></a>
                                               @if($letter->is_solved == 1)
                                                   <a href="{{ route('Handover/Letter/solveReview', ['id' => $letter->id, 'userId' => $to_user_id]) }}" class="btn btn-sm btn-primary mt-1" data-toggle="tooltip" data-placement="top" title="সমাধান পর্যালচনা" target="_blank"><i class="fas fa-envelope"></i></a>
                                               @endif
                                           @endcan
                                           @if($letter->is_issued === 0)
                                               @can('handoverIsInTask', ['admin:lp:li', $to_user_id])
                                                    <a href="{{ route('Handover/Letter/edit', ['id' => $letter->id, 'app_id'=> $id, 'hit' => 'list']) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="সম্পাদন"><i class="fas fa-edit"></i></a>
                                               @endcan
                                               @can('handoverIsInTask', ['admin:li', $to_user_id])
                                                    <a href="{{ route('Handover/Letter/sent', ['id' => $letter->id, 'app_id'=> $id, 'hit' => 'list', 'userId' => $to_user_id]) }}" class="btn btn-sm confirm-alert btn-warning" data-toggle="tooltip" data-placement="top" title="পাঠান"><i class="far fa-envelope"></i></a>
                                               @endcan
                                               @can('handoverIsInTask', ['admin:lp', $to_user_id])
                                                   <a href="{{ route('Handover/Letter/delete', ['id' => $letter->id, 'app_id'=> $id, 'hit' => 'list', 'userId' => $to_user_id]) }}" class="btn btn-sm btn-danger confirm-alert" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"><i class="fas fa-trash-alt"></i></a>
                                                @endcan
                                           @endif
                                       </td>
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                       @else
                           <h4 class="text-center text-secondary">এই আবেদন এর কোন চিঠি নাই</h4>
                       @endif
                   </div>

               </div>
           </div>
       </div>
    </div>


@endsection

