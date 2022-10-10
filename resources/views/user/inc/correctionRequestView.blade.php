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
                <b> বিষয়ঃ</b> {{ $application->correction_request->subject }}
            </div>
            <div class="col-md-3 text-right">
                তারিখঃ {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($application->correction_request->created_at))) }}
            </div>

            <div class="col-md-12 mt-4">
                {!! $application->correction_request->description !!}
            </div>

            <div class="col-md-12 mt-4">
                @if($application->correction_request->attachment != null)
                    <a data-fancybox data-type="iframe" data-src="{{ asset($application->correction_request->attachment) }}" href="javascript:;" class="ml-1">
                        <img class="img-fluid img-thumbnail" src="{{ asset('images/file-icon') }}" width="45">
                    </a>
                @endif
            </div>

            <div class="col-9">

            </div>
            <div class="col-3 text-center">
                <p>নিবেদক</p>
                <p>{{ $application->user->name }}</p>
                <p>মোবাইল নং {{ \App\Http\Helpers\Helper::ConvertToBangla($application->user->mobile) }}</p>
                <p>ঠিকানাঃ {{ $application->user->address }}</p>
            </div>
        </div>
    </div>
</div>
