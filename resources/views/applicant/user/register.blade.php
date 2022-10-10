
@extends('layouts.app')
@section('title', 'রেজিস্টার')
@section('content')
<div class="container-fluid" style="background-image: radial-gradient(circle, red, #2e2f8d, #0253a0);">
<div class="container d-flex flex-column justify-content-between vh-100">
        <div class="row justify-content-center mt-5">
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-8">
                <div class="card">
                        <div class="card-header bg-primary">
                            <div class="app-brand">
                                <a href="{{ route('login') }}">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="45" height="45">
                                    <span class="brand-name" style="font-size: 25px">ইঅফিস ব্যবস্থাপনা</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body  pt-4 pr-4 pl-4 pb-2">
                            @if(!empty(session('success_msg')))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ session('success_msg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(!empty(session('error_msg')))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error_msg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(!empty(session('error')))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div id="accordion">
                                        <h5 data-toggle="collapse" data-target="#collapseErrorOne" aria-expanded="true" aria-controls="collapseErrorOne" style="border-bottom: solid 1px #999">
                                            Something Error! <button class="btn" style="text-align: right"> View <i class="fas fa-chevron-down"></i></button>
                                        </h5>
                                        <div id="collapseErrorOne" class="collapse" data-parent="#accordion">
                                            <div class="card">
                                                <div class="card-body">
                                                    {{ session('error') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <h4 class="text-dark mb-3">নিবন্ধন করুণ</h4>
                            <form method="post" action="{{ route('applicant/Store') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" class="form-control input-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus id="name" placeholder="নাম দিন">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <input id="email" type="email" class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="ই-মেইল দিন">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <input id="mobile" type="text" class="form-control input-lg @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required   placeholder="মোবাইল নং দিন">
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <input id="city" type="text" class="form-control input-lg @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required   placeholder="শহর">
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <input id="password" type="password" class="form-control input-lg @error('password') is-invalid @enderror" name="password" required  placeholder="পাসওয়ার্ড দিন">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <input id="password_confirm" type="password" class="form-control input-lg" name="password_confirm" required placeholder="নিশ্চিত পাসওয়ার্ড দিন">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="d-inline-block mr-3">
                                            <label class="control control-checkbox">
                                                <input type="checkbox"/><div class="control-indicator"></div>আমি শর্তাবলী সমূহে একমত
                                            </label>

                                        </div>
                                        <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">নিবন্ধন</button>
                                        <p> যদি আপনি নিবন্ধিত হয়ে থাকেন তাহলে, 
                                            <a class="text-blue" href="{{ route('login')  }}">প্রবেশ করুণ</a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-primary text-center text-white">
                            <p> কারিগরি সহায়তায়,
                                <a style="color: yellow" href="https://www.sunitltd.net" target="_blank">সান আইটি লিমিটেড</a>
                            </p>
                        </div>
                    </div>
                </div>
            <div class="col-md-2">&nbsp;</div>
        </div>
    </div>
</div>    
@endsection
