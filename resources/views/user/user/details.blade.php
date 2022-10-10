@extends('layouts.master')
@section('title', 'ব্যবহারকারীর বিস্তারিত')
@section('content')
    <p class="m-0 text-black-50">ব্যবহারকারীর বিস্তারিত</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                ব্যবহারকারীর বিস্তারিত
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('User') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>ব্যবহারকারীর তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
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
                                    <a href="{{ $model->userDetails->twitter_link }}" class="mb-1 btn btn-outline btn-twitter rounded-circle">
                                        <i class="mdi mdi-twitter"></i>
                                    </a>
                                    <a href="{{ $model->userDetails->linkedin_link }}" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                                        <i class="mdi mdi-linkedin"></i>
                                    </a>
                                    <a href="{{ $model->userDetails->facebook_link }}" class="mb-1 btn btn-outline btn-facebook rounded-circle">
                                        <i class="mdi mdi-facebook"></i>
                                    </a>
                                    <a href="{{ $model->userDetails->skypee_link }}" class="mb-1 btn btn-outline btn-skype rounded-circle">
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
                                    <a class="nav-link" id="working" data-toggle="tab" href="#working_permission" role="tab" aria-controls="working_permission" aria-selected="true">অনুমতি</a>
                                </li>
                            </ul>
                            <div class="tab-content px-3 px-xl-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="timeline-tab">
                                    <div class="media mt-2 profile-timeline-media">
                                        <div class="media-body ml-5">
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
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="working_permission" role="tabpanel" aria-labelledby="working">
                                    <div class="media mt-2 profile-timeline-media">
                                        <div class="media-body ml-5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <td colspan="3" class="text-center">কাজের অনুমতি বরাদ্দ</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">ক্র নং</td>
                                                                <td>কাজ</td>
                                                                <td class="text-center">কার্যক্রম</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php($i = 0)
                                                                @foreach($workingPermissions as $workingPermission)
                                                                    <tr>
                                                                        <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }}</td>
                                                                        <td>{{ $workingPermission->task->name }}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{ route('User/WorkingPermission/Delete', ['id' => $workingPermission->id]) }}" class="btn btn-sm btn-danger confirm-alert" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"><i class="mdi mdi-delete mr-1"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <td colspan="4" class="text-center">ফরোয়ার্ড অনুমতি বরাদ্দ</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">ক্র নং</td>
                                                                <td>অনুমোদিত ব্যবহারকারী</td>
                                                                <td>পদবী</td>
                                                                <td class="text-center">কার্যক্রম</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php($i = 0)
                                                            @foreach($forwardingPermissions as $forwardingPermission)
                                                                <tr>
                                                                    <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }}</td>
                                                                    <td>{{ $forwardingPermission->permitted_user }}</td>
                                                                    <td>{{ $forwardingPermission->designation->name }}</td>
                                                                    <td class="text-center">
                                                                        <a href="{{ route('User/ForwardPermission/Delete', ['id' => $forwardingPermission->id]) }}" class="btn btn-sm btn-danger confirm-alert" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"><i class="mdi mdi-delete mr-1"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
@endsection
