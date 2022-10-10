@extends('layouts.master')
@section('title', 'জেলা সমূহ')
@section('content')
    <p class="m-0 text-black-50">জেলা</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                জেলার তালিকা
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('District/Create') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>জেলা যোগ করুন</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ক্র নং</th>
                            <th class="text-center">জেলা</th>
                            <th class="text-center">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php( $initialNumber = (($districts->currentPage() -1) * $districts->perPage())+1)
                       @foreach($districts as $district)
                           <tr>
                               <td class="text-center" style="width: 10%;">{{ $initialNumber++ }}</td>
                               <td>{{ $district->name }}</td>
                               <td class="text-right" style="width: 25%;">

                                   <form action="{{ route('District/Delete', ['id'=>$district->id]) }}" method="post" id="confirm-form-alert-{{ $district->id }}">
                                       @csrf
                                       <a href="{{ route('District/Edit',['id'=>$district->id]) }}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline mr-1"></i>সম্পাদন করুন</a>
                                       @method('delete')
                                       <button type="submit" class="btn btn-danger btn-sm" onclick="return ConfirmForm('confirm-form-alert-{{ $district->id }}');"><i class="mdi mdi-delete mr-1"></i> মুছে ফেলুন</button>
                                   </form>

                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                <nav class="float-right" aria-label="Page navigation example">
                    {{ $districts->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
