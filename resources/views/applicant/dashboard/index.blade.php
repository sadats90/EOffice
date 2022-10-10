@extends('applicant.layouts.master')
@section('title', 'ড্যাশবোর্ড')
@section('content')
    <p>ড্যাশবোর্ড</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-md-3">
            <a href="{{ route('applicant/applications/Index') }}">
                <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">মোট আবেদন</div>
                                <div class="h5 mb-0 text-dark">{{ \App\Http\Helpers\Helper::ConvertToBangla($total) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-sm-6 col-md-3">
            <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #858796!important">
                <div class="card-body">
                    <div class="row ">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">খালি আবেদন</div>
                            <div class="h5 mb-0 text-dark">{{ \App\Http\Helpers\Helper::ConvertToBangla($blank) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-md-3">
            <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #f6c23e!important">
                <div class="card-body">
                    <div class="row ">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">জমাকৃত আবেদন</div>
                            <div class="h5 mb-0 text-dark">{{ \App\Http\Helpers\Helper::ConvertToBangla($submit) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-md-3">
            <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #4e73df!important">
                <div class="card-body">
                    <div class="row ">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">প্রক্রিয়াধীন আবেদন</div>
                            <div class="h5 mb-0 text-dark">{{ \App\Http\Helpers\Helper::ConvertToBangla($process) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-md-3">
            <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #1cc88a!important">
                <div class="card-body">
                    <div class="row ">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">সম্পুর্ন আবেদন</div>
                            <div class="h5 mb-0 text-dark">{{ \App\Http\Helpers\Helper::ConvertToBangla($complete) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-md-3">
            <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #e74a3b!important">
                <div class="card-body">
                    <div class="row ">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">ব্যর্থ আবেদন</div>
                            <div class="h5 mb-0 text-dark">{{ \App\Http\Helpers\Helper::ConvertToBangla($fail) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-md-3">
            <a href="{{ route('applicant/letters') }}">
                <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">চিঠি</div>
                                <div class="h5 mb-0 text-dark">{{ \App\Http\Helpers\Helper::ConvertToBangla($letters) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-envelope-open-text fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
