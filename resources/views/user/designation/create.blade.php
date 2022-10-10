@extends('layouts.master')
@section('title', 'পদবী যোগ করুন')
@section('content')
    <p class="m-0 text-black-50">পদবী যোগ করুন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="offset-6">

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('Designation') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>পদবীর তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
          <div class="row">
                <div class="col-md-8 offset-2">
                  <form action="{{ route('Designation/Store') }}" method="post">
                      @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label-sm">পদবী<small class="text-danger">*</small></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"  class="form-control form-control-sm @error('name') is-invalid @enderror">
                            @if ($errors->has('name'))<small class="form-text text-danger">{{ $errors->first('name') }}</small>@endif
                        </div>

                      <div class="form-group">
                            <label for="priority" class="col-form-label-sm">অগ্রাধিকার<small class="text-danger">*</small></label>
                            <input type="number" name="priority" id="priority" value="{{ old('priority') }}"  class="form-control form-control-sm @error('priority') is-invalid @enderror">
                            @if ($errors->has('priority'))<small class="form-text text-danger">{{ $errors->first('priority') }}</small>@endif
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
