@extends('layouts.master')
@section('title', 'জমির ভবিষ্যত ব্যবহার সম্পাদন')
@section('content')
    <p class="m-0 text-black-50">জমির ভবিষ্যত ব্যবহার সম্পাদন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                জমির ভবিষ্যত ব্যবহার সম্পাদন
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('LandUseFuture') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>জমির ভবিষ্যত ব্যবহারের তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
          <div class="row">
                <div class="col-md-8 offset-2">
                  <form action="{{ route('LandUseFuture/Update', ['id'=>$model->id]) }}" method="post">
                      @csrf
                      <div class="form-group">
                          <label for="flut_name" class="col-form-label-sm">জমির ভবিষ্যত ব্যবহার<small class="text-danger">*</small></label>
                          <input type="text" name="flut_name" id="flut_name" value="{{ $model->flut_name }}" required autofocus class="form-control form-control-sm @error('flut_name') is-invalid @enderror">
                          @if ($errors->has('flut_name'))<small class="form-text text-danger">{{ $errors->first('flut_name') }}</small>@endif
                      </div>
                      <div class="form-group">
                          <label for="cost" class="col-form-label-sm">মূল্য<small class="text-danger">*</small></label>
                          <input type="text" name="cost" id="cost" value="{{ $model->cost }}" required  class="form-control form-control-sm @error('cost') is-invalid @enderror">
                          @if ($errors->has('cost'))<small class="form-text text-danger">{{ $errors->first('cost') }}</small>@endif
                      </div>

                      <div class="form-group text-right">
                         <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-square-edit-outline mr-1"></i>সম্পাদন করুন</button>
                      </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
@endsection
