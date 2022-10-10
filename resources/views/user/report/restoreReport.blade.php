@extends('layouts.master')
@section('title', 'আবেদন পুনরুদ্ধার রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50">আবেদন পুনরুদ্ধার রেজিস্টার</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">বাছাই করুন</span>
        </div>
        <div class="card-body">
            <form action="{{ route('report/RestoreReport') }}" class="form-row" autocomplete="off">
                <div class="input-group input-group-sm col-2 mb-1 pl-4">
                    <div class="input-group-prepend">
                        <label for="dateFrom" class="input-group-text"> তারিখ</label>
                    </div>
                    <input class="form-control form-control-sm datePicker" type="text" name="dateFrom" id="dateFrom" placeholder="dd/mm/yy" value="{{ request()->input('dateFrom') }}">
                </div>

                <div class="input-group input-group-sm col-2 mb-1">
                    <div class="input-group-prepend">
                        <label for="dateTo" class="input-group-text"> হইতে</label>
                    </div>
                    <input class="form-control form-control-sm datePicker" type="text" name="dateTo" id="dateTo" placeholder="dd/mm/yy" value="{{ request()->input('dateTo') }}">
                </div>

                <div class="input-group input-group-sm col-3 mb-1">
                    <div class="input-group-prepend">
                        <label for="dateTo" class="input-group-text"> আবেদন আইডি</label>
                    </div>
                    <input class="form-control form-control-sm" type="text" name="appId" id="appId"  value="{{ request()->input('appId') }}">
                </div>

                <div class="input-group input-group-sm col-3 mb-1">
                    <div class="input-group-prepend">
                        <label for="dateTo" class="input-group-text"> আবেদনের ধরন</label>
                    </div>
                    <select class="form-control form-control-sm" name="appType" id="appType">
                        <option value="">-সব-</option>
                        <option value="Normal" @if(request()->input('appType') == 'Normal') selected @endif>সাধারণ</option>
                        <option value="Emergency" @if(request()->input('appType') == 'Emergency') selected @endif>জরুরী</option>
                    </select>
                </div>

                <div class="col-2">
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> খুঁজুন </button>
                </div>
            </form>
        </div>
    </div>


    <div class="card mt-2 text-dark">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <span class="card-title">আবেদন পুনরুদ্ধার রিপোর্ট</span>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-secondary" onclick="Print('print_body')" type="button"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                </div>
            </div>
        </div>
        <div class="card-body" id="print_body">
            <div class="d-print-block d-none text-center">
                @include('user.inc.header') <!-- Header -->
                <strong>আবেদন পুনরুদ্ধার রিপোর্ট</strong>
            </div>
            <table class="table table-sm table-bordered table-hover text-dark">
                <thead>
                <tr>
                    <th class="text-center">ক্রমিক নং</th>
                    <th class="text-center">আবেদন আইডি</th>
                    <th class="text-center">আবেদনের ধরণ</th>
                    <th>আবেদনকারীর নাম</th>
                    <th class="text-center">পুনরুদ্ধারের তারিখ</th>
                    <th class="text-center">আগের মেয়াদ</th>
                    <th class="text-center">পরবর্তী মেয়াদ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($restores as $i => $restore)
                    <tr>
                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i)}}</td>
                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($restore->LetterIssue->application->app_id) }}</td>
                        <td class="text-center">
                            @if($restore->LetterIssue->application->app_type == 'Emergency')
                                <span class="bg-gray-300 px-2 text-danger"> জরুরী </span>
                            @else
                                <span>সাধারণ </span>
                            @endif
                        </td>
                        <td>{{ $restore->LetterIssue->application->user->name }}</td>
                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($restore->created_at))) }}</td>

                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($restore->old_expired_date))) }}</td>
                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($restore->new_expired_date))) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
