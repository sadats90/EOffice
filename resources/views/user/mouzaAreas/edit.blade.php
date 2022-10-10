@extends('layouts.master')
@section('title', 'মৌজা/এলাকা সম্পাদন')
@section('content')
    <p class="m-0 text-black-50">মৌজা/এলাকা সম্পাদন করুন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="offset-6">

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('MouzaAreas') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>মৌজা/এলাকা তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
          <div class="row">
                <div class="col-md-8 offset-2">
                  <form action="{{ route('MouzaAreas/Update',['id'=>$mouza->id]) }}" method="post">
                      @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label-sm">মৌজা/এলাকা</label>
                            <input type="text" name="name" id="name" value="{{ $mouza->name }}" required autofocus class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                      <div class="form-group">
                            <label for="jl_name" class="col-form-label-sm">জেএল নং</label>
                            <input type="text" name="jl_name" id="jl_name" value="{{ $mouza->jl_name }}" required class="form-control @error('jl_name') is-invalid @enderror">
                            @error('jl_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      <div class="form-group">
                          <label for="upazila_id" class="col-form-label-sm">উপজেলা</label>
                          <select class="form-control @error('upazila_id') is-invalid @enderror" name="upazila_id" id="upazila_id">
                              <option value="">-Select-</option>
                              @foreach($upazilas as $upazila)
                                  <option value="{{ $upazila->id }}" {{ $upazila->id == $mouza->upazila_id ? 'Selected' : '' }}>{{ $upazila->name }}</option>
                              @endforeach
                          </select>
                          @error('upazila_id')
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
