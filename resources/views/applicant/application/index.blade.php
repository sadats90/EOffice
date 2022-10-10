@extends('applicant.layouts.master')
@section('title', 'আবেদনের বিস্তারিত')
@section('content')
    <p>আবেদনের বিস্তারিত</p> <hr>
    @include('includes.message')
    <div class="card">
        <div class="card-header p-3">
            <div class="row">
                <div class="col-md-6">আবেদন পত্র সমূহ</div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('applicant/application/Buy') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-cart mr-1"></i>ফরম ক্রয় করুন</a>
                </div>
            </div>
        </div>
        <div class="card-body pt-0 mr-1 pl-3">

            <table class="table table-sm table-responsive">
                <thead>
                <tr>
                    <th scope="col" class="text-center">ক্র নং</th>
                    <th scope="col" class="text-center">আবেদন আইডি</th>
                    <th scope="col" class="text-center">ক্রয়ের তাং</th>
                    <th scope="col" class="text-center">আবেদনের ধরণ</th>
                    <th scope="col" class="text-center">জমাদানের অবস্থা</th>
                    <th scope="col" class="text-center">সম্পূর্ণের অবস্থা</th>
                    <th scope="col" class="text-right">অবস্থা</th>
                </tr>
                </thead>
                <tbody>
                @foreach($model as $row)
                    <tr>
                        <td scope="row" class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }}</td>
                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($row->app_id) }}</td>
                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($row->form_buy_date))) }}</td>
                        <td class="text-center">{{ $row->app_type == 'Normal' ? 'সাধারণ' : 'জরুরী'}}</td>
                        <td class="text-center">
                            @if($row->is_submit == 1)
                                <span style="color: #009E0F;font-weight: 800">জমা হয়েছে</span>
                            @else
                                <span style="color: #CF2A27;font-weight: 800">জমা হয়নি</span>
                            @endif
                            @if($row->is_submit == 0)
                                @if($row->is_personal_info == 1 && $row->is_land_info == 1  && $row->is_document_info == 1 )
                                    <form action="{{ route('applicant/applications/submit', ['app_id' => encrypt($row->id)]) }}" method="POST" style="display: inline">
                                        @csrf
                                        |<button type="submit" style="border: none;background-color: #fff;"><span style="color: #2B78E4;font-weight: 800">জমা দিন</span></button>
                                    </form>
                                @endif
                            @endif
                            @if($row->is_personal_info == 0 || $row->is_land_info == 0  || $row->is_document_info == 0 )
                                / <span style="color: #CF2A27;font-weight: 800">অসম্পূর্ণ আবেদন</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($row->is_complete == 1)
                                <span style="color: #009E0F;font-weight: 800">সম্পূর্ণ আবেদন</span>
                            @else
                                <span style="color: #CF2A27;font-weight: 800">আবেদন প্রক্রিয়াধীন</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="dropdown show">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                    কার্যক্রম
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if($row->is_submit == 1)
                                        <a class="dropdown-item" href="{{ route('applicant/applications/viewDetails', ['id' => encrypt($row->id)]) }}"><i class="mdi mdi-desktop-mac"></i> বিস্তারিত দেখুন</a>
                                        @if($row->is_complete == 1)
                                            <a class="dropdown-item" href="{{ route('applicant/applications/correctionRequest', ['id' => encrypt($row->id)]) }}"><i class="mdi mdi-subdirectory-arrow-right"></i> সংশোধনের অনুরোধ</a>
                                        @endif
                                    @endif
                                    <a class="dropdown-item" href="{{route('applicant/applications/Form', ['id' =>  encrypt($row->id)])}}"><i class="mdi mdi-file-alert-outline"></i> আবেদন পূরণ করুণ</a>
{{--                                    <a class="dropdown-item" href="{{ route('applicant/applications/trackResult', ['id' => $row->app_id]) }}"><i class="mdi mdi-comment-search-outline"></i> ট্র্যাক করুণ</a>--}}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
