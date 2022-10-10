@extends('layouts.master')
@section('title', 'প্রকল্প সম্পাদন')
@section('content')
    <p class="m-0 text-black-50">প্রকল্প সম্পাদন করুন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="offset-6">

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('Project') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>প্রকল্প তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
          <div class="row">
                <div class="col-md-8 offset-2">
                  <form action="{{route('Project/Update',['id'=>$project->id])}}" method="post">
                      @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label-sm">জেলার নামঃ</label>
                            <input type="text" name="name" id="name" value="{{ $project->name }}" required autofocus class="form-control-sm form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      <div class="form-group">
                          <label for="name" class="col-form-label-sm">প্রকল্প নামঃ</label>
                          <select name="project_type" id="project_type" class="form-control-sm form-control @error('project_type') is-invalid @enderror" required>
                              <option value="">নির্বাচন করুন</option>
                              <option value="1" {{ $project->project_type == 1 ? 'selected': '' }}>রাস্তার </option>
                              <option value="2" {{ $project->project_type == 2 ? 'selected': '' }}>আবাসিক/বাণিজ্যিক</option>
                          </select>
                          @error('project_type')
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
