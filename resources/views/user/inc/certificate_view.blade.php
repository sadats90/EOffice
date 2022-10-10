<div class="card-body watermark" id="print_this" style="font-family: Nikosh; font-size:20px;color: #0b0e19;">
   <div class="row">
        <div class="col-10 offset-1">
            <div class="row" style="border-bottom: solid 2px #999">
                <div class="col-lg-4 col-md-4">
                    <div>
                        <img class=" d-block" src="{{ asset('images/rda-logo.PNG') }}" alt="RDA Logo" width="60">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="text-center mt-1">
                        <h4>রাজশাহী উন্নয়ন কর্তৃপক্ষ</h4>
                        <p class="mt-1">আর ডি এ ভবন</p>
                        <p class="mt-1">বনলতা বা/এ, রাজশাহী-৬২০৩</p>
                        <a href="//www.rda.rajshahidiv.gov.bd" class="btn btn-sm btn-link mt-1"> <p class="text-dark font-weight-bolder">www.rda.rajshahidiv.gov.bd</p></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="text-right">
                        <img class="float-right d-block" src="{{ asset('images/mujib-logo.png') }}" alt="RDA Logo" width="100">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center mt-4 text-dark">
                    <span class="font-weight-bold" style="border-bottom: solid 1px #000000;">ভূমি ব্যবহার অনিস্পত্তি</span>
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-left text-dark">
                    স্মারক নং ০৪০.০০৩.০০২.০০০.০০০.{{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}/@if($application->certificate->is_issue == 1) {{ \App\Http\Helpers\Helper::ConvertToBangla($application->certificate->certificate_no) }} @endif
                </div>
                <div class="col-6 text-right text-dark">
                    ভূমি ব্যবহারের অনিস্পত্তি আবেদন নং {{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-left text-dark">
                  @if(!is_null($application->certificate->old_swarok))
                        পুরাতন স্মারক নং {{ $application->certificate->old_swarok }}
                  @endif
                </div>
                <div class="col-6 text-right text-dark mt-1">
                    তারিখঃ- {{ \App\Http\Helpers\Helper::ConvertToBangla( date('d/m/y', strtotime($application->certificate->created_at))) }}
                </div>
            </div>
            <div class="row">
                <div class="col text-dark mt-4">
                   <table class=" table-sm table-borderless">
                       @if($application->certificate->certificate_type_id == 1)
                       <tr>
                           <td style="width: 1%">প্রতি,</td>
                       </tr>
                       @foreach($application->certificate->general_certificate->applicants as $i => $applicant)
                               <tr>
                                   <td style="width: 1%">&nbsp;</td>
                                   <td colspan="2" style="width: 1%">({{ \App\Http\Helpers\Helper::ConvertToBangla(++$i) }})</td>
                                   <td style="width: 20%">{{ $applicant->name }}</td>
                                   <td style="width: 2%;">পিতা</td>
                                   <td style="width: 1%">:</td>
                                   <td>{{ $applicant->father }}</td>
                               </tr>
                       @endforeach
                           <tr>
                               <td style="width: 1%">&nbsp;</td>
                               <td style="width: 1%">সাং</td>
                               <td style="width: 1%">:</td>
                               <td style="width: 20%">{{ $application->certificate->general_certificate->village }}</td>
                               <td style="width: 2%;">ডাকঘর </td>
                               <td style="width: 1%">:</td>
                               <td>{{ $application->certificate->general_certificate->post_office }}</td>
                           </tr>
                           <tr>
                               <td style="width: 1%">&nbsp;</td>
                               <td style="width: 1%">থানা</td>
                               <td style="width: 1%">:</td>
                               <td style="width: 20%">{{ $application->certificate->general_certificate->thana }}</td>
                               <td style="width: 2%;">জেলা </td>
                               <td style="width: 1%">:</td>
                               <td>{{ $application->certificate->general_certificate->district }}</td>
                           </tr>
                       <tr>
                           <td colspan="7" class="font-weight-bold text-justify">
                               {{ $application->certificate->subject }}
                           </td>
                       </tr>
                       <tr>
                           <td colspan="6">

                           </td>
                       </tr>
                       <tr>
                           <td colspan="7" class="text-justify pt-1" style="line-height: 25px">
                                   {!! $application->certificate->condition_to_be_followed !!}
                           </td>
                       </tr>
                       @endif
                       @if($application->certificate->certificate_type_id == 2)
                               <tr>
                                   <td style="width: 2%"><strong>বিষয়</strong></td>
                                   <td style="width: 2%">:</td>
                                   <td colspan="4">
                                       <p class="text-justify font-weight-bold pt-1" style="line-height: 25px">
                                           {{ $application->certificate->subject }}
                                       </p>
                                   </td>
                               </tr>
                               <tr>
                                   <td style="width: 2%"><strong>সূত্র</strong></td>
                                   <td style="width: 2%">:</td>
                                   <td colspan="4">
                                       @foreach($application->certificate->government->laws as $law)
                                       <p class="text-justify pt-1 font-weight-bold" style="line-height: 25px">{{ $law->name }}</p>
                                       @endforeach
                                   </td>
                               </tr>
                               <tr>
                                   <td colspan="6" class="text-justify pt-1 m-0" style="line-height: 25px">
                                       {!! $application->certificate->condition_to_be_followed !!}
                                   </td>
                               </tr>
                       @endif
                           @if(count($application->certificate->certificate_attachments) > 0)
                               <tr>
                                   <td colspan="6" class="pt-3">
                                       সংযুক্তি :
                                       @foreach($application->certificate->certificate_attachments as $c_a_i => $c_attachment)
                                           @if($c_a_i != 0) , @endif <a href="{{ asset($c_attachment->path) }}" data-fancybox="gallery" data-caption="verification Attachment">{{ $c_attachment->name }}</a>
                                       @endforeach
                                   </td>
                               </tr>
                           @endif

                   </table>
                </div>
            </div>
            @if($application->certificate->certificate_type_id == 1)
            <div class="row">
                <div class="col-8 offset-2 text-dark">
                    <table class="table-sm table-borderless mb-0">
                        <tr>
                            <th colspan="3" class="text-center"> <span style="border-bottom: 1px solid #000000"> প্রস্তাবিত ভুমির অবস্থান ও পরিকল্পনাঃ</span></th>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center"> <span><strong>প্লানিং জোন :</strong> {{ $application->certificate->general_certificate->zone }}</span></td>
                        </tr>
                        <tr>
                            <td style="width:40%">
                                <span>(ক) <span class="ml-3">মৌজার নাম : <strong class="ml-1">{{ $application->certificate->general_certificate->mouza }}</strong></span></span>
                            </td>
                            <td style="width:20%"></td>
                            <td style="width:40%">
                                <span>(খ) <span class="ml-3">দাগ নং (আর. এস) : <strong class="ml-1">{{ $application->certificate->general_certificate->spot_no }}</strong></span></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:40%" class="pb-0">
                                <span>(গ) <span class="ml-3">জে.এল নং : <strong class="ml-1">{{ $application->certificate->general_certificate->zl_no }}</strong></span></span>
                            </td>
                            <td style="width:20%"></td>
                            <td style="width:40%" class="pb-0">
                                <span>(ঘ) <span class="ml-3">জমির পরিমান : <strong class="ml-1">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->certificate->general_certificate->land_amount) }}</strong> একর</span></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-7"></div>
                @if($application->certificate->is_issue == 1)
                    @php($user = \App\User::findOrFail($application->certificate->issue_by))
                    <div class="col-5 text-center text-dark">
                        <br>
                        @if($application->certificate->on_behalf_of == null)
                            <img style="width: 150px;height: auto;" src="{{ asset($user->signature) }}" alt="">
                        @else
                            <img style="width: 150px;height: auto;" src="{{ asset($application->certificate->onBehalfOf->signature) }}" alt="">
                        @endif
                        <br>
                        <small class="mb-4">তারিখ: {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($application->certificate->issue_date))) }}</small>
                        @if($application->certificate->on_behalf_of == null)
                            <p class="mb-2">{{ $user->name }}</p>
                        @else
                            <p class="mb-2">{{ $application->certificate->onBehalfOf->name }}</p>
                        @endif
                        <p class="mb-2">{{ $user->designation->name }}</p>
                        <p class="mb-2">রাজশাহী উন্নয়ন কর্তৃপক্ষ</p>
                        <p>ফোন নং- {{ \App\Http\Helpers\Helper::ConvertToBangla($user->mobile) }}</p>

                        <br>
                      
                            <div >
                                {!! QrCode::size(200)->generate(route('complete/certificate',[$code_to_view])) !!}
                               
                            </div>
                   
                @else
                    <div class="col-5 text-center text-dark">
                        <br>
                        <small class="mb-4">তারিখ</small>
                        <p class="mb-2">নাম</p>
                        <p class="mb-2">নগর পরিকল্পক</p>
                        <p class="mb-2">রাজশাহী উন্নয়ন কর্তৃপক্ষ</p>
                        <p>ফোন নং-</p> 
                        
                    </div>
                @endif
            </div>
            @if($application->certificate->certificate_type_id == 2)
                <div class="row">
                    <div class="col-12">
                       <p>{{ $application->certificate->government->name }}</p>
                       <p>{{ $application->certificate->government->address }}</p>
                    </div>
                </div>
            @endif
            @if(count($application->certificate->certificate_duplicates) > 0)
                <div class="row pt-3">
                    <div class="col text-dark">
                        <br><br><br>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th>অনুলিপি সদয় অবগতির জন্য :</th>
                            </tr>
                            @foreach($application->certificate->certificate_duplicates as $i => $duplicate)
                                <tr>
                                    <td class="pl-4">{{ \App\Http\Helpers\Helper::ConvertToBangla($i + 1) }}। {{ $duplicate->user->name }}, {{ $duplicate->user->address }}, রাজশাহী উন্নয়ন কর্তৃপক্ষ।</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            @endif
        </div>
        
   </div>

</div>
