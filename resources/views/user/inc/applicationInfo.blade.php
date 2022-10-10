<table class="table table-bordered table-striped">
    <body>
    <tr>
        <td class="text-right w-25 text-dark">আবেদনকারীর নামঃ</td>
        <td>
            <table class="table-sm table table-bordered">
                <tr>
                    <th>নাম</th>
                    <th>পিতার নাম</th>
                    <th>এনআইডি নাম্বার</th>
                    <th class="text-center">এনআইডি</th>
                </tr>
                @if(!empty($application->personalInfo))
                    @foreach($application->personalInfo->applicants as $applicant)
                        <tr>
                            <td>{{ $applicant->applicant_name }}</td>
                            <td>{{ $applicant->father_name }}</td>
                            <td>{{ $applicant->nid_number }}</td>
                            <td class="text-center">
                                <a data-fancybox data-type="iframe" data-src="{{ asset($applicant->nid_path) }}" href="javascript:;" class="ml-1">
                                    <img alt="attachment" class="img-fluid img-thumbnail" src="{{ asset('images/file-icon.png') }}" width="20">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </td>
    </tr>
    <tr>
        <td class="text-right w-25 text-dark">ইমেইলঃ</td>
        <td>{{ $application->user->email }}</td>
    </tr>
    <tr>
        <td class="text-right w-25 text-dark">মোবাইল নম্বরঃ</td>
        <td>{{ \App\Http\Helpers\Helper::ConvertToBangla($application->personalInfo->mobile) }}</td>
    </tr>
    <tr>
        <td class="text-right w-25 text-dark">বর্তমান ঠিকানাঃ</td>
        <td>
            বাসা নং {{ $application->personalInfo->ta_house_no }},
            রাস্তার নাম/রাস্তার নং {{ $application->personalInfo->ta_road_no }},
            সেক্টর নং {{ $application->personalInfo->ta_sector_no }},
            গ্রাম/ওয়ার্ড/এলাকাঃ {{ $application->personalInfo->ta_area }},
            পোস্টঃ {{ $application->personalInfo->ta_post }},
            পোস্ট কোডঃ {{ $application->personalInfo->ta_post_code }},
            থানা/উপজেলাঃ {{ $application->personalInfo->ta_thana }},
            জেলাঃ {{ $application->personalInfo->ta_district }}
        </td>
    </tr>
    <tr>
        <td class="text-right w-25 text-dark">স্থায়ী ঠিকানাঃ</td>
        <td>
            বাসা নং {{ $application->personalInfo->pa_house_no }},
            রাস্তার নাম/রাস্তার নং {{ $application->personalInfo->pa_road_no }},
            সেক্টর নং {{ $application->personalInfo->pa_sector_no }},
            গ্রাম/ওয়ার্ড/এলাকাঃ {{ $application->personalInfo->pa_area }},
            পোস্টঃ {{ $application->personalInfo->pa_post }},
            পোস্ট কোডঃ {{ $application->personalInfo->ta_post_code }},
            থানা/উপজেলাঃ {{ $application->personalInfo->pa_thana }},
            জেলাঃ {{ $application->personalInfo->pa_district }}
        </td>
    </tr>

    </body>
</table>
