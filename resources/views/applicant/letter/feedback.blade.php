@extends('applicant.layouts.master')
@section('title', 'চিঠির ফিডব্যাক')
@section('content')
    <p>চিঠির ফিডব্যাক</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('includes.message')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="width: 100%; max-height: 800px; overflow-y: auto">
                                <div class="card-header mb-2">
                                    চিঠি
                                </div>
                                <div class="card-body">
                                    @include('includes.view-letter')
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    চিঠির সমাধান
                                </div>
                                <div class="card-body" style="width: 100%; max-height: 800px; overflow-y: auto">
                                    @if($letter_issue->letter_type_id == 1)
                                     <div class="card mb-2">
                                         <div class="card-body">
                                             <form action="{{ route('applicant/letters/paperSubmit', ['id' => $letter_issue->id]) }}" method="post" enctype="multipart/form-data">
                                                 @csrf
                                                 @foreach($letter_issue->problematic_papers as $paper)
                                                     <div class="row">
                                                         <label for="file_{{ $paper->id }}" class="col-sm-12">{{ $paper->documentType->name }} <span class="text-danger">*</span></label>
                                                         <div class="col-sm-12">
                                                            @if($letter_issue->is_paper_submit == 1)
                                                                @foreach($letter_issue->feedback_papers->where('document_type_id', $paper->document_type_id) as $feedBackPaper)
                                                                    <?php
                                                                    $ext = pathinfo($feedBackPaper->file)['extension'];
                                                                    ?>
                                                                    @if($ext == 'pdf')
                                                                        <a data-fancybox data-type="iframe" data-src="{{ asset($feedBackPaper->file) }}" href="javascript:;" class="btn btn-sm btn-default">
                                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/pdf-icon.png') }}" width="50">
                                                                        </a>

                                                                    @else
                                                                        <a data-fancybox="images"  data-src="{{ asset($feedBackPaper->file) }}" href="javascript:;" class="btn btn-sm btn-default">
                                                                            <img style="margin-bottom: 4px;" class="img-fluid img-thumbnail" src="{{ asset('images/Image-icon.png') }}" width="50">
                                                                        </a>
                                                                    @endif
                                                                @endforeach

                                                            @endif
                                                        </div>
                                                         <div class="col-sm-12" id="documents{{ $paper->id }}">
                                                             <div class="form-group form-row" >
                                                                 <input type="hidden" name="document_type_id[]" value="{{ $paper->document_type_id }}">
                                                                 <input type="file" name="file[]" id="file_{{ $paper->id }}" required class="form-control form-control-sm col-md-10" accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                                                 <div class="col-md-2 text-left">
                                                                     <button class="btn btn-success btn-sm" id="add_{{ $paper->id }}" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 @endforeach

                                                 <div class="col-md-12 text-right">
                                                     <button type="submit" class="btn btn-primary" style="border-radius: 0"><i class="fas fa-save"></i> সংরক্ষন করুন</button>
                                                 </div>

                                             </form>
                                         </div>
                                     </div>
                                    @elseif($letter_issue->letter_type_id == 2)
                                        <div class="card mb-2">
                                            <div class="card-body ">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">উৎকর্ষ ফি প্রদান</a>
                                                    </li>
                                                    @if($letter_issue->betterment_fee->is_promise_required == 1)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="promise-tab" data-toggle="tab" href="#promise" role="tab" aria-controls="promise" aria-selected="true">অঙ্গিকারনামা যুক্ত করুন</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane text-center fade show active p-3" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                        @php($vatAmount = ceil(($letter_issue->betterment_fee->betterment_fee * $letter_issue->betterment_fee->vat) / 100))
                                                        @if($letter_issue->is_bm_fee_payment == 0)

                                                            <p class="alert alert-info p-3">উৎকর্ষ ফি বাবদ
                                                                {{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->betterment_fee->betterment_fee) }}
                                                                টাকা এবং ভ্যাট বাবদ {{ \App\Http\Helpers\Helper::ConvertToBangla($vatAmount) }} টাকা, মোট
                                                                {{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->betterment_fee->betterment_fee + $vatAmount) }} টাকা প্রদান করতে হবে!</p>
                                                            <form action="{{ route('applicant/letter/Payment', ['id' => $letter_issue->id]) }}" method="post">
                                                                @csrf
                                                                <button class="btn btn-primary" style="background-color: #69419f"><i class="far fa-credit-card"></i> এখন প্রদান করুন</button>
                                                            </form>
                                                        @else
                                                            <table class="table table-sm table-borderless">
                                                                <tr>
                                                                    <th class="text-left" style="width: 30%">পরিশোধের তারিখ</th>
                                                                    <td style="width: 5%">:</td>
                                                                    <td class="text-success text-left">{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/y', strtotime($letter_issue->betterment_fee_payment->payment_date))) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-left" style="width: 30%">উৎকর্ষ ফি</th>
                                                                    <td style="width: 5%">:</td>
                                                                    <td class="text-success text-left">{{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->betterment_fee_payment->payment_amount) }} ৳</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-left" style="width: 30%">ভ্যাট ({{ \App\Http\Helpers\Helper::ConvertToBangla($letter_issue->betterment_fee->vat) }}%)</th>
                                                                    <td style="width: 5%">:</td>
                                                                    <td class="text-success text-left">{{ \App\Http\Helpers\Helper::ConvertToBangla($vatAmount) }} ৳</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-left" style="width: 30%">অর্থ প্রদানের মাধ্যম</th>
                                                                    <td style="width: 5%">:</td>
                                                                    <td class="text-success text-left">{{ $letter_issue->betterment_fee_payment->payment_method }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-left" style="width: 30%">ট্রানজেকশন নং</th>
                                                                    <td style="width: 5%">:</td>
                                                                    <td class="text-success text-left">{{ $letter_issue->betterment_fee_payment->trxn_id }} </td>
                                                                </tr>
                                                            </table>
                                                        @endif
                                                    </div>
                                                    <div class="tab-pane fade p-3" id="promise" role="tabpanel" aria-labelledby="promise-tab">
                                                        <form action="{{ route('applicant/letters/promiseSubmit', ['id' => $letter_issue->id]) }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="promise_file">অঙ্গিকারনামা <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control" required name="promise_file" id="promise_file">
                                                            </div>
                                                              @if($letter_issue->promise != null)
                                                                <a data-fancybox data-type="iframe" data-src="{{ asset($letter_issue->promise->attachment) }}" href="javascript:;" class="ml-1">
                                                                    <img alt="Attachment" class="img-fluid img-thumbnail" src="{{ asset('images/file-icon') }}" width="45">
                                                                </a>
                                                              @endif
                                                            <button class="btn btn-outline-primary float-right" type="submit">সংরক্ষন</button>
                                                        </form>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                 <div class="card" @if($letter_issue->letter_type_id == 3 || $letter_issue->letter_type_id == 4) style="display: none;" @endif>
                                     <div class="card-body">
                                         <form action="{{ route('applicant/letters/feedbackStore', ['id' => $letter_issue->id]) }}" method="post">
                                             @csrf
                                             <div class="form-group text-right row">
                                                 <div class="col-md-6 offset-3">
                                                     <button type="submit" class="btn btn-block btn-primary" style="border-radius: 0"><i class="far fa-share-square"></i> জমা দিন</button>
                                                 </div>
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
    </div>
@endsection
@section('script')
    @if($letter_issue->letter_type_id == 1)
        <script>
            @foreach($letter_issue->problematic_papers as $paper)
            var maxField = 5;
            //Land document dynamic multiple form
            var index{{ $paper->id }} = 1;
            $('#add_{{ $paper->id }}').click(function(){
                if(index{{ $paper->id }} < maxField){
                    index{{ $paper->id }}++;
                    $('#documents{{ $paper->id }}').append(`
                    <div class="form-group form-row">
                    <input type="hidden" name="document_type_id[]" value="{{ $paper->document_type_id }}">
                                   <input type="file" class="col-md-10 form-control form-control-sm" name="file[]" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf">
                                   <div class="col-md-2 text-left">
                                       <button class="btn btn-danger btn-sm remove_{{ $paper->id }}" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });


            //Once remove button is clicked
            $('#documents{{ $paper->id }}').on('click', '.remove_{{ $paper->id }}', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                index{{ $paper->id }}--;
            });

            @endforeach
        </script>
    @endif


    <script>

        $('#comment').summernote({
            height: 300
        });
    </script>
@endsection
