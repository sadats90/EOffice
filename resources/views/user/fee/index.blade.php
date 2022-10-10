@extends('layouts.master')
@section('title', 'ফি সমুহ')
@section('content')
    <p class="m-0 text-black-50">ফি সমুহ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card card-default">
                <div class="card-body p-4">
                    @include('includes.message')
                    <form action="{{ route('Fee/Store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="application_fee" class="col-form-label-sm">আবেদন ফর্ম মূল্য</label>
                            <input type="text" name="application_fee" id="application_fee" value="{{ \App\Http\Helpers\Helper::ConvertToBangla($fee->application_fee) }}" required autofocus class="form-control-sm form-control @error('application_fee') is-invalid @enderror">
                            @error('application_fee')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emergency_fee" class="col-form-label-sm">জরুরী ফি</label>
                            <input type="text" name="emergency_fee" id="emergency_fee" value="{{ \App\Http\Helpers\Helper::ConvertToBangla($fee->emergency_fee) }}" required autofocus class="form-control-sm form-control @error('emergency_fee') is-invalid @enderror">
                            @error('emergency_fee')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="vat" class="col-form-label-sm">ভ্যাট</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="vat" id="vat" value="{{ \App\Http\Helpers\Helper::ConvertToBangla($fee->vat) }}" required autofocus class="form-control-sm form-control @error('vat') is-invalid @enderror">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            @error('vat')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i> সংরক্ষন করুন</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
