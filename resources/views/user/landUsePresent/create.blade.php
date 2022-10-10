@extends('layouts.master')
@section('title', 'জমির বর্তমান অবস্থা যোগ')
@section('content')
    <p class="m-0 text-black-50">জমির বর্তমান অবস্থা যোগ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                জমির বর্তমান অবস্থা যোগ করুন
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('LandUseFuture') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>জমির ভবিষ্যত ব্যবহারের তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
          <div class="row">
                <div class="col-md-8 offset-2">
                  <form action="{{ route('LandUsePresent/Store') }}" method="post">
                      @csrf
                        <div class="form-group">
                            <label for="plut_name" class="col-form-label-sm">জমির বর্তমান অবস্থা<small class="text-danger">*</small></label>
                            <input type="text" name="plut_name" id="plut_name" value="{{ old('plut_name') }}" required autofocus class="form-control form-control-sm @error('plut_name') is-invalid @enderror">
                            @if ($errors->has('plut_name'))<small class="form-text text-danger">{{ $errors->first('plut_name') }}</small>@endif
                        </div>

                      <div class="form-group text-right">
                         <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>যোগ করুন</button>
                      </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
@endsection
