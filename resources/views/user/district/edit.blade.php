@extends('layouts.master')
@section('title', 'জেলা সম্পাদন')
@section('content')
    <p class="m-0 text-black-50">জেলা সম্পাদন করুন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="offset-6">

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('District') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>জেলা তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
          <div class="row">
                <div class="col-md-8 offset-2">
                  <form action="{{route('District/Update',['id'=>$district->id])}}" method="post">
                      @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label-sm">জেলার নামঃ</label>
                            <input type="text" name="name" id="name" value="{{ $district->name }}" required autofocus class="form-control-sm form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      <div class="form-group text-right">
                         <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>সম্পাদন করুন</button>
                      </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
@endsection
