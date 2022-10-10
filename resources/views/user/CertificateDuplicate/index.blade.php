@extends('layouts.master')

@section('title', 'এনওসি সনদপত্র')

@section('content')
    <p class="m-0 text-black-50"> এনওসি সনদপত্র</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">এনওসি সনদপত্র</div>
                  </div>
               </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <td class="text-center">ক্র নং</td>
                            <td>এনওসি সনদপত্র নং</td>
                            <td >আবেদন নং</td>
                            <td>আবেদনকারী</td>
                            <td>ইস্যু তারিখ</td>
                            <td class="text-center">কার্যক্রম</td>
                        </tr>
                        </thead>
                        <tbody>
                        @php($sl = 1)
                          @foreach($certificates as $certificate)
                              <tr>
                                  <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($sl) }}</td>
                                  <td>{{ \App\Http\Helpers\Helper::ConvertToBangla($certificate->certificate_no)}}</td>
                                  <td>{{ \App\Http\Helpers\Helper::ConvertToBangla($certificate->application->app_id )}}</td>
                                  <td>{{ $certificate->application->user->name }}</td>
                                  <td>{{ \App\Http\Helpers\Helper::ConvertToBangla($certificate->issue_date) }}</td>
                                  <td class="text-center"><a target="_blank" href="{{ route('CertificateDuplicateCopy/view', ['id' => encrypt($certificate->application_id)]) }}" class="btn btn-sm btn-primary"><i class="fas fa-desktop"></i> View</a> </td>
                              </tr>
                              @php($sl++)
                          @endforeach
                        </tbody>
                    </table>
                </div>
           </div>
       </div>
    </div>
@endsection
