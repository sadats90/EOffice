@extends('applicant.layouts.master')
@section('title', 'ফরম ক্রয় করুন')
@section('content')
    <p>ফরম ক্রয় করুন</p>
    <hr>

    <!-- Top Statistics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <div class="row">
                        <div class="col-lg-10">
                            {{--<h4 class="card-title mb-0">ফরম ক্রয় করুন</h4>--}}
                            <marquee class="pt-1"><h6 class="text-danger">আরডিএ এর মহাপরিকল্পনার সাথে সমন্বয়হীন আবেদন সমুহ স্বয়ংক্রিয়ভাবে বাতিল বলে গণ্য হবে</h6></marquee>
                        </div>
                        <div class="col-lg-2 text-right">
                            <a href="{{ route('applicant/applications/Index') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফরমের তালিকা</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2" style="color: #000000;">
                    @include('includes.message')
                <!-- Message template -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card p-3 mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0 text-center">এনওসি সনদপত্রের জন্য বাধ্যতামূলক শর্তাবলী/নিয়মাবলী</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mt-4">
                                        <div class="accordion" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingOne" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            শর্ত/নিয়ম-১
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        আবেদনের সাথে <b>জমির দলিল</b>, <b>খারিজ খতিয়ান</b>, <b>খাজনার রশিদ</b> ও <b>খারিজ রশিদের মূল কপি/সার্টিফাইড</b> কপির স্ক্যান কপি সংযোজন করতে হবে। প্রযোজ্য ক্ষেত্রে, আবেদিত জমি সরকার কর্তৃক গৃহীত উন্নয়ন পরিকল্পনা থাকলে আবেদিত <b>জমির দলিল</b>, <b>খতিয়ান</b>, <b>খাজনার রশিদ</b> অথবা ভূমি অধিগ্রহণের নিমিত্তে প্রশাসনিক অনুমোদন এর স্ক্যান কপি দাখিল করতে হবে। <span style="color: red;">(কোন ডকুমেন্টেরই ফটোকপি হতে স্ক্যান কপি গ্রহণযোগ্য নহে)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingTwo" style="padding: 0" >
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            শর্ত/নিয়ম-২
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        আবেদনকৃত জমির অবস্থান আর.এস মৌজা নক্সার উপর (<sapn class="text-danger">আবেদনকৃত দাগ বা অংশ বা দাগসমূহ লাল কালি দিয়ে চিহ্নিত করতে হবে</sapn>)
                                                        প্রতিস্থাপন করে এর স্ক্যান কপি দাখিল করতে হবে। যাহাতে <b>(ক)</b> মৌজার নাম, <b>(খ)</b> জে. এল নং <b>(গ)</b> সিট নং ও <b>(ঘ)</b> আর. এস. দাগ নং স্পষ্টভাবে উল্লেখ থাকবে এবং আবেদনকৃত দাগ বা অংশ বা দাগসমূহ লাল কালি দিয়ে চিহ্নিত করতে হবে।
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingThree" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            শর্ত/নিয়ম-৩
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        আবেদনকৃত জমির অবস্থান হাত নক্সা/স্কেচ ম্যাপ স্ক্যান করে দাখিল করতে হবে। হাত নক্সা/স্কেচ ম্যাপে প্রস্তাবিত জমির পরিমাপ, জমি সংলগ্ন রাস্তার প্রশস্থতা, আশে-পাশের ভূমি ব্যবহার, উত্তর-দক্ষিণ দিক নির্দেশনাসহ কোন সর্বজন পরিচিত ইমারত, রাস্তা, মোড়, মসজিদ, পুকুর, রেলপথ, অফিস, স্কুল ইত্যাদি হতে জমিটি কোন দিকে, কত দূরে অবস্থিত তা বিস্তারিতভাবে উল্লেখ করতে হবে।
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingFour" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                            শর্ত/নিয়ম-৪
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        আবেদনকারী/আবেদনকারীগণের জাতীয় পরিচয়পত্র/পাসপোর্ট/ড্রাইভিং লাইসেন্স/নাগরিক সনদ/আয়কর প্রত্যয়ন পত্র এর এর স্ক্যান কপি দাখিল করতে হবে।
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingFive" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                            শর্ত/নিয়ম-৫
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        কর্তৃপক্ষের নিকট ভূমি ব্যবহার অনিস্পত্তির জন্য আবেদনপত্র দাখিলের ৩০ (ত্রিশ) কার্যদিবসের মধ্যে আবেদনপত্র চূড়ান্তভাবে নিষ্পত্তি করা হবে। তবে, অসম্পূর্ণ তথ্য বা দলিল বা কাগজপত্র দাখিল বা কর্তৃপক্ষের বিশেষ কোন নির্দেশনা থাকলে আবেদনকারী/আবেদনকারীগণ কর্তৃক অনুরূপ তথ্য বা দলিল বা কাগজপত্র দাখিল বা কর্তৃপক্ষের নির্দেশিত নির্দেশনা পরিপালনের পর হতে পরবর্তী ৩০ (ত্রিশ) কার্যদিবসের মধ্যে আবেদনপত্রখানি চূড়ান্তভাবে নিষ্পত্তি করা হবে।
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingSix" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                            শর্ত/নিয়ম-৬
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        অসম্পূর্ণ আবেদনপত্র অনুমোদনের জন্য বিবেচনা করা হবে না।
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header bg-white" id="headingSeven" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                                            শর্ত/নিয়ম-৭
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        <b>আবেদন  ফি</b><br>
                                                        <ul>
                                                            <li>আবেদনপত্রের মূল্য = {{ \App\Http\Helpers\Helper::ConvertToBangla($fee->application_fee) }} টাকা</li>
                                                            <li>সাধারণ আবেদনপত্রের ক্ষেত্রে = আবেদনপত্রের মূল্য + ভূমি ব্যবহারের আবেদন ফি</li>
                                                            <li>জরুরী আবেদনপত্রের ক্ষেত্রে = আবেদনপত্রের মূল্য + ভূমি ব্যবহারের আবেদন ফি + জরুরী ফি {{ \App\Http\Helpers\Helper::ConvertToBangla($fee->emergency_fee) }} টাকা</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header bg-white" id="headingEight" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                                            শর্ত/নিয়ম-৮
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <h5 class="p-3">সেবার মূল্য সমূহ</h5>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-sm table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th style="width: 15%; text-align: center; font-weight: bold;">ক্রমিক নং</th>
                                                                            <th style="width: 70%; text-align: center; font-weight: bold;">সেবার নাম</th>
                                                                            <th style="width: 15%; text-align: center; font-weight: bold;">সেবার মূল্য</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @php($sl = 1)
                                                                        @foreach($fluts as $flut)
                                                                            <tr>
                                                                                <td style="width: 15%; text-align: center;">{{ \App\Http\Helpers\Helper::ConvertToBangla($sl)}}</td>
                                                                                <td> {{ $flut->flut_name }}</td>
                                                                                <td class="text-right">{{ \App\Http\Helpers\Helper::ConvertToBangla($flut->cost )}} টাকা</td>
                                                                            </tr>
                                                                            @php($sl++)
                                                                        @endforeach

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingNine" style="padding: 0">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                                            শর্ত/নিয়ম-৯
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                                                    <div class="card-body text-justify p-2" style="line-height: 2">
                                                        <b>ভ্যাট</b><br>
                                                        <ul>
                                                            <li>সব ধরনের অর্থ পরিশোধের সাথে <b class="text-danger">১৫%</b> হারে অনলাইনের মাধ্যমে ভ্যাট প্রদান করতে হবে। অসম্পূর্ণ/অবৈধ কোন চালান জমা দিলে আবেদন <b class="text-danger">স্বংক্রিয়ভাবে বাতিল সহ শাস্তিমূলক</b> ব্যবস্থা গ্রহণ করা হবে।   </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-2">
                                <div class="card-body">
                                    <div class="mt-2">
                                        <form action="{{ route('applicant/application/Payment') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="app_type" class="col-form-label text-right">আবেদনের ধরণ<small> (অনুগ্রহ করে শর্ত/নিয়ম-৭ দেখুন)</small><span class="text-danger">*</span> </label>
                                                        <select class="form-control" name="app_type" id="app_type" required>
                                                            <option value="">-নির্বাচন করুন-</option>
                                                            <option value="Normal">সাধারণ</option>
                                                            <option value="Emergency">জরুরী</option>
                                                        </select>

                                                        <span class="text-danger">{{ $errors->has('app_type') ? $errors->first('app_type') : '' }}</span>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="land_future_use" class="col-form-label text-right">ভবিষ্যৎতে জমি যে হিসাবে ব্যবহার করতে চান <small>(অনুগ্রহ করে শর্ত/নিয়ম-৮ দেখুন)</small><span class="text-danger">*</span> </label>
                                                        <select class="form-control" name="land_future_use" id="land_future_use" required >
                                                            <option value="">-নির্বাচন করুন-</option>
                                                            @foreach($fluts as $flut)
                                                                <option value="{{ $flut->id }}">{{ $flut->flut_name }}</option>
                                                            @endforeach
                                                        </select>

                                                        <span class="text-danger">{{ $errors->has('land_future_use') ? $errors->first('land_future_use') : '' }}</span>

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="land_future_use" class="col-form-label text-right">আবেদন ফর্মের মূল্য </label>
                                                        <input type="text" class="form-control" readonly required value="{{ $fee->application_fee }}" name="application_fee" id="application_fee">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="service_charge" class="col-form-label text-right"> সেবার মূল্য</label>
                                                        <input type="text" class="form-control" readonly required  name="service_charge" id="Service_charge">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="emergency_fee" class="col-form-label text-right">জরুরী ফি</label>
                                                        <input type="text" class="form-control" readonly required name="emergency_fee" id="emergency_fee">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="land_future_use" class="col-form-label text-right">মোট মূল্য </label>
                                                        <input type="text" class="form-control" readonly required  name="total_fee" id="total_fee">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="vat" class="col-form-label text-right">ভ্যাট <span class="text-danger">({{ \App\Http\Helpers\Helper::ConvertToBangla($fee->vat)  }}%)</span> </label>
                                                        <input type="text" class="form-control" readonly required  name="vat" id="vat">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="grand_total" class="col-form-label text-right"> সর্ব মোট </label>
                                                        <input type="text" class="form-control" readonly required  name="grand_total" id="grand_total">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-check">
                                                <input name="term" type="checkbox" class="form-check-input" id="rules" required>
                                                <label class="form-check-label" for="rules">আমি সজ্ঞানে উপরের সকল নিয়মাবলী জেনে বুঝে ও মেনেই আবেদন করছি</label>
                                            </div>
                                            <span class="text-danger">{{ $errors->has('term') ? $errors->first('term') : '' }}</span>
                                            <div class="form-group form-check text-center mt-3">
                                                <button type="submit" disabled class="btn btn-primary float-lg-right" id="btnSubmit"><i class="fas fa-credit-card mr-2"></i> বিল পরিশোধ করুণ</button>
                                            </div>
                                        </form>
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
@section('script')
    <script>
        $(document).ready(function (){
            $('#rules').on('change', function (){
               let isChecked = $(this).is(':checked');
              if(isChecked){
                  $('#btnSubmit').prop('disabled', false);
              }else{
                  $('#btnSubmit').prop('disabled', true);
              }
            });

            $('#app_type').change(function (){
                let $value = $(this).val();
                let emergency_fee = '{{ $fee->emergency_fee }}';
                if($value === 'Emergency'){
                    $('#emergency_fee').val(emergency_fee);
                }else{
                    $('#emergency_fee').val(0);
                }
                Calculation();
            });

            $('#land_future_use').change(function (){
                let value = $(this).val();
                if(value !== ''){
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route('GetServiceCharge') }}',
                        type: 'POST',
                        data: {_token: CSRF_TOKEN, id: value},
                        dataType: 'JSON',
                        success: function (price) {
                            $('#Service_charge').val(price);
                            Calculation();
                        },
                        error: function (error){
                            console.log(error);
                        }
                    });
                }else{
                    $('#Service_charge').val(0);
                }
            });
            Calculation();
        });

        function Calculation(){
            let total = Number($('#application_fee').val()) + Number($('#Service_charge').val()) + Number($('#emergency_fee').val());
            $('#total_fee').val(total);

            let vat = total * '{{ $fee->vat }}' / 100;
            $('#vat').val(vat);

            $('#grand_total').val(vat + total);
        }
    </script>
@endsection
