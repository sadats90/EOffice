@extends('layouts.master')
@section('title', 'চিঠির সমাধানের পর্যালোচনা')
@section('content')
    <p>চিঠির সমাধানের পর্যালোচনা</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    চিঠির সমাধানের পর্যালোচনা
                </div>
                <div class="card-body">
                    @include('includes.message')
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card" style="width: 100%; max-height: 800px; overflow-y: auto">
                                <div class="card-header mb-2">
                                    চিঠি
                                </div>

                               @include('includes.view-letter')
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    চিঠির সমাধান
                                </div>
                                <div class="card-body " style="width: 100%; max-height: 800px; overflow-y: auto">

                                    @if($letter_issue->letter_type_id == 1)
                                     <div class="card mb-2">
                                         <div class="card-body">
                                             <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                 @foreach($letter_issue->problematic_papers as $ni => $paper)
                                                     <li class="nav-item">
                                                         <a class="nav-link @if($ni == 0) active @endIf" id="{{ $paper->id }}-tab" data-toggle="tab" href="#{{ $paper->id }}" role="tab" aria-controls="{{ $paper->id }}" aria-selected="true">{{ $paper->documentType->name }}</a>
                                                     </li>
                                                 @endforeach
                                             </ul>
                                             <div class="tab-content" id="myTabContent">
                                                 @foreach($letter_issue->problematic_papers as $tp => $paper)
                                                    <div class="tab-pane fade @if($tp == 0)show active @endif" id="{{ $paper->id }}" role="tabpanel" aria-labelledby="{{ $paper->id }}-tab">
                                                        @foreach($letter_issue->feedback_papers->where('document_type_id', $paper->document_type_id) as $feedback_paper)
                                                            <?php
                                                            $ext = pathinfo($feedback_paper->file)['extension'];
                                                            ?>
                                                            @if($ext == 'pdf')
                                                                <a data-fancybox data-type="iframe" data-src="{{ asset($feedback_paper->file) }}" href="javascript:;" class="btn btn-sm btn-default float-right">
                                                                    <i class="fas fa-expand-alt"></i>
                                                                </a>
                                                                <embed src="{{ asset($feedback_paper->file) }}" style="width:100%;height: 480px;" type="application/pdf">
                                                            @else
                                                                <a data-fancybox="images"  data-src="{{ asset($feedback_paper->file) }}" href="javascript:;" class="btn btn-sm btn-default float-right">
                                                                    <i class="fas fa-expand-alt"></i>
                                                                </a>
                                                                <img src="{{ asset($feedback_paper->file) }}" alt="Document File" style="max-width: 100%;height: auto">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                 @endforeach
                                             </div>
                                         </div>
                                     </div>
                                    @elseif($letter_issue->letter_type_id == 2)

                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">উৎকর্ষ ফি প্রদানের তথ্য</a>
                                                    </li>

                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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

    </script>
@endsection
