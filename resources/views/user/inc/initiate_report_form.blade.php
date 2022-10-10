<form action="{{ route('application/forward/reportInitiate', ['id' => encrypt($application->id), 'type'=>$type]) }}" method="POST" enctype="multipart/form-data">
    @csrf
        <h5 class="card-subtitle pb-2">১. প্রতিবেদন</h5>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"><mark> অবস্থান <small>(RCC এর অন্তর্ভুক্ত ও বহির্ভুত স্থানের নাম)<span class="text-danger">*</span></small></mark></label>
                <select name="location" class="form-control form-control-sm" required>
                    <option value="">--বাছাই করুণ--</option>
                    <option value="আরসিসি ওয়ার্ড ০১" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০১' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০১</option>
                    <option value="আরসিসি ওয়ার্ড ০২" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০২' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০২</option>
                    <option value="আরসিসি ওয়ার্ড ০৩" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০৩' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০৩</option>
                    <option value="আরসিসি ওয়ার্ড ০৪" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০৪' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০৪</option>
                    <option value="আরসিসি ওয়ার্ড ০৫" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০৫' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০৫</option>
                    <option value="আরসিসি ওয়ার্ড ০৬" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০৬' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০৬</option>
                    <option value="আরসিসি ওয়ার্ড ০৭" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০৭' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০৭</option>
                    <option value="আরসিসি ওয়ার্ড ০৮" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০৮' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০৮</option>
                    <option value="আরসিসি ওয়ার্ড ০৯" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ০৯' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ০৯</option>
                    <option value="আরসিসি ওয়ার্ড ১০" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১০' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১০</option>
                    <option value="আরসিসি ওয়ার্ড ১১" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১১' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১১</option>
                    <option value="আরসিসি ওয়ার্ড ১২" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১২' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১২</option>
                    <option value="আরসিসি ওয়ার্ড ১৩" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১৩' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১৩</option>
                    <option value="আরসিসি ওয়ার্ড ১৪" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১৪' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১৪</option>
                    <option value="আরসিসি ওয়ার্ড ১৫" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১৫' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১৫</option>
                    <option value="আরসিসি ওয়ার্ড ১৬" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১৬' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১৬</option>
                    <option value="আরসিসি ওয়ার্ড ১৭" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১৭' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১৭</option>
                    <option value="আরসিসি ওয়ার্ড ১৮" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১৮' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১৮</option>
                    <option value="আরসিসি ওয়ার্ড ১৯" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ১৯' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ১৯</option>
                    <option value="আরসিসি ওয়ার্ড ২০" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২০' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২০</option>
                    <option value="আরসিসি ওয়ার্ড ২১" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২১' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২১</option>
                    <option value="আরসিসি ওয়ার্ড ২২" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২২' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২২</option>
                    <option value="আরসিসি ওয়ার্ড ২৩" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২৩' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২৩</option>
                    <option value="আরসিসি ওয়ার্ড ২৪" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২৪' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২৪</option>
                    <option value="আরসিসি ওয়ার্ড ২৫" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২৫' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২৫</option>
                    <option value="আরসিসি ওয়ার্ড ২৬" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২৬' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২৬</option>
                    <option value="আরসিসি ওয়ার্ড ২৭" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২৭' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২৭</option>
                    <option value="আরসিসি ওয়ার্ড ২৮" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২৮' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২৮</option>
                    <option value="আরসিসি ওয়ার্ড ২৯" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ২৯' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ২৯</option>
                    <option value="আরসিসি ওয়ার্ড ৩০" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি ওয়ার্ড ৩০' ? 'selected' : '' }} @endif>আরসিসি ওয়ার্ড ৩০</option>
                    <option value="আরসিসি বহির্ভূত" @if($application-> is_report_initiate == 1) {{ $application->report->location == 'আরসিসি বহির্ভূত' ? 'selected' : '' }} @endif>আরসিসি বহির্ভূত</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="land_class"><mark>খতিয়ানে জমির শ্রেনী <span class="text-danger">*</span></mark></label>
                <input type="text" name="land_class" id="land_class" class="form-control form-control-sm"  @if($application-> is_report_initiate == 1) value="{{ $application->report->land_class }}" @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="seat_no"><mark> সিট নং <span class="text-danger">*</span></mark></label>
                <input type="text" name="seat_no" id="seat_no" class="form-control form-control-sm" required @if($application-> is_report_initiate == 1)value="{{ $application->report->seat_no }}" @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="spz_no"><mark>ক) এস. পি. জেড নং </mark></label>
                <input type="text" name="spz_no" id="spz_no" class="form-control form-control-sm"  @if($application-> is_report_initiate == 1) value="{{ $application->report->spz_no }}" @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="zone"><mark> জোন <span class="text-danger">*</span></mark></label>
                <input type="text" name="zone" id="zone" class="form-control form-control-sm" required @if($application-> is_report_initiate == 1)value="{{ $application->report->zone }}" @endif>
            </div>
        </div>

        <div  class="col-md-12" >
            <div class="form-group row">
                <label class="col-12 col-form-label col-form-label-sm">
                    <mark>খ) মহাপরিকল্পনার নকশায় অন্তর্ভুক্ত আছে কি না?<span class="text-danger">*</span></mark>
                    @if($application-> is_report_initiate == 1)
                       @foreach($application->report->reportMaps as $map)
                            <div class="btn-group">
                                <button class="btn btn-sm btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $map->name }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-success"  href="{{ asset($map->path) }}" data-fancybox="gallery" data-caption="verification Attachment" title="দেখুন"><i class="fas fa-eye"></i> দেখুন</a>
                                    <a class="dropdown-item text-danger confirm-alert" href="{{ route('application/forward/deletemap', [ 'id' => $map->id, 'app_id' => $application->id, 'type' => $type]) }}" title="মুছে ফেলুন"><i class="fas fa-trash-alt"></i> মুছে ফেলুন</a>
                                </div>
                            </div>

                        @endforeach
                    @endif
                </label>
                <div class="col-12 mb-2">
                    <textarea name="is_include_design" id="is_include_design" class="form-control form-control-sm" required>@if($application-> is_report_initiate == 1) {{ $application->report->is_include_design }} @endif</textarea>
                </div>
                <div class="col-12" id="add_map">
                    <div class="row form-group">
                        <div class="col-md-5">
                            <input type="file" name="mapFiles[]" class="form-control form-control-sm" accept="image/*,application/pdf,.wmf">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="mapFilesName[]" class="form-control form-control-sm" placeholder="ফাইল নাম">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-success" type="button" id="add_map_file">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="col-12 col-form-label col-form-label-sm">
                    <mark>গ) ভূমিটি আরডিএ বা অন্য কোন সংস্থার উন্নয়ন পরিকল্পনা ভুক্ত কি না <span class="text-danger">*</span></mark>
                    @if($application-> is_report_initiate == 1)
                        @foreach($application->report->devPlans as $dev)
                            <div class="btn-group">
                                <button class="btn btn-sm btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $dev->name }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-success"  href="{{ asset($dev->path) }}" data-fancybox="gallery" data-caption="verification Attachment" title="দেখুন"><i class="fas fa-eye"></i> দেখুন</a>
                                    <a class="dropdown-item text-danger confirm-alert" href="{{ route('application/forward/deletePlan', [ 'id' => $dev->id, 'app_id' => $application->id, 'type' => $type]) }}"title="মুছে ফেলুন"><i class="fas fa-trash-alt"></i> মুছে ফেলুন</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </label>
                <div class="col-12 mb-2">
                    <select name="is_dev_plan" id="is_dev_plan" class="form-control form-control-sm" onchange="getDetailsForm(this.value)">
                        <option value="">-বাছাই করুণ-</option>
                        <option value="1" @if($application-> is_report_initiate == 1) {{ $application->report->is_dev_plan == 1 ? 'selected' : '' }} @endif>হ্যাঁ</option>
                        <option value="0" @if($application-> is_report_initiate == 1) {{ $application->report->is_dev_plan == 0 ? 'selected' : '' }} @endif>না</option>
                    </select>
                </div>
                <div class="col-12" id="plans"@if($application-> is_report_initiate == 1) @if($application->report->is_dev_plan == 1) style="display: block;" @endif @endif style="display: none;">
                    <textarea name="dev_plan_desc" id="dev_plan_desc" class="form-control form-control-sm">@if($application-> is_report_initiate == 1) {{ $application->report->dev_plan_desc }} @endif</textarea>
                    <div class="row form-group mt-2">
                        <div class="col-md-5">
                            <input type="file" name="dev_plans[]" class="form-control form-control-sm" accept="image/*,application/pdf">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="dev_plansName[]" class="form-control form-control-sm" placeholder="ফাইল নাম">
                        </div>
                        <div class="col-md-2 ">
                            <button class="btn btn-sm btn-success" type="button" id="add_plan">+</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"><mark>ঘ) ভূমির মালিকানা সংক্রান্ত দলিলাদি ঠিক আছে কিনা<span class="text-danger">*</span></mark></label>
                <select name="documents_correct" id="documents_correct" class="form-control form-control-sm" required>
                    <option value="">-বাছাই করুণ-</option>
                    <option value="হ্যাঁ" @if($application-> is_report_initiate == 1) {{ $application->report->documents_correct === 'হ্যাঁ' ? 'selected' : '' }} @endif>হ্যাঁ</option>
                    <option value="না" @if($application-> is_report_initiate == 1) {{ $application->report->documents_correct === 'না' ? 'selected' : '' }} @endif>না</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"><mark>ঙ) প্রথমাংশে প্রদত্ত তথ্যাদি ঠিক আছে কিনা.<span class="text-danger">*</span></mark></label>
                <select name="information_correct" id="information_correct" class="form-control form-control-sm" required>
                    <option value="">--বাছাই করুণ--</option>
                    <option value="হ্যাঁ" @if($application-> is_report_initiate == 1) {{ $application->report->information_correct == 'হ্যাঁ' ? 'selected' : '' }} @endif>হ্যাঁ</option>
                    <option value="না"@if($application-> is_report_initiate == 1)  {{ $application->report->information_correct == 'না' ? 'selected' : '' }} @endif>না</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"><mark>চ) ড্রেনেজ, রাস্তা ইত্যাদির অবস্থা কিরূপ</mark></label>
                <textarea name="road_condition" id="road_condition" class="form-control form-control-sm">@if($application-> is_report_initiate == 1) {{ $application->report->road_condition }} @endif</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"><mark>ছ) ভূমিতে উৎকর্ষ ফি প্রযোজ্য হবে কিনা <span class="text-danger">*</span></mark></label>
                <select name="applicable_betterment_fee" id="applicable_betterment_fee" class="form-control form-control-sm" required>
                    <option value="">--বাছাই করুণ--</option>

                    <option value="হ্যাঁ" @if($application-> is_report_initiate == 1) {{ $application->report->applicable_betterment_fee == 'হ্যাঁ' ? 'selected' : '' }} @endif>হ্যাঁ</option>
                    <option value="না" @if($application-> is_report_initiate == 1) {{ $application->report->applicable_betterment_fee == 'না' ? 'selected' : '' }} @endif>না</option>
                </select>
            </div>
        </div>
    </div>

        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-outline-primary btn-sm"><i class="far fa-clipboard"></i> সংরক্ষণ করুণ</button>
            </div>
        </div>

</form>

