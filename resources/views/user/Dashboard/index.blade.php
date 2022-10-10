@extends('layouts.master')

@section('title', 'ড্যাশবোর্ড')
@section('content')
    <p class="m-0 text-black-50">ড্যাশবোর্ড</p>
    <hr>
    <!-- Top Statistics -->
    @cannot('isInTask', 'admin')
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-md-3">
                <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">দৈনিক ফরওয়ার্ড আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($forward->daily) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-down fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-3">
                <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">মাসিক ফরওয়ার্ড আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($forward->monthly) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-down fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-3">
                <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">বার্ষিক ফরওয়ার্ড আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($forward->yearly) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-down fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-3">
                <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">মোট ফরওয়ার্ড আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($forward->total) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-down fa-2x text-info"></i>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">দৈনিক রিসিভ আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($receive->daily) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-up fa-2x text-success"></i>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">মাসিক রিসিভ আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($receive->monthly) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-up fa-2x text-success"></i>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">বার্ষিক রিসিভ আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($receive->yearly) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-up fa-2x text-success"></i>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">মোট রিসিভ আবেদন</div>
                                <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($receive->total) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-up fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcannot
    @can('isInTask', 'admin')
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-md-3">
            <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                <div class="card-body">
                    <div class="row ">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">মোট আবেদন</div>
                            <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($admin->total) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-info"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">নতুন আবেদন</div>
                            <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($admin->new) }}</div>
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
                            <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($admin->process) }}</div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">মোট সম্পুর্ন আবেদন</div>
                            <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($admin->complete) }}</div>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">মোট ব্যর্থ আবেদন</div>
                            <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($admin->fail) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-md-3">
            <div class="card mb-4 shadow py-2 p-2" style="border-left: .25rem solid #36b9cc!important">
                <div class="card-body">
                    <div class="row ">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">মোট ব্যবহারকারী</div>
                            <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($admin->users) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">মোট আবেদনকারী</div>
                            <div class="h5 mb-0 text-gray-800">{{ \App\Http\Helpers\Helper::ConvertToBangla($admin->applicants) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection
