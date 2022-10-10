<div class="row justify-content-center"  style="color: #000; ">
    <div class="col-10 offset-1" id="print_this">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div>
                    <img class="mx-auto d-block" src="{{ asset('images/rda-logo.PNG') }}" alt="RDA Logo" width="60">
                </div>
                <div class="text-center mt-1">
                    <h4>রাজশাহী উন্নয়ন কর্তৃপক্ষ</h4>
                    <p class="mt-1">আর ডি এ ভবন</p>
                    <p class="mt-1">বনলতা বা/এ, রাজশাহী-৬২০৩</p>
                    <a href="//www.rda.rajshahidiv.gov.bd" class="btn btn-sm btn-link mt-1"> <p class="text-dark font-weight-bolder">www.rda.rajshahidiv.gov.bd</p></a>
                </div>
            </div>
        </div>
        <hr class="mt-0 border-dark">
        <div class="row">
            <div class="col-md-9">
                স্বারক নং- ০৪০.০০৩.০০২.০০০.০০০.{{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->application->app_id) }}.@if($letter_issue->is_issued == 1){{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->sl_no)  }} @else --- @endif
            </div>
            <div class="col-md-3 text-right">
                তারিখঃ @if($letter_issue->is_issued == 1) {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter_issue->issue_date))) }} @endif
            </div>

            <div class="col-md-12 mt-4">
                <table class="table table-sm table-borderless">

                    @if($letter_issue->letter_type_id != 4)
                        <tr>
                            <td style="width: 3%">প্রতি,</td>
                        </tr>
                        <tr>
                            <td style="width: 3%">জনাব</td>
                            <td style="width: 1%;">:</td>
                            <td>{{ $personal_info->applicants[0]->applicant_name }}</td>
                        </tr>
                        <tr>
                            <td style="width: 3%">পিতা/স্বামী</td>
                            <td>:</td>
                            <td>{{ $personal_info->applicants[0]->father_name }}</td>
                        </tr>
                        <tr>
                            <td style="width: 3%">ঠিকানা</td>
                            <td>:</td>
                            <td>
                                বাসা নং {{ $personal_info->ta_house_no }}, রাস্তার নাম/রাস্তার নং  {{ $personal_info->ta_road_no }}, সেক্টর নং {{ $personal_info->ta_sector_no }},
                                <br>
                                গ্রাম/ওয়ার্ড/এলাকাঃ {{ $personal_info->ta_area }}, পোস্টঃ {{ $personal_info->ta_post }}, পোস্ট কোডঃ {{ $personal_info->ta_post_code }},
                                থানা/উপজেলাঃ {{ $personal_info->ta_thana }}, জেলাঃ {{ $personal_info->ta_district }}
                                <br>
                                <br>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th style="width: 3%">বিষয়</th>
                        <th  style="width: 1%;">:</th>
                        <th colspan="3">
                            {{ $letter_issue->subject }}
                        </th>
                    </tr>
                    @if($letter_issue->letter_type_id == 4)
                        <tr>
                            <td style="width: 3%">সূত্র</td>
                            <td style="width: 1%;">:</td>
                            <td>
                                <table class="table-borderless">
                                    @foreach($letter_issue->letter_laws as $law)
                                        <tr>
                                            <td>{{ $law->law_name }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endif
                    @if($letter_issue->letter_type_id != 4)
                        <tr>
                            <td class="text-justify" colspan="5">
                                <br>
                                তিনি/তাঁরা  <strong>{{ $land_info->area_name }}</strong> মৌজা/প্রকল্প আর.এস  <strong>{{ \App\Http\Helpers\Helper::ConvertToBangla($land_info->rs_plot_no) }}</strong> নং দাগে/প্লটে গত <strong>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($land_info->created_at))) }}</strong> খ্রিঃ তারিখে <strong>{{ \App\Models\LandUseFuture::find($land_info->land_future_use)->flut_name }}</strong> হিসেবে ভূমি ব্যবহার অনিস্পত্তি প্রদানের অনুরোধ জানিয়ে আবেদন করেছেন, তা নিম্নবর্ণিত কারণে যথাসময়ে প্রদান করা সম্ভব হচ্ছে না।
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td class="text-justify" colspan="5">
                            <br>
                            <ul class="list-group">
                                @php($sl = 0)
                                @if($letter_issue->letter_type_id == 1 )
                                    @foreach($letter_issue->problematic_papers as $paper)
                                        @if($paper->document_type_id == 1 || $paper->document_type_id == 2 || $paper->document_type_id == 3 || $paper->document_type_id == 4)
                                            <li class="list-group-item p-2" style="border: none">{{ \App\Http\Helpers\Helper::ConvertToBangla( ++$sl) }}। আবেদিত জমির {{ $paper->documentType->name }} এর কপি অনলাইনে দাখিল করতে হবে।</li>
                                        @elseif($paper->document_type_id == 5)
                                            <li class="list-group-item p-2" style="border: none">{{ \App\Http\Helpers\Helper::ConvertToBangla( ++$sl) }}। স্বাক্ষরসহ মৌজা নকশায় আবেদিত জমির সঠিক স্থান লাল কালি দ্বারা চিহ্নিত করে অনলাইনে দাখিল করতে হবে। </li>
                                        @elseif($paper->document_type_id == 6)
                                            <li class="list-group-item p-2" style="border: none">{{ \App\Http\Helpers\Helper::ConvertToBangla( ++$sl) }}। জাতীয় পরিচয়পত্র/পাসপোর্ট/ড্রাইভিং লাইসেন্স/নাগরিকত্ব সনদ এর সত্যায়িত ফটোকপি অনলাইনে দাখিল করতে হবে।</li>
                                        @elseif($paper->document_type_id == 7)
                                            <li class="list-group-item p-2" style="border: none">{{ \App\Http\Helpers\Helper::ConvertToBangla( ++$sl) }}। অবস্থান ম্যাপ/হাত নকশা অনলাইনে দাখিল করতে হবে।</li>
                                        @elseif($paper->document_type_id == 8)
                                            <li class="list-group-item p-2" style="border: none">{{ \App\Http\Helpers\Helper::ConvertToBangla( ++$sl) }}। অঙ্গিকারনামা অনলাইনে দাখিল করতে হবে।</li>
                                        @elseif($paper->document_type_id == 9)
                                            <li class="list-group-item p-2" style="border: none">{{ \App\Http\Helpers\Helper::ConvertToBangla( ++$sl) }}। অবস্থানগত সনদপত্র অনলাইনে দাখিল করতে হবে।</li>
                                        @endif
                                    @endforeach
                                @endif
                                @if($letter_issue->letter_type_id == 2)
                                    @php($vatAmount = ceil(($letter_issue->betterment_fee->betterment_fee * $letter_issue->betterment_fee->vat) / 100))

                                    <li  style="border: none">
                                        {{ \App\Http\Helpers\Helper::ConvertToBangla( ++$sl) }}। আবেদিত জমি রাজশাহী উন্নয়ন কর্তৃপক্ষ বাস্তবায়িত
                                        <strong> {{ $letter_issue->betterment_fee->project->name }}</strong>
                                        শীর্ষক প্রকল্পের রাস্তার
                                        <strong> {{ $letter_issue->betterment_fee->road_section }} এর</strong>
                                        মধ্যে পড়ে। বিধায় উল্লেখিত জমির উৎকর্ষ ফি বাবদ
                                        <strong> {{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->betterment_fee->betterment_fee) }} /-</strong>
                                        ({{ \App\Http\Helpers\ConvertToWord::NumberToBanglaWord($letter_issue->betterment_fee->betterment_fee) }}) টাকা চেয়ারম্যান রাজশাহী উন্নয়ন কর্তৃপক্ষ এর অনুকুলে বি.ডি/ পে- অর্ডার এর মাধ্যমে অত্র দপ্তরে দাখিলসহ বর্ণিত উৎকর্ষ ফি এর বিপরীতে
                                        {{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->betterment_fee->vat) }}% ভ্যাট বাবদ
                                        {{ \App\Http\Helpers\Helper::ConvertToBangla($vatAmount) }}/-
                                        ({{ \App\Http\Helpers\ConvertToWord::NumberToBanglaWord($vatAmount) }}) টাকা অর্থাৎ মোট
                                        {{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->betterment_fee->betterment_fee + $vatAmount) }} /-
                                        ({{ \App\Http\Helpers\ConvertToWord::NumberToBanglaWord($letter_issue->betterment_fee->betterment_fee + $vatAmount) }}) টাকা চেয়ারম্যান, রাজশাহী উন্নয়ন কর্তৃপক্ষ এর অনুকুলে অনলাইনে জমা প্রদান করতে হবে।
                                    </li>
                                @endif

                                @if($letter_issue->message != null )
                                    <li  style="border: none">
                                        <div class="row">
                                            <div class="col-12" style="font-family: Kalpurush">
                                                {!! substr($letter_issue->message, 0, 3) == '<p>' ? substr($letter_issue->message, 3, -4) : $letter_issue->message !!}
                                            </div>
                                        </div>

                                    </li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                    @if($letter_issue->letter_type_id != 4)
                        <tr>
                            <td colspan="5">
                                <br>
                                আগামী {!! \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter_issue->expired_date))) !!} খ্রিঃ তারিখের মধ্যে বর্ণিত বিষয়ে প্রয়োজনীয় ব্যবস্হা গ্রহণের জন্য অনুরোধ করা হল। অন্যথায়, তাঁর দাখিলকৃত আবেদনপত্র বিবেচনা করার সুযোগ নেই।
                                উল্লেখ, চাহিত তথ্যাদি অথবা নির্দেশিত নির্দেশনা পরিপালনের পর পরবর্তী ৩০ (ত্রিশ) কার্যদিবসের মধ্যে ভূমি ব্যবহার ছাড়পত্র অনিস্পত্তি সংক্রান্ত সিদ্ধান্ত প্রদান করা হবে।
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div class="col-8">
                                </div>
                                @if($letter_issue->is_issued == 1)
                                    <div class="col-4 text-center">
                                        <br>
                                        <br>
                                        @if($letter_issue->on_behalf_of == null)
                                            <img src="{{ asset($issued_user->signature) }}" alt="signature" style="width: 150px;height: auto;"/>
                                        @else
                                            <img src="{{ asset($letter_issue->onBehalfOf->signature) }}" alt="signature" style="width: 150px;height: auto;"/>
                                        @endif
                                        <br>
                                        <small>তারিখ: {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter_issue->issue_date))) }}</small>
                                        @if($letter_issue->on_behalf_of == null)
                                            <p class="mt-1 mb-1">{{ $issued_user->name }}</p>
                                        @else
                                            <p class="mt-1 mb-1">{{ $letter_issue->onBehalfOf->name }}</p>
                                        @endif

                                        <p class="mb-1"> {{ $issued_user->designation->name }}</p>
                                        <p class="mb-1">রাজশাহী উন্নয়ন কর্তৃপক্ষ</p>
                                        <p>ফোন নং {{ \App\Http\Helpers\Helper::ConvertToBangla($issued_user->mobile) }}</p>
                                    </div>
                                @else
                                    <div class="col-4 text-center">
                                        <br>
                                        <br>
                                        <br>
                                        স্বাক্ষরঃ
                                        <br>
                                        তারিখঃ
                                        <br>
                                        নামঃ
                                        <br>
                                        পদবী
                                        <br>
                                        রাজশাহী উন্নয়ন কর্তৃপক্ষ
                                        <br>
                                        ফোন নং
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                        @if($letter_issue->letter_type_id == 4)
                            <tr>
                                <td colspan="5">
                                    <p class="mb-2">{{ $letter_issue->name }}</p>
                                    <p>{{ $letter_issue->address }}</p>
                                </td>
                            </tr>
                        @endif
                </table>
            </div>
        </div>
    </div>
</div>
