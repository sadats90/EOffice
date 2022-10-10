@extends('layouts.master')
@section('title', 'উপজেলা সম্পাদন')
@section('content')
    <p class="m-0 text-black-50">উপজেলা সম্পাদন করুন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="offset-6">

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('Upazila') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>উপজেলা তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
          <div class="row">
                <div class="col-md-8 offset-2">
                  <form action="{{ route('Upazila/Update',['id'=>$upazila->id]) }}" method="post">
                      @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label-sm">থানা</label>
                            <input type="text" name="name" id="name" value="{{ $upazila->name }}" required autofocus class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      <div class="form-group">
                          <label for="district_id" class="col-form-label-sm">উপজেলা</label>
                          <select class="form-control @error('district_id') is-invalid @enderror" name="district_id" id="district_id">
                              <option value="">-Select-</option>
                              @foreach($districts as $district)
                                  <option value="{{ $district->id }}" {{ $district->id == $upazila->district_id ? 'Selected' : '' }}>{{ $district->name }}</option>
                              @endforeach
                          </select>
                          @error('district_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                      </div>
                      <div class="form-group text-right">
                         <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-edit mr-1"></i>সম্পাদন করুন</button>
                      </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
@endsection
