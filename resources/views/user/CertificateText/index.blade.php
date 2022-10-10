@extends('layouts.master')
@section('title', 'এনওসি সনদপত্রের শর্তাদি সমুহ')
@section('content')
    <p class="m-0 text-black-50">এনওসি সনদপত্রের শর্তাদি সমুহ </p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">এনওসি সনদপত্রের শর্তাদি সমুহ</div>
            <div class="col-md-6 text-right">
                <a href="{{ route('CertificateText/Create') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>সনদপত্রের শর্তাদি যোগ করুন</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ক্র নং</th>
                            <th class="text-center">শিরোনাম</th>
                            <th class="text-center">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php( $initialNumber = (($certificate_text->currentPage() -1) * $certificate_text->perPage())+1)

                    @foreach($certificate_text as $item)
                           <tr>
                               <td class="text-center" style="width: 10%;">{{ \App\Http\Helpers\Helper::ConvertToBangla($initialNumber++) }}</td>
                               <td>{{ $item->title }}</td>
                               <td class="text-right" style="width: 25%;">

                                   <form action="{{ route('CertificateText/Delete', ['id'=>$item->id]) }}" method="post" id="confirm-form-alert-{{ $item->id }}">
                                       @csrf
                                       <a href="{{ route('CertificateText/Edit',['id'=>$item->id]) }}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline mr-1"></i>সম্পাদন করুন</a>
                                       @method('delete')
                                       <button type="submit" class="btn btn-danger btn-sm" onclick="return ConfirmForm('confirm-form-alert-{{ $item->id }}');"><i class="mdi mdi-delete mr-1"></i> মুছে ফেলুন</button>
                                   </form>

                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                <nav class="float-right" aria-label="Page navigation example">
                    {{ $certificate_text->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
