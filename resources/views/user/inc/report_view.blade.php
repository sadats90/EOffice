<div class="row justify-content-center" id="application-report" style="color: #000; font-family: Nikosh; font-size: 18px;">
    <div class="col-lg-10 col-md-10">
        <div class="row" style="border-bottom: solid 1px #999">
            <div class="col-lg-12 col-md-12">
                <div>
                    <img class="mx-auto d-block" src="{{ asset('images/rda-logo.PNG') }}" alt="RDA Logo" width="60">
                </div>
                <div class="text-center mt-0">
                    <h4>রাজশাহী উন্নয়ন কর্তৃপক্ষ</h4>
                    <p class="mt-0">আর ডি এ ভবন</p>
                    <p class="mt-0">বনলতা বা/এ, রাজশাহী-৬২০৩</p>
                    <a href="//www.rda.rajshahidiv.gov.bd" class="btn btn-sm btn-link mt-1"> <p class="text-dark font-weight-bolder">www.rda.rajshahidiv.gov.bd</p></a>
                </div>
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-lg-12 col-md-12">
                <strong>১। প্রতিবেদন</strong>
                <br>
                <small>ভূমি ব্যবহার ছাড়পত্রের আবেদন নং {{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}</small>
            </div>
        </div>
        <div class="row">
            <div class="col-2 mb-2">
                <h6>অবস্থানঃ</h6>
            </div>
            <div class="col-10 mb-2">
                <h6>{{ $application->report->location }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col mb-2">
                <h6>ক) জমির অবস্থান (তফসিল)</h6>
            </div>
        </div>
        @if($application->landInfo->is_own_project == 'না')
            <div class="row">
                <div class="col-12 mb-2">
                    <table class="table table-sm mb-0">
                        <tr>
                            <th>উপজেলা</th>
                            <th>মৌজা/এলাকা</th>
                            <th>জে.এল</th>
                            <th>আর এস দাগ নং</th>
                        </tr>
                        @foreach($application->landInfo->not_own_project_info->not_own_project_extra_infos as $tafsil)
                            <tr>
                                <td>{{ $tafsil->mouzaArea->upazila->name }}</td>
                                <td>{{ $tafsil->mouzaArea->name }}</td>
                                <td>{{ $tafsil->mouzaArea->jl_name }}</td>
                                <td>{{ \App\Http\Helpers\Helper::ConvertToBangla($tafsil->rs_line_no) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endif
        <div class="row mb-2">
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        <h6 style="border-bottom: solid 1px;">শিট নং</h6>
                    </div>
                    <div class="col-8">
                        <h6 style="border-bottom: dashed 1px;">{{ $application->report->seat_no }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        <h6 style="border-bottom: solid 1px;">খতিয়ানে জমির শ্রেণীঃ</h6>
                    </div>
                    <div class="col-8">
                        <h6 style="border-bottom: dashed 1px;">{{ $application->report->land_class }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        <h6 style="border-bottom: solid 1px;">জমির পরিমানঃ</h6>
                    </div>
                    <div class="col-8">
                        <h6 style="border-bottom: dashed 1px;">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount)}} ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->land_amount, 3)) }} কাঠা)</h6>
                    </div>
                </div>
            </div>
        </div>
        @if($application->landInfo->not_own_project_info != null)
            @if($application->landInfo->not_own_project_info->is_acquisition == 'হ্যাঁ')
                <div class="row mb-2">
                    <div class="col">
                        <div class="row">
                            <div class="col-4">
                                <h6 style="border-bottom: solid 1px;">অধিগ্রহণ জমির পরিমানঃ</h6>
                            </div>
                            <div class="col-8">
                                <h6 style="border-bottom: dashed 1px;">
                                    {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->not_own_project_info->acquisition_amount) }}
                                    ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->not_own_project_info->acquisition_amount, 3)) }} কাঠা)
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-4">
                                <h6 style="border-bottom: solid 1px;">অবশিষ্ট জমির পরিমানঃ</h6>
                            </div>
                            <div class="col-8">
                                <h6 style="border-bottom: dashed 1px;">
                                    {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount) }}
                                    ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) * ($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount), 3)) }} কাঠা)
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="row mb-3">
            <div class="col-2">
                <h6 style="border-bottom: solid 1px;">খ) এস.পি.জেড নং</h6>
            </div>
            <div class="col-2">
                <h6 style="border-bottom: dashed 1px;">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->report->spz_no) }}</h6>
            </div>
            <div class="col-2">
                <h6 style="border-bottom: solid 1px;">জোন</h6>
            </div>
            <div class="col-2">
                <h6 style="border-bottom: dashed 1px;">{{ $application->report->zone }}</h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <h6 style="border-bottom: solid 1px;">গ) মহাপরিকল্পনার নকশায় অন্তর্ভুক্ত আছে কি না

                </h6>
            </div>
            <div class="col">
                <h6 style="border-bottom: dashed 1px;">
                    {{ $application->report->is_include_design }}
                    @if(count($application->report->reportMaps) > 0)
                        @foreach($application->report->reportMaps as $i => $map)
                            <a href="{{ asset($map->path) }}" data-fancybox="gallery" data-caption="map Attachment">{{ $map->name }}</a>
                        @endforeach
                    @endif
                </h6>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <h6 style="border-bottom: solid 1px;">ঘ) আবেদনকারী কি হিসেবে আবেদন করেছেন</h6>
            </div>
            <div class="col">
                <h6 style="border-bottom: dashed 1px;">{{ \App\Models\LandUseFuture::find($application->landInfo->land_future_use)->flut_name }}</h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <h6 style="border-bottom: solid 1px;">ঙ) ভূমিটি আরডিএ বা অন্য কোন সংস্থার উন্নয়ন পরিকল্পনা ভুক্ত কি না

                </h6>
            </div>
            <div class="col">
                <h6 style="border-bottom: dashed 1px;">
                    @if($application->report->is_dev_plan == 1)
                        {{ $application->report->dev_plan_desc }}

                        @if(count($application->report->devPlans) > 0)
                            @foreach($application->report->devPlans as $j => $plan)
                                <a href="{{ asset($plan->path) }}" data-fancybox="gallery" data-caption="map Attachment">{{ $plan->name }} </a>
                            @endforeach
                        @endif
                    @else
                        না
                    @endif
                </h6>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <h6 style="border-bottom: solid 1px;">চ) ভূমির মালিকানা সংক্রান্ত দলিলাদি ঠিক আছে কিনা </h6>
            </div>
            <div class="col">
                <h6 style="border-bottom: dashed 1px;">{{ $application->report->documents_correct }}</h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <h6 style="border-bottom: solid 1px;">ছ) প্রথমাংশে প্রদত্ত তথ্যাদি ঠিক আছে কিনা </h6>
            </div>
            <div class="col">
                <h6 style="border-bottom: dashed 1px;">{{ $application->report->information_correct }}</h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <h6 style="border-bottom: solid 1px;">জ) ড্রেনেজ, রাস্তা ইত্যাদির অবস্থা কিরূপ</h6>
            </div>
            <div class="col">
                <h6 style="border-bottom: dashed 1px;">{{ $application->report->road_condition }}</h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <h6 style="border-bottom: solid 1px;">ঝ) ভূমিতে উৎকর্ষ ফি প্রযোজ্য হবে কিনা </h6>
            </div>
            <div class="col">
                <h6 style="border-bottom: dashed 1px;">{{ $application->report->applicable_betterment_fee }}</h6>
            </div>
        </div>

        @if(!empty($f_v_message->message))
        <div class="row">
            <div class="col">
                <h6 class="app-report-dm-message">
                   ২। {!! substr($f_v_message->message, 0, 3) == '<p>' ? substr($f_v_message->message, 3) : $f_v_message->message !!}

                    @if(!empty($f_v_message->file))
                        <a href="{{ asset($f_v_message->file) }}" data-fancybox="gallery" data-caption="verification Attachment">(সংযুক্তি)</a>
                    @endif
                </h6>
            </div>
        </div>
        @endif
        @php($countMessage = 2)
        @foreach($v_messages as $v_message)

            @if(!empty($request->message) || $v_message->message != "<p><br></p>")
                @php($id = 0)
                @php($letter_issue_id = [])
                <div class="row mb-3">
                    @php($same_messages = $v_messages->where('same_comment', $v_message->same_comment))
                    @php($index = 0)
                    @foreach($same_messages as $same)

                        @if($same->letter_issue_id != 0)
                            @php(array_push($letter_issue_id, $same->letter_issue_id))
                        @endif

                        @if(!is_null($same->violate_by))  @php($id = $same->violate_by) @endif

                        @if($same->version != 1)
                            @if(!empty($request->message) || $same->message != "<p><br></p>")
                            <div class="col-12">
                                @php($countMessage++)
                                <p> {{ \App\Http\Helpers\Helper::ConvertToBangla($countMessage) }}। {!! substr($same->message, 0, 3) == '<p>' ? substr($same->message, 3) :  $same->message !!}</p>
                            </div>
                            @endif
                        @endif

                        <div @if($index > 3) class="col-3 offset-9 text-center" @else class="col-3 text-center" @endif>
                            @if($same->on_behalf_of == null)
                                <img class="img-responsive" style="width: 100px;height: 40px;" src="{{ asset($same->user->signature) }}" alt="" >
                            @else
                                <img class="img-responsive" style="width: 100px;height: 40px;" src="{{ asset($same->onBehalfOf->signature) }}" alt="" >
                            @endif
                            <h6 style="border-top: solid 1px;text-align: center;">
                                <p class="m-0"> <small>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d-m-Y H:i:s', strtotime($same->created_at))) }}</small></p>
                                @if($same->on_behalf_of == null)
                                    ({{ $same->user->name }})
                                @else
                                      ({{ $same->onBehalfOf->name }})
                                @endif
                                <br>
                                <small>{{ $same->user->designation->name }}</small><br>
                            </h6>
                        </div>
                            @php($index++)
                    @endforeach
                    @if($id != 0)
                        @php($message = \App\Models\VerificationMessage::findOrFail($id))
                            <div @if(count($same_messages) > 3) class="col-3 offset-9 text-center" @else class="col-3 text-center" @endif>
                                <h6 style="border-top: solid 1px;text-align: center; margin-top: 40px;">
                                    <p class="m-0"><del><small> {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d-m-Y H:i:s', strtotime($message->created_at))) }}</small></del></p>
                                    <del>
                                        @if($message->on_behalf_of == null)
                                            ({{ $message->user->name }})
                                        @else
                                              ({{ $message->onBehalfOf->name }})
                                        @endif
                                        <br>
                                        <small>{{ $message->user->designation->name }}</small>
                                    </del>
                                    <br>
                                </h6>
                            </div>
                    @endif
                    @if(count($letter_issue_id) > 0)
                        <div class="col-12">
                            @foreach($letter_issue_id as $l_i_id)
                                @php( $letter_issue = \App\Models\LetterIssue::where([['application_id', $application->id], ['is_issued', 1], ['id', $l_i_id]])->first())
                                <div class="row">
                                    <div class="col-12 text-danger">
                                        স্বারক নং- ০৪০.০০৩.০০২.০০০.০০০.{{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}.{{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->sl_no) }}, প্রেরণের তারিখ:{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter_issue->issue_date))) }}
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
        @if($application->is_certificate_make == 1)
            @if($application->certificate->is_issue == 1)
                <div>
                    স্মারক নং ০৪০.০০৩.০০২.০০০.০০০.{{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}, প্রেরণের তারিখ:{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($application->certificate->issue_date))) }}
                </div>
            @endif

        @endif
    </div>
</div>
