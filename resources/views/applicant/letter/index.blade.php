@extends('applicant.layouts.master')
@section('title', 'ইস্যু করা চিঠি সমূহ')
@section('content')
    <p>ইস্যু করা চিঠি সমূহ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @include('includes.message')
                <div class="card-header">
                    ইস্যু করা চিঠি সমূহ
                </div>
                <div class="card-body">
                    @if(count($letters) > 0)
                    <table class="table table-sm table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">ক্র নং</th>
                            <th scope="col" class="text-center">আবেদন আইডি</th>
                            <th scope="col">বিষয়</th>
                            <th scope="col" class="text-center">ইস্যু তারিখ</th>
                            <th scope="col" class="text-center">শেষ তারিখ</th>
                            <th scope="col" class="text-center">অবস্থা</th>
                            <th scope="col" class="text-center">কার্যক্রম</th>
                        </tr>
                        </thead>
                        <tbody>

                            @php($sl = 0)
                            @foreach($letters as $letter)
                                <tr>
                                    <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla(++$sl) }}</td>
                                    <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($letter->application->app_id) }}</td>
                                    <td>{{ $letter->subject }}</td>
                                    <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime( $letter->issue_date))) }}</td>
                                    <td class="text-center">
                                        @if($letter->letter_type_id == 1 || $letter->letter_type_id == 2)
                                            {{ \App\Http\Helpers\Helper::ConvertToBangla( date("d/m/Y", strtotime( $letter->expired_date))) }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($letter->is_read == 0)
                                            নতুন
                                        @elseif($letter->is_solved == 1)
                                            সমাধান হয়েছে
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown show">
                                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 .5rem;">
                                                কার্যক্রম
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('applicant/letters/view', ['id' => encrypt($letter->id), 'app_id' => encrypt($letter->application_id)]) }}" target="_blank"><i class="fas fa-desktop"></i> বিস্তারিত</a>
                                                @if($letter->letter_type_id == 1 || $letter->letter_type_id == 2)
                                                    @if($letter->is_solved == 0)
                                                    <a class="dropdown-item" href="{{ route('applicant/letters/feedback', ['id' => encrypt($letter->id)]) }}"><i class="mdi mdi-comment-search-outline"></i> ফিডব্যাক</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @else
                        <h2 class="text-info p-5 text-center">চিঠি নেই!</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
