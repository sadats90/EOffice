<div class="col-12 mt-2">
    <table class="table table-sm table-bordered text-dark">
        <thead>
        <tr>
            <td class="text-center">ক্র নং</td>
            <td>আবেদনের আইডি</td>
            <td>আবেদনের তারিখ</td>
            <td>আবেদনের ধরণ</td>
            <td>আবেদনকারীর নাম ও ঠিকানা</td>
            <td>জমির বিবরণ</td>
            <td>জমির পরিমান</td>
            <td>জমির ভবিষ্যৎ ব্যবহার</td>
            <td>প্রেরক</td>
            <td>গ্রহনের তারিখ</td>
            <td>অবস্থা</td>
            <td class="text-center d-print-none">কার্যক্রম</td>
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)
        @foreach($receiveApps as $row)
            <tr>
                <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($sl++) }}</td>
                <td> {{ \App\Http\Helpers\Helper::ConvertToBangla($row->application->app_id) }}</td>
                <td>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/y', strtotime($row->application->submission_date))) }}</td>
                <td class="text-center align-middle">
                    @if($row->application->app_type == 'Emergency')
                        <span class="bg-gray-300 px-2 text-danger"> জরুরী </span>
                    @else
                        <span>সাধারণ </span>
                    @endif
                </td>
                <td>
                    <p>{{ $row->application->user->name }}</p>
                    <p>পিতাঃ {{ $row->application->personalInfo->fname }}</p>
                    <p>{{ $row->application->personalInfo->pa_area }}, {{ $row->application->personalInfo->pa_post}}, {{ $row->application->personalInfo->pa_thana}} , {{ $row->application->personalInfo->pa_district}} </p>
                </td>
                <td class="text-center align-middle">
                    {{ $row->application->landInfo->area_name }}, {{ \App\Http\Helpers\Helper::ConvertToBangla($row->application->landInfo->rs_plot_no) }}
                </td>
                <td class="text-center align-middle">
                    {{ \App\Http\Helpers\Helper::ConvertToBangla($row->application->landInfo->land_amount) }} একর
                </td>
                <td class="text-center align-middle">
                    {{ \App\Models\LandUseFuture::findOrFail($row->application->landInfo->land_future_use)->flut_name }}
                </td>
                <td>
                    {{ $row->to_user->name }},
                    {{ $row->to_user->designation->name }}
                </td>
                <td>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/y', strtotime($row->out_date))) }}</td>
                <td>
                    @if($row->is_verified == 1)
                        <span>সম্পুর্ণ</span>
                    @elseif($row->is_fail == 1)
                        <span>ব্যর্থ</span>
                    @else
                        <span>প্রক্রিয়াধীন</span>
                    @endif
                </td>
                <td class="text-center d-print-none">
                    <div class="dropdown show">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                            কার্যক্রম
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('complete/app_view',['id'=> encrypt($row->application_id), 'type' => 'report']) }}" target="_blank"><i class="fas fa-file-alt"></i> আবেদন পর্যালোচনা</a>
                            <a class="dropdown-item" href="{{ route('complete/paper_view',['id'=>encrypt($row->application_id), 'type' => 'report']) }}" target="_blank"><i class="fas fa-file"></i> ডকুমেন্ট পর্যালোচনা</a>
                            <a class="dropdown-item" href="{{ route('complete/report_view',['id'=>encrypt($row->application_id), 'type' => 'report']) }}" target="_blank"><i class="far fa-clipboard"></i> আবেদন রিপোর্ট</a>
                            <a class="dropdown-item" href="{{ route('complete/letters',['id'=>encrypt($row->application_id), 'type' => 'report']) }}" target="_blank"><i class="far fa-envelope"></i> চিঠি সমূহ</a>
                            @if($row->application->is_complete == 1)
                            <a class="dropdown-item" href="{{ route('complete/certificate',['id'=>encrypt($row->application_id), 'type' => 'report']) }}" target="_blank"><i class="far fa-file"></i> এনওসি সনদপত্র</a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
