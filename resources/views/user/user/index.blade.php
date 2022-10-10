@extends('layouts.master')
@section('title', 'ব্যবহারকারী')
@section('content')
    <p class="m-0 text-black-50">ব্যবহারকারী</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                ব্যবহারকারীর তালিকা
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('User/Create') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>ব্যবহারকারী যোগ করুন</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ক্র নং</th>
                            <th class="text-center">নাম</th>
                            <th class="text-center">পদবী</th>
                            <th class="text-center">ঠিকানা</th>
                            <th class="text-center">ই-মেইল</th>
                            <th class="text-center">মোবাইল</th>
                            <th class="text-center">অবস্থা</th>
                            <th class="text-center">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php( $initialNumber = (($model->currentPage() -1) * $model->perPage())+1)
                       @foreach($model as $row)
                           <tr>
                               <td class="text-center" style="width: 5%;">{{ $initialNumber++ }}</td>
                               <td>{{ $row->name }}</td>
                               <td>{{ $row->designation->name }}</td>
                               <td>{{ $row->address }}</td>
                               <td>{{ $row->email }}</td>
                               <td>{{ $row->mobile }}</td>
                               <td class="text-center">

                                   @if($row->is_active == 1)
                                       @if($row->is_work_handover == 1)
                                           <span class="text-info">দায়িত্ব হস্তান্তর করা আছে</span>
                                       @else
                                            <span class="text-success">সক্রিয়</span>
                                       @endif
                                   @else
                                       <span class="text-danger">নিস্ক্রিয়</span>
                                   @endif
                               </td>
                               <td class="text-center">
                                   <div class="dropdown show">
                                       <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                           কার্যক্রম
                                       </button>
                                       <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                           <a href="{{ route('User/Show',['id'=>$row->id]) }}" class="dropdown-item text-success" ><i class="mdi mdi-desktop-mac mr-1"></i>বিস্তারিত</a>

                                           @if($row->is_active == 1)
                                               <a href="{{ route('User/Edit',['id'=>$row->id]) }}" class="dropdown-item text-warning"><i class="mdi mdi-square-edit-outline mr-1"></i>সম্পাদন করুন</a>
                                               <a href="{{ route('User/inactive', ['id'=>$row->id]) }}" class="dropdown-item text-danger" ><i class="far fa-times-circle"></i> নিস্ক্রিয়</a>
                                               @if($row->is_work_handover == 1)
                                                   <a href="{{ route('User/CancelWorkHandover',['id'=>$row->id]) }}" class="dropdown-item text-info confirm-alert" ><i class="mdi mdi-account-remove mr-1"></i>দায়িত্ব হস্তান্তর বাতিল</a>
                                               @else
                                                   <a href="javascript:void(0)" onclick="return ShowInPopUp('{{ route('User/WorkHandover',['id'=>$row->id]) }}', '{{ $row->name }} এর দায়িত্ব হস্তান্তর')" class="dropdown-item text-info" ><i class="mdi mdi-account-switch mr-1"></i>দায়িত্ব হস্তান্তর</a>
                                               @endif
                                               <a href="{{ route('User/WorkingPermission',['id'=>$row->id]) }}" class="dropdown-item text-secondary" ><i class="mdi mdi-account-key mr-1"></i>কাজের অনুমতি</a>
                                               <a href="{{ route('User/ForwardPermission',['id'=>$row->id]) }}" class="dropdown-item text-primary" ><i class="mdi mdi-call-made mr-1"></i>ফরওয়ার্ডিং অনুমতি</a>
                                           @else
                                               <a href="{{ route('User/active', ['id'=>$row->id]) }}" class="dropdown-item text-success"><i class="far fa-check-circle"></i> সক্রিয়</a>
                                           @endif

{{--                                           <form action="{{ route('User/Delete', ['id'=>$row->id]) }}" method="post" id="confirm-form-alert-{{ $row->id }}">--}}
{{--                                               @csrf--}}
{{--                                               @method('delete')--}}
{{--                                               <button type="submit" class="dropdown-item text-danger" onclick="return ConfirmForm('confirm-form-alert-{{ $row->id }}');" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"><i class="mdi mdi-delete mr-1"></i>মুছে ফেলুন</button>--}}
{{--                                           </form>--}}
                                       </div>
                                   </div>
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                <nav class="float-right" aria-label="Page navigation example">
                    {{ $model -> links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
