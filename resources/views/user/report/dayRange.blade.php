@extends('layouts.master')
@section('title', 'প্রেরন-গ্রহন রেজিস্টার')
@section('content')
    <p class="m-0 text-black-50">প্রেরন-গ্রহন ভিত্তিক রেজিস্টার</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card">
        <div class="card-header">বাছাই করুন</div>
        <div class="card-body">
            @include('includes.message')
            <div class="row">
                <div class="col-md-8 offset-2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">গ্রহন আবেদন রিপোর্ট</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">প্রেরণ আবেদন রিপোর্ট</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('report/dayRange/dayRangeReport') }}" method="post" class="mt-3" autocomplete="off">
                                @csrf
                                @cannot('isInTask', "admin")
                                    <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                                    <div class="form-group">
                                        <label for="receipient_id" class="col-form-label col-form-label-sm">রিসিপেন্ট</label>
                                        <select name="receipient_id" id="receipient_id" class="form-control form-control-sm" onchange="getUserInfo(this.value, 'designation', 'address')">
                                            <option value="">-সব-</option>
                                            @foreach($reciepients as $reciepient)
                                                <option value="{{ $reciepient->user_id }}">{{ $reciepient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="name" class="col-form-label col-form-label-sm">নাম  <span class="text-danger">*</span></label>
                                        <select name="user_id" id="name" required class="form-control form-control-sm" onchange="getReceipaint(this.value)">
                                            <option value="">-নির্বাচন-</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="receipient_id" class="col-form-label col-form-label-sm">রিসিপেন্ট</label>
                                        <select name="receipient_id" id="receipient_id" class="form-control form-control-sm" onchange="getUserInfo(this.value, 'designation', 'address')">
                                            <option value="">-সব-</option>
                                        </select>
                                    </div>
                                @endcannot
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm" id="designation" readonly value="">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm" id="address" readonly value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-1">
                                            <label for="date" class="col-form-label col-form-label-sm">তারিখ</label>
                                        </div>
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm datePicker" type="text" required name="date" placeholder="dd/mm/yyyy" >
                                                <div class="input-group-append">
                                                    <label for="date" class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <label for="to_date" class="col-form-label col-form-label-sm">থেকে</label>
                                        </div>
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm datePicker" type="text" required name="to_date" placeholder="dd/mm/yyyy">
                                                <div class="input-group-append">
                                                    <label for="to_date" class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-right">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-clipboard-list"></i> রিপোর্ট</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form action="{{ route('report/dayRange/forward') }}" method="post" class="mt-3" autocomplete="off">
                                @csrf
                                @cannot('isInTask', "admin")
                                    <input type="hidden" name="user_id_f" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                                    <div class="form-group">
                                        <label for="forward" class="col-form-label col-form-label-sm">ফরওয়ার্ড</label>
                                        <select name="forward" id="forward" class="form-control form-control-sm" onchange="getUserInfo(this.value, 'designation_f', 'address_f')">
                                            <option value="">-সব-</option>
                                            @foreach($forwarders as $forwarder)
                                                <option value="{{ $forwarder->permitted_user_id }}">{{ $forwarder->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="user_id_f" class="col-form-label col-form-label-sm">নাম  <span class="text-danger">*</span></label>
                                        <select name="user_id_f" id="user_id_f" required class="form-control form-control-sm" onchange="getForwardUser(this.value)">
                                            <option value="">-নির্বাচন-</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="forward" class="col-form-label col-form-label-sm">ফরওয়ার্ড</label>
                                        <select name="forward" id="forward" class="form-control form-control-sm" onchange="getUserInfo(this.value, 'designation_f', 'address_f')">
                                            <option value="">-সব-</option>
                                        </select>
                                    </div>
                                @endcannot
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm" id="designation_f" readonly value="">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm" readonly value="" id="address_f">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-1">
                                            <label for="date_f" class="col-form-label col-form-label-sm">তারিখ</label>
                                        </div>
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm datePicker" type="text" required name="date_f" id="date_f" placeholder="dd/mm/yyyy">
                                                <div class="input-group-append">
                                                    <label for="date_f" class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <label for="to_date_f" class="col-form-label col-form-label-sm">থেকে</label>
                                        </div>
                                        <div class="col">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control form-control-sm datePicker" type="text" required name="to_date_f" id="to_date_f" placeholder="dd/mm/yyyy">
                                                <div class="input-group-append">
                                                    <label for="to_date_f" class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-right">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-clipboard-list"></i> রিপোর্ট</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('user.inc.report_js') <!-- js code -->
@endsection
