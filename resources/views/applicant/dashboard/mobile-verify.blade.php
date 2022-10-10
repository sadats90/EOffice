@extends('applicant.layouts.master')
@section('title', 'মোবাইল ভেরিফাই')
@section('content')
    <p>মোবাইল ভেরিফাই</p>
    <hr>
    <!-- Top Statistics -->
    @include('includes.message')
    <div class="row">
        @if(empty($user->mobile_verified_code))
            <div class="col-md-6 offset-3 mb-4 mt-5">
                <div class="card border-left-danger shadow h-100 p-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-10">
                                <div class="text-center text-xs font-weight-bold text-danger text-uppercase mb-1">আবেদনকারী মোবাইল যাচাইকরণ না !!</div>
                                <div class="text-center h5 mb-0 font-weight-bold text-gray-800">দয়া করে মোবাইল ভেরিফাই করুন</div>

                                <p class="text-center mt-3"><a href="{{ route('applicant/SendVerificationCode') }}" class="btn btn-primary">কোড পাঠান</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(empty($user->mobile_verified_at))
            <div class="col-md-6 offset-3 mb-4 mt-5">
                <div class="card border-left-success shadow h-100 p-3">
                    <div class="card-header" style="background:transparent;color: #858796;">
                        <h6 class="mb-0">মোবাইল ভেরিফিকেশন কোড</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <?php
                                $mobile = $user->mobile;
                                $hs = '********';
                                $last_digit = substr($mobile, -3);
                                $hidden_mobile = $hs.$last_digit;
                                ?>
                                <p class="mb-0">বার্তা প্রেরণ হয়েছে! {{ $hidden_mobile }}</p>
                                <form action="{{ route('applicant/VerifyCode') }}" method="post" autocomplete="off">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>ভেরিফিকেশন কোড </label>
                                        <input type="text" name="code" maxlength="6" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">ভেরিফাই</button>
                                </form>
                                <p class="mt-2">আপনি কি মেসেজ পাননি? <a href="{{ route('applicant/SendVerificationCode') }}">আবার প্রেরণ করুণ</a></p>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-right">
                                    <img src="{{ asset('images/mobile-verification-icon.png') }}" alt="Mobile Icon" height="150">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 offset-3 mb-4 mt-5">
                <div class="card border-left-success shadow h-100 p-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="text-success mt-5">মোবাইল ভেরিফাই করা সফল হয়েছে</h3>
                                <p class="mt-3"><a href="{{ url('/applicant/dashboard') }}">ড্যাশবোর্ডে ফিরে যান</a></p>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-right">
                                    <img src="{{ asset('images/mobile-vefified-icon.png') }}" alt="Mobile Icon" height="150">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
