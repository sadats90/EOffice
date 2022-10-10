<table class="table table-bordered table-striped">
    <tbody>
    <tr>
        <th class="w-25 text-right">সরকারি কোন দপ্তরের আবাসিক/বাণিজ্যিক প্রকল্পভুক্ত প্লট কি-না</th>
        <td class="text-left">{{ $application->landInfo->is_own_project }}</td>
    </tr>
    @if($application->landInfo->is_own_project == 'হ্যাঁ')
        <tr>
            <th class="w-25 text-right">প্রকল্প/এলাকার নাম</th>
            <td class="text-left">{{ $application->landInfo->own_project_info->project->name }}</td>
        </tr>

        <tr>
            <th class="w-25 text-right">প্লট নং</th>
            <td class="text-left">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->own_project_info->plot_no) }}</td>
        </tr>
    @else
        <tr>
            <th class="w-25 text-right">জমির তফসিল</th>
            <td class="text-left">
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
            </td>
        </tr>
        <tr>
            <th class="w-25 text-right">সরকারী কোন সংস্থা হতে অধিগ্রহণ হয়েছে কি না?</th>
            <td class="text-left">{{ $application->landInfo->not_own_project_info->is_acquisition }}</td>
        </tr>
    @endif
    <tr>
        <th class="w-25 text-right">জমির পরিমান (একর)</th>
        <td class="text-left">
            {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount) }}
            ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->land_amount, 3)) }} কাঠা)
        </td>
    </tr>
    @if($application->landInfo->not_own_project_info != null)
        @if($application->landInfo->not_own_project_info->is_acquisition == 'হ্যাঁ')
            <tr>
                <th class="w-25 text-right">অধিগ্রহনের পরিমান(একর)</th>
                <td class="text-left">
                    {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->not_own_project_info->acquisition_amount) }}
                    ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) *  $application->landInfo->not_own_project_info->acquisition_amount, 3)) }} কাঠা)
                </td>
            </tr>

            <tr>
                <th class="w-25 text-right">অবশিষ্ট জমির পরিমান(একর)</th>
                <td class="text-left">
                    {{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount) }}
                    ({{ \App\Http\Helpers\Helper::ConvertToBangla(number_format((1 / 0.0165) * ($application->landInfo->land_amount - $application->landInfo->not_own_project_info->acquisition_amount), 3)) }} কাঠা)
                </td>
            </tr>
            <tr>
                <th class="w-25 text-right">অধিগ্রহনের ডকুমেন্ট</th>
                <td class="text-left">
                    <a data-fancybox data-type="iframe" data-src="{{ asset($application->landInfo->not_own_project_info->document_path) }}" href="javascript:;" class="ml-1">
                        <img class="img-fluid img-thumbnail" src="{{ asset('images/file-icon.png') }}" width="45">
                    </a>
                </td>
            </tr>
        @endIf
    @endif
    <tr>
        <th class="w-25 text-right">জমির বর্তমান ব্যবহার</th>
        <td class="text-left">
           {{ $application->landInfo->land_use_present->plut_name }}
        </td>
    </tr>

    <tr>
        <th class="w-25 text-right">জমির ভবিষ্যৎ ব্যবহার</th>
        <td class="text-left">
           {{ $application->landInfo->land_use_future->flut_name }}
        </td>
    </tr>
    </tbody>
</table>
