@extends('applicant.layouts.master')
@section('title', 'আবেদন ট্র্যাক')
@section('content')
    <p>আবেদন ট্র্যাক</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card p-2">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    আবেদন ট্র্যাক
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                    <a href="{{ route('applicant/applications/Index') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-alt-circle-up"></i> Applications</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @php($sl = 0)
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="card mb-2 mt-2 shadow" style="border-top: .25rem solid #1cc88a!important; border: 1px solid #1cc88a; font-size: 12px;">
                        <div class="card-header m-0 p-2">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                    <div class="tracking-number" >{{ ++$sl }}</div>
                                </div>
                                <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                    <span class="pt-2">Buy & Payment (Applicant)</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table-sm table table-borderless p-0 m-0">
                                <tr>
                                    <td class="text-right" style="max-width: 35%">পরিশোধের তারিখ:</td>
                                    <td style="width: 65%; color: #1cc88a;"> {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($application->form_buy_date))) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="max-width: 35%">মূল্য:</td>
                                    <td style="width: 65%; color: #1cc88a;"> {{ \App\Http\Helpers\Helper::ConvertToBangla($application->form_buy_price) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="max-width: 35%">অর্থ প্রদানের মাধ্যম:</td>
                                    <td style="width: 65%; color: #1cc88a;"> {{ $application->payment_method }}</td>
                                </tr>
                                <tr class="m-0">
                                    <td class="text-right" style="max-width: 35%">ট্রানজেকশন আইডি:</td>
                                    <td style="width: 65%; color: #1cc88a;"> {{ $application->trxn_id }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="card mb-2 mt-2 shadow" @if($application->is_submit == 1) style="border-top: .25rem solid #1cc88a !important; border: 1px solid #1cc88a; font-size: 12px;" @else style="border-top: .25rem solid #f6c23e !important; border: 1px solid #f6c23e; font-size: 12px;" @endif>
                        <div class="card-header m-0 p-2">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                    <div class="tracking-number" >{{ ++$sl }}</div>
                                </div>
                                <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                    <span class="pt-2">Application Submission (Applicant)</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table-sm table table-borderless p-0 m-0">
                                <tr>
                                    <td class="text-right" style="max-width: 35%">Personal Info:</td>
                                    <td style="width: 65%;" class="text-success">
                                        @if(!empty($application->personalInfo->created_at))
                                        {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($application->personalInfo->created_at))) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="max-width: 35%">Land Info:</td>
                                    <td style="width: 65%;" class="text-success">
                                        @if(!empty($application->landInfo->created_at))
                                            {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($application->personalInfo->created_at))) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="max-width: 35%">Documents:</td>
                                    <td style="width: 65%;" class="text-success">
                                        @if(!empty($application->documents->first()))
                                            {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($application->documents->first()->created_at))) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="max-width: 35%">Final Form Submission:</td>
                                    <td style="width: 65%;" class="text-success">
                                        @if(!empty($application->is_submit == 1))
                                            {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($application->submission_date))) }}
                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

                @foreach($application->application_routes as $routes)
                    @if($routes->is_verified == 1)
                        <div class="col-xl-4 col-sm-6 col-md-4">
                            <div class="card mb-2 mt-2 shadow" style="border-top: .25rem solid #1cc88a!important; border: 1px solid #1cc88a; font-size: 12px;">
                                <div class="card-header m-0 p-2">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                            <div class="tracking-number" >{{ ++$sl }}</div>
                                        </div>
                                        <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                            <span class="pt-2">{{ $routes->to_user->designation->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table-sm table table-borderless p-0 m-0">
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">In Date:</td>
                                            <td style="width: 65%;" class="text-success"> {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($routes->in_date))) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">Out Date:</td>
                                            <td style="width: 65%;" class="text-success"> {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($routes->out_date))) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">Status:</td>
                                            <td style="width: 65%;" class="text-success">Verified</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif($routes->is_fail == 1)
                        <div class="col-xl-4 col-sm-6 col-md-4">
                            <div class="card mb-2 mt-2 shadow" style="border-top: .25rem solid #e74a3b!important; border: 1px solid #e74a3b; font-size: 12px;">
                                <div class="card-header m-0 p-2">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                            <div class="tracking-number" >{{ ++$sl }}</div>
                                        </div>
                                        <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                            <span class="pt-2">{{ $routes->to_user->designation->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table-sm table table-borderless p-0 m-0">
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">In Date:</td>
                                            <td style="width: 65%;" class="text-danger">
                                                @if(!empty($routes->in_date))
                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($routes->in_date))) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">Out Date:</td>
                                            <td style="width: 65%;" class="text-danger">
                                                @if(!empty($routes->out_date))
                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($routes->out_date))) }}
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">Status:</td>
                                            <td style="width: 65%;" class="text-danger">Failed</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-xl-4 col-sm-6 col-md-4">
                            <div class="card mb-2 mt-2 shadow" style="border-top: .25rem solid #f6c23e!important; border: 1px solid #f6c23e; font-size: 12px;">
                                <div class="card-header m-0 p-2">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                            <div class="tracking-number" >{{ ++$sl }}</div>
                                        </div>
                                        <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                            <span class="pt-2">{{ $routes->to_user->designation->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table-sm table table-borderless p-0 m-0">
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">In Date:</td>
                                            <td style="width: 65%;" class="text-warning">
                                                @if(!empty($routes->in_date))
                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($routes->in_date))) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">Out Date:</td>
                                            <td style="width: 65%;" class="text-warning">
                                                @if(!empty($routes->out_date))
                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($routes->out_date))) }}
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" style="max-width: 35%">Status:</td>
                                            <td style="width: 65%;" class="text-warning">Process</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if(count($application->letter_issues) > 0)
                    @foreach($application->letter_issues as $letter)
                        @if($letter->is_issued == 1 && $letter->is_solved == 0 )
                            <div class="col-xl-4 col-sm-6 col-md-4">
                                <div class="card mb-2 mt-2 shadow" style="border-top: .25rem solid #f6c23e!important; border: 1px solid #f6c23e; font-size: 12px;">
                                    <div class="card-header m-0 p-2">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                                <div class="tracking-number" >{{ ++$sl }}</div>
                                            </div>
                                            <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                                <span class="pt-2">Letter Issue</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table-sm table table-borderless p-0 m-0">
                                            <tr>
                                                <td class="text-right" style="max-width: 35%">Letter Type:</td>
                                                <td style="width: 65%;" class="text-warning">
                                                  {{ $letter->letterType->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" style="max-width: 35%">Issue Date:</td>
                                                <td style="width: 65%;" class="text-warning">
                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($letter->issue_date))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" style="max-width: 35%">Expired Date:</td>
                                                <td style="width: 65%;" class="text-warning">
                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($letter->expired_date))) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" style="max-width: 35%">Status:</td>
                                                <td style="width: 65%;" class="text-warning">
                                                   Process
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
                @if($application->is_certificate_make == 1 && $application->is_complete == 0)
                    <div class="col-xl-4 col-sm-6 col-md-4">
                        <div class="card mb-2 mt-2 shadow" style="border-top: .25rem solid #f6c23e!important; border: 1px solid #f6c23e">
                            <div class="card-header m-0 p-2">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                        <div class="tracking-number" >{{ ++$sl }}</div>
                                    </div>
                                    <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                        <span class="pt-2">Certificate</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table-sm table table-borderless p-0 m-0">
                                    <tr>
                                        <td class="text-right" style="max-width: 35%">Created Date:</td>
                                        <td style="width: 65%;" class="text-warning">
                                            {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($application->certificate->created_at))) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" style="max-width: 35%">Issue Date:</td>
                                        <td style="width: 65%;" class="text-warning">
                                            @if(!empty($application->certificate->issue_date))
                                                {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime($application->certificate->issue_date))) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" style="max-width: 35%">Status:</td>
                                        <td style="width: 65%;">
                                           @if($application->certificate->is_issue == 1)
                                               <span class="text-success"> Certificate Ready</span>
                                           @else
                                                <span class="text-success"> Certificate Created</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                @if($application->is_complete == 1)
                    <div class="col-xl-4 col-sm-6 col-md-4">
                        <div class="card mb-2 mt-2 shadow " style="border-top: .25rem solid #1cc88a!important; border: 1px solid #1cc88a; font-size: 12px;">
                            <div class="card-header m-0 p-2">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-lg-2 text-right">
                                        <div class="tracking-number" >{{ ++$sl }}</div>
                                    </div>
                                    <div class="col-sm-10 col-md-10 col-lg-10 text-left" style="text-align: center;">
                                        <span class="pt-2">Complete Message</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                               <h3 class="text-success mt-4 mb-5">Application Complete</h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
