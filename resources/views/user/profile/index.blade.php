@extends('layouts.master')
@section('title', 'প্রোফাইল')
@section('content')
    <div class="bg-white border rounded">
        <div class="row no-gutters">
            <div class="col-lg-4 col-xl-3">
                <div class="profile-content-left p-2">
                    <div class="card text-center widget-profile px-0 border-0">
                        <div class="card-img mx-auto rounded-circle">
                            <img src="{{ asset($model->photo)}}" alt="user image" height="100" width="100">
                        </div>
                        <div class="card-body text-center">
                            <h4 class="py-2 text-dark">{{ $model->name }}</h4>
                            <p>{{$model->designation->name}}</p>
                            <p>{{ $model->address}}</p>
                        </div>
                    </div>
                    <hr class="w-100">
                    <div class="contact-info pt-4">
                        <h5 class="text-dark mb-1">যোগাযোগঃ</h5>
                        <p class="text-dark font-weight-medium pt-4 mb-2">ইমেইলঃ {{ $model->email }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">ফোনঃ {{ $model->mobile }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">সামাজিক যোগাযোগঃ</p>
                        <p class="pb-3 social-button">
                            <a href="//{{ $model->userDetails->twitter_link }}" class="mb-1 btn btn-outline btn-twitter rounded-circle">
                                <i class="mdi mdi-twitter"></i>
                            </a>
                            <a href="//{{ $model->userDetails->linkedin_link }}" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                                <i class="mdi mdi-linkedin"></i>
                            </a>
                            <a href="//{{ $model->userDetails->facebook_link }}" class="mb-1 btn btn-outline btn-facebook rounded-circle">
                                <i class="mdi mdi-facebook"></i>
                            </a>
                            <a href="//{{ $model->userDetails->skypee_link }}" class="mb-1 btn btn-outline btn-skype rounded-circle">
                                <i class="mdi mdi-skype"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="profile-content-right py-5">
                    <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="timeline-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">প্রোফাইল তথ্য</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#passchange" role="tab" aria-controls="passchange" aria-selected="false">পাসওয়ার্ড পরিবর্তন</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#picchange" role="tab" aria-controls="picchange" aria-selected="false">ছবি পরিবর্তন</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#sigchange" role="tab" aria-controls="sigchange" aria-selected="false">স্বাক্ষর পরিবর্তন</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">সেটিংস</a>
                        </li>
                    </ul>
                    <div class="tab-content px-3 px-xl-2" id="myTabContent">
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="timeline-tab">
                            <div class="row pt-3 pr-3 pl-3">
                                <div class="col-sm-12">
                                    @include('includes.message')
                                </div>
                                <div class="col-sm-2">
                                    <a href="javascript:void(0)" onclick="showInfo()"><i class="fas fa-user"></i> প্রোফাইল তথ্য</a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="javascript:void(0)" onclick="getEditTemplate()"> <i class="fas fa-user-edit"></i> প্রোফাইল তথ্য সম্পাদন</a>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <a href="{{ route('Dashboard') }}"><i class="mdi mdi-view-dashboard"></i> ড্যাশবোর্ড</a>
                                </div>
                            </div>
                            <div class="media mt-2 profile-timeline-media">
                                <div class="media-body ml-5" id="info">
                                    <p>নামঃ </p>
                                    <div class="row mt-4">
                                        <div class="col-md-6">বাংলায়ঃ <span>{{ $model->name }}</span></div>
                                        <div class="col-md-6">In English: <span>{{ $model->userDetails->en_name }}</span></div>
                                    </div>

                                    <p>পিতার নামঃ </p>
                                    <div class="row mt-4">
                                        <div class="col-md-6">বাংলায়ঃ <span>{{ $model->userDetails->father_bn }}</span></div>
                                        <div class="col-md-6">In English: <span>{{ $model->userDetails->father_en }}</span></div>
                                    </div>

                                    <p>মাতার নামঃ </p>
                                    <div class="row mt-4">
                                        <div class="col-md-6">বাংলায়ঃ <span>{{ $model->userDetails->mother_bn }}</span></div>
                                        <div class="col-md-6">In English: <span>{{ $model->userDetails->mother_en }}</span></div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-6">জন্ম তারিখঃ <span>{{ $model->userDetails->date_of_birth }}</span></div>
                                        <div class="col-md-6">পরিচয় পত্র নং <span>{{ $model->userDetails->nid_no }}</span></div>
                                        <div class="col-md-6">লিঙ্গঃ <span>{{ $model->userDetails->gender }}</span></div>
                                        <div class="col-md-6">ধর্মঃ <span>{{ $model->userDetails->religion }}</span></div>
                                        <div class="col-md-6">রক্তের গ্রুপঃ <span>{{ $model->userDetails->bloodGroup }}+</span></div>
                                        <div class="col-md-6">বৈবাহিক অবস্থাঃ <span>{{ $model->userDetails->martial_status }}</span></div>
                                        <div class="col-md-6">ইমেইলঃ <span>{{ $model->email }}</span></div>
                                        <div class="col-md-6">মোবাইল নং <span>{{ $model->mobile}}</span></div>
                                    </div>
                                </div>
                                <div class="media-body ml-5" id="edit">
                                    <form action="{{ route('profile/changeInfo', ['id'=>$model->id]) }}" method="post" class="form-row" enctype="multipart/form-data">
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
                                            <label for="address" class="col-form-label-sm">অফিসের ঠিকানা <small class="text-danger">*</small></label>
                                            <textarea rows="1" name="address" id="address" required class="form-control form-control-sm @error('address') is-invalid @enderror">{{ $model->address }}</textarea>
                                            @if ($errors->has('address'))<small class="form-text text-danger">{{ $errors->first('address') }}</small>@endif

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
                                        <div class="form-group text-right col-md-12">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-user-edit mr-1"></i>সম্পাদন করুন</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="passchange" role="tabpanel" aria-labelledby="passchange-tab">
                            <div class="container d-flex flex-column justify-content-between vh-100">
                                <div class="row justify-content-center mt-5">
                                    <div class="col-xl-5 col-lg-6 col-md-10">
                                        <div class="card">
                                            <div class="card-body p-4">

                                                <form action="{{ route('profile/changePassword') }}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="password" class="form-control input-lg" id="old_password" name="old_password" placeholder="পুরনো পাসওয়ার্ড দিন">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" class="form-control input-lg" id="new_password" name="new_password" placeholder="নতুন পাসওয়ার্ড দিন">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" class="form-control input-lg" id="confirm_password" name="confirm_password" placeholder="পুনরায় নতুন পাসওয়ার্ড দিন">
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="btn btn-primary" type="submit" value="পাসওয়ার্ড পরিবর্তন করুণ">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="picchange" role="tabpanel" aria-labelledby="picchange-tab">
                            <form action="{{ route('profile/changeProfilePicture', ['id' => $model->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 offset-3">
                                        <div class="form-group text-center">
                                            <img class="img-thumbnail m-3" src="{{  asset($model->photo) }}" alt="{{ $model->name }}" height="250" width="200">
                                            <div class="custom-file">
                                                <input name="image" type="file" class="custom-file-input form-control-sm" id="image" required>
                                                <label id="image_label" class="custom-file-label" for="image">ফাইল বাছাই করুন</label>
                                                <small class="form-text text-muted ">ফাইল ফরমেট অবশ্যই jpg / png / jpeg হবে</small>
                                            </div>
                                            <button class="btn btn-primary mt-2" type="submit"><i class="fas fa-edit"></i> পরিবর্তন করুন</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="sigchange" role="tabpanel" aria-labelledby="sigchange-tab">
                            <form action="{{ route('profile/changeSignature', ['id'=>$model->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 offset-3">
                                        <div class="form-group text-center">
                                            <img class="img-thumbnail m-3" src="{{ asset($model->signature) }}" alt="User" height="80" width="300">
                                            <div class="custom-file">
                                                <input name="signature" type="file" class="custom-file-input form-control-sm" id="signature" required>
                                                <label class="custom-file-label" id="signature_label" for="signature">ফাইল বাছাই করুন</label>
                                                <small class="form-text text-muted ">ফাইল ফরমেট অবশ্যই jpg / png / jpeg হবে</small>
                                            </div>
                                            <button class="btn btn-primary mt-2" type="submit"><i class="fas fa-edit"></i> পরিবর্তন করুন</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="row pt-3 pr-3 pl-3">
                                <div> নটিফিকেশান পরিবর্তন করুণ</div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">ক্রঃ নং</th>
                                    <th scope="col">বিষয় সমূহ</th>
                                    <th scope="col">ইমেইল নটিফিকেশান</th>
                                    <th scope="col">এস.এম.এস নটিফিকেশান</th>
                                    <th scope="col">মোবাইল অ্যাপস নটিফিকেশান</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="row">১</td>
                                    <td>ডাক উপলোড</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">২</td>
                                    <td>ডাক ফরওয়ার্ড</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">৩</td>
                                    <td>আগত ডাক</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">৪</td>
                                    <td>প্রেরিত ডাক</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">৫</td>
                                    <td>ডাক নথিতে উপস্থাপন</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">৬</td>
                                    <td>আগত নথি</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">৭</td>
                                    <td>প্রেরিত নথি</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">৮</td>
                                    <td>পত্রজারি খসড়া তৈরি</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">৯</td>
                                    <td>পত্রজারি</td>
                                    <td>
                                        <label class="switch switch-text switch-primary switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-success switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-text switch-warning switch-pill form-control-label">
                                            <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <p class="mb-4">** কিছু নটিফিকেশান সুপার এডমিন কর্তৃক সংরক্ষিত</p>
                            <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">সংরক্ষণ করুণ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#image').change(function(e){
            var fileName = e.target.files[0].name;
            $('#image_label').html(fileName);
        });
        $('#signature').change(function(e){
            var fileName = e.target.files[0].name;
            $('#signature_label').html(fileName);
        });

        $( document ).ready(showInfo());

        function getEditTemplate() {
            $('#info').hide();
            $('#edit').show();
        }

        function showInfo() {
            $('#info').show();
            $('#edit').hide();
        }
    </script>
@endsection
