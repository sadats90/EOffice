<div class="col-12 mt-2">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <td class="text-center">ক্র নং</td>
            <td>আবেদনের আইডি</td>
            <td>আবেদনকারী</td>
            <td>আবেদনের তারিখ</td>
            <td>প্রাপক</td>
            <td>গ্রহনের তারিখ</td>
            <td>অবস্থা</td>
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)
        @foreach($forwardApps as $row)
            <tr>
                <td class="text-center">{{ $sl++ }}</td>
                <td> {{ \App\Http\Helpers\Helper::ConvertToBangla($row->application->app_id) }}</td>
                <td>{{ $row->application->user->name }}</td>
                <td>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/y', strtotime($row->application->submission_date))) }}</td>
                <td>{{ $row->to_user->name }}</td>
                <td>{{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/y', strtotime($row->in_date))) }}</td>
                <td>
                    @if($row->is_verified == 1)
                        <span>সম্পুর্ণ</span>
                    @elseif($row->is_fail == 1)
                        <span>ব্যর্থ</span>
                    @else
                        <span>প্রক্রিয়াধীন</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
