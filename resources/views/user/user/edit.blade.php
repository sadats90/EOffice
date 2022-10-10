@extends('layouts.master')
@section('title', 'ব্যবহারকারীকে সম্পাদন')
@section('content')
    <p class="m-0 text-black-50">ব্যবহারকারীকে সম্পাদন করুন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="offset-6">

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('User') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>ব্যবহারকারীর তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
          <div class="row">
                <div class="col-md-12">
                  <form action="{{ route('User/Update', ['id'=>$model->id]) }}" method="post" class="form-row" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group col-md-4">
                          <label for="name" class="col-form-label-sm">নাম <small class="text-danger">*</small></label>
                          <input type="text" name="name" id="name" value="{{ $model->name }}" required autofocus class="form-control form-control-sm @error('name') is-invalid @enderror">
                          @if ($errors->has('name'))<small class="form-text text-danger">{{ $errors->first('name') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="name_en" class="col-form-label-sm">নাম (In english)<small class="text-danger">*</small></label>
                          <input type="text" name="name_en" id="name_en" value="{{ $model->userDetails->en_name }}" required autofocus class="form-control form-control-sm @error('name_en') is-invalid @enderror">
                          @if ($errors->has('name_en'))<small class="form-text text-danger">{{ $errors->first('name_en') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="designation_id" class="col-form-label-sm">পদবী<small class="text-danger">*</small></label>
                          <select class="form-control form-control-sm @error('designation_id') is-invalid @enderror" name="designation_id" id="designation_id">
                              <option value="">-নিবাচন করুণ-</option>
                              @foreach($designations as $designation)
                                  <option value="{{ $designation->id }}" {{ $designation->id == $model->designation_id ? 'Selected' : '' }}>{{ $designation->name }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('designation_id'))<small class="form-text text-danger">{{ $errors->first('designation_id') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="address" class="col-form-label-sm">অফিসের ঠিকানা <small class="text-danger">*</small></label>
                          <textarea rows="1" name="address" id="address" required class="form-control form-control-sm @error('address') is-invalid @enderror">{{ $model->address }}</textarea>
                          @if ($errors->has('address'))<small class="form-text text-danger">{{ $errors->first('address') }}</small>@endif

                      </div>
                      <div class="form-group col-md-4">
                          <label for="mobile" class="col-form-label-sm">মোবাইল নং <small class="text-danger">*</small></label>
                          <input type="text" name="mobile" id="mobile" value="{{ $model->mobile }}" required  class="form-control form-control-sm @error('mobile') is-invalid @enderror">
                          @if ($errors->has('mobile'))<small class="form-text text-danger">{{ $errors->first('mobile') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="father_bn" class="col-form-label-sm">পিতার নাম<small class="text-danger">*</small></label>
                          <input type="text" name="father_bn" id="father_bn" value="{{ $model->userDetails->father_bn  }}" required  class="form-control form-control-sm @error('father_bn') is-invalid @enderror">
                          @if ($errors->has('father_bn'))<small class="form-text text-danger">{{ $errors->first('father_bn') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="father_en" class="col-form-label-sm">পিতার নাম (In English)<small class="text-danger">*</small></label>
                          <input type="text" name="father_en" id="father_en" value="{{ $model->userDetails->father_en }}" required  class="form-control form-control-sm @error('father_en') is-invalid @enderror">
                          @if ($errors->has('father_en'))<small class="form-text text-danger">{{ $errors->first('father_en') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="mother_bn" class="col-form-label-sm">মাতার নাম<small class="text-danger">*</small></label>
                          <input type="text" name="mother_bn" id="mother_bn" value="{{ $model->userDetails->mother_bn }}" required  class="form-control form-control-sm @error('mother_bn') is-invalid @enderror">
                          @if ($errors->has('mother_bn'))<small class="form-text text-danger">{{ $errors->first('mother_bn') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="mother_en" class="col-form-label-sm">মাতার নাম (In English)<small class="text-danger">*</small></label>
                          <input type="text" name="mother_en" id="mother_en" value="{{ $model->userDetails->mother_en }}" required  class="form-control form-control-sm @error('mother_en') is-invalid @enderror">
                          @if ($errors->has('mother_en'))<small class="form-text text-danger">{{ $errors->first('mother_en') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="date_of_birth" class="col-form-label-sm">জন্ম তারিখ<small class="text-danger">*</small></label>
                          <input type="date" name="date_of_birth" id="date_of_birth" value="{{ $model->userDetails->date_of_birth }}" required  class="form-control form-control-sm @error('date_of_birth') is-invalid @enderror">
                          @if ($errors->has('date_of_birth'))<small class="form-text text-danger">{{ $errors->first('date_of_birth') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="nid_no" class="col-form-label-sm">পরিচয় পত্র নং <small class="text-danger">*</small></label>
                          <input type="text" name="nid_no" id="nid_no" value="{{ $model->userDetails->nid_no }}" required  class="form-control form-control-sm @error('nid_no') is-invalid @enderror">
                          @if ($errors->has('nid_no'))<small class="form-text text-danger">{{ $errors->first('nid_no') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="gender" class="col-form-label-sm">লিঙ্গ <small class="text-danger">*</small></label>
                          <select name="gender" id="gender" required  class="form-control form-control-sm @error('gender') is-invalid @enderror">
                              <option value="">-নির্বাচন করুন-</option>
                              <option value="পুরুষ" {{ "পুরুষ" == $model->userDetails->gender ? 'Selected' : '' }}>পুরুষ</option>
                              <option value="মহিলা" {{ "মহিলা" == $model->userDetails->gender ? 'Selected' : '' }}>মহিলা</option>
                          </select>
                          @if ($errors->has('gender'))<small class="form-text text-danger">{{ $errors->first('gender') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="religion" class="col-form-label-sm">ধর্ম<small class="text-danger">*</small></label>
                          <select class="form-control form-control-sm @error('religion') is-invalid @enderror" name="religion" id="religion">
                              <option value="">-নিবাচন করুণ-</option>
                              @foreach($religions as $religion)
                                  <option value="{{ $religion->name }}" {{ $religion->name == $model->userDetails->religion ? 'Selected' : '' }}>{{ $religion->name }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('religion'))<small class="form-text text-danger">{{ $errors->first('religion') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="blood_group" class="col-form-label-sm">রক্তের গ্রুপ</label>
                          <select class="form-control form-control-sm @error('blood_group') is-invalid @enderror" name="blood_group" id="blood_group">
                              <option value="">-নিবাচন করুণ-</option>
                              @foreach($bloodGroups as $bloodGroup)
                                  <option value="{{ $bloodGroup->name }}" {{ $bloodGroup->name == $model->userDetails->bloodGroup ? 'Selected' : '' }}>{{ $bloodGroup->name }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('blood_group'))<small class="form-text text-danger">{{ $errors->first('blood_group') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="marital_status" class="col-form-label-sm">বৈবাহিক অবস্থা<small class="text-danger">*</small></label>
                          <select name="marital_status" id="marital_status" required  class="form-control form-control-sm @error('marital_status') is-invalid @enderror">
                              <option value="">-নির্বাচন করুন-</option>
                              <option value="বিবাহিত" {{ "বিবাহিত" == $model->userDetails->martial_status ? 'Selected' : '' }}>বিবাহিত</option>
                              <option value="অবিবাহিত" {{ "অবিবাহিত" == $model->userDetails->martial_status ? 'Selected' : '' }}>অবিবাহিত</option>
                          </select>
                          @if ($errors->has('marital_status'))<small class="form-text text-danger">{{ $errors->first('marital_status') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="twitter_link" class="col-form-label-sm">টুইটারের লিঙ্ক</label>
                          <input type="text" name="twitter_link" id="twitter_link" value="{{ $model->userDetails->twitter_link }}" class="form-control form-control-sm @error('twitter_link') is-invalid @enderror" placeholder="http://">
                      </div>
                      <div class="form-group col-md-4">
                          <label for="linkedin_link" class="col-form-label-sm">লিঙ্কডিনের লিঙ্ক</label>
                          <input type="text" name="linkedin_link" id="linkedin_link" value="{{ $model->userDetails->linkedin_link }}" class="form-control form-control-sm @error('linkedin_link') is-invalid @enderror" placeholder="http://">

                      </div>
                      <div class="form-group col-md-4">
                          <label for="facebook_link" class="col-form-label-sm">ফেসবুকের লিঙ্ক</label>
                          <input type="text" name="facebook_link" id="facebook_link" value="{{ $model->userDetails->facebook_link }}"  class="form-control form-control-sm @error('facebook_link') is-invalid @enderror" placeholder="http://">

                      </div>
                      <div class="form-group col-md-4">
                          <label for="skypee_link" class="col-form-label-sm">স্কাইপি এর লিঙ্ক</label>
                          <input type="text" name="skypee_link" id="skypee_link" value="{{ $model->userDetails->skypee_link }}" class="form-control form-control-sm @error('skypee_link') is-invalid @enderror" placeholder="live:">

                      </div>
                      <div class="form-group col-md-4">
                          <label for="email" class="col-form-label-sm">ই-মেইল<small class="text-danger">*</small></label>
                          <input type="email" name="email" id="email" value="{{ $model->email }}" required  class="form-control form-control-sm @error('email') is-invalid @enderror" disabled>
                          @if ($errors->has('email'))<small class="form-text text-danger">{{ $errors->first('email') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="image" class="col-form-label-sm">ছবি<small class="text-danger">*</small></label>
                          <input type="file" name="image" id="image"  class="form-control form-control-sm @error('image') is-invalid @enderror">
                          @if ($errors->has('image'))<small class="form-text text-danger">{{ $errors->first('image') }}</small>@endif
                      </div>
                      <div class="form-group col-md-4">
                          <label for="signature" class="col-form-label-sm">স্বাক্ষর<small class="text-danger">*</small></label>
                          <input type="file" name="signature" id="signature" class="form-control form-control-sm @error('signature') is-invalid @enderror">
                          @if ($errors->has('signature'))<small class="form-text text-danger">{{ $errors->first('signature') }}</small>@endif
                      </div>
                      <div class="form-group text-right col-md-12">
                         <button type="submit" class="btn btn-primary"><i class="mdi mdi-square-edit-outline mr-1"></i>সম্পাদন করুন</button>
                      </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
@endsection
