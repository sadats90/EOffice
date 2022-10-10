@extends('layouts.master')
@section('title', 'মৌজা/এলাকা তালিকা')
@section('content')
    <p class="m-0 text-black-50">মৌজা/এলাকা</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                মৌজা/এলাকা তালিকা
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('MouzaAreas/Create') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>মৌজা/এলাকা যোগ করুন</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ক্র নং</th>
                            <th class="text-center">মৌজা/এলাকা</th>
                            <th class="text-center">জে এল নং</th>
                            <th class="text-center">উপজেলা</th>
                            <th class="text-center">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php( $initialNumber = (($areas->currentPage() -1) * $areas->perPage())+1)
                       @foreach($areas as $row)
                           <tr>
                               <td class="text-center" style="width: 10%;">{{ \App\Http\Helpers\Helper::ConvertToBangla($initialNumber++) }}</td>
                               <td>{{ $row->name }}</td>
                               <td>{{ $row->jl_name }}</td>
                               <td>{{ $row->upazila->name }}</td>
                               <td class="text-right" style="width: 25%;">

                                   <form action="{{ route('MouzaAreas/Delete', ['id'=>$row->id]) }}" method="post" id="confirm-form-alert-{{ $row->id }}">
                                       @csrf
                                       <a href="{{ route('MouzaAreas/Edit',['id'=>$row->id]) }}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline mr-1"></i>সম্পাদন করুন</a>
                                       @method('delete')
                                       <button type="submit" class="btn btn-danger btn-sm" onclick="return ConfirmForm('confirm-form-alert-{{ $row->id }}');"><i class="mdi mdi-delete mr-1"></i> মুছে ফেলুন</button>
                                   </form>

                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                <nav class="float-right" aria-label="Page navigation example">
                    {{ $areas -> links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
