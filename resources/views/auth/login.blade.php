
@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-image: linear-gradient(15deg, white, #2e2f8d);">
    <div class="container d-flex flex-column justify-content-between vh-100">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-10">
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="app-brand">
                            <a href="{{route('login')}}">
                                <img src="{{asset('assets/img/logo.png')}}" alt="logo" width="45" height="45">
                                <span class="brand-name mt-2 pl-2" style="font-size: 25px">ইঅফিস ব্যবস্থাপনা</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-4 pr-4 pl-4 pb-2">
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
                        <h4 class="text-dark mb-3">প্রবেশ করুণ</h4>
                        <form action="{{ route('login') }}" method="post">
                            @csrf

                            {{-- <div class="row">
                                <div class="form-group col-md-12 mb-4">
                                    <input type="email" class="form-control input-lg  @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="ব্যবহারকারীর নাম দিন">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}



                                <div class="form-group col-md-12 mb-4">
                                    <input type="number" class="form-control input-lg  @error('mobile') is-invalid @enderror" name="mobile" id="mobile" value="{{ old('mobile') }}" required autofocus placeholder="ব্যবহারকারীর number দিন">

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group col-md-12 ">
                                    <input type="password" class="form-control input-lg @error('password') is-invalid @enderror" name="password" id="password" placeholder="পাসওয়ার্ড দিন">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex my-2 justify-content-between">
                                        <div class="d-inline-block mr-3">
                                            <label class="control control-checkbox">মনে রাখবেন কি?
                                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/><div class="control-indicator"></div>
                                            </label>
                                        </div>
                                        <p><a class="text-blue" href="{{ route('password.request') }}">পাসওয়ার্ড ভুলে গেছেন?</a></p>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">প্রবেশ করুণ</button>
                                    <p>এখনও কোনো একাউন্ট নেই?
                                        <a class="text-blue" href="{{ route('applicant/Register') }}">নিবন্ধন করুণ</a>
                                    </p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>সহায়তা নিন</p>
                                        </div>
                                        <div class="col-md-6">
                                            <i class="mdi mdi-email"></i> <a class="text-blue" href="mailto:supports@sunitltd.net">supports@sunitltd.net</a>
                                        </div>
                                        <div class="col-md-6">
                                            <i class="mdi mdi-cellphone"></i> <a class="text-blue text-right" href="tel:+8801749608171">+88 01749 60 81 71</a>
                                        </div>
                                    </div>
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
        </div>
    </div>
</div>
@endsection
