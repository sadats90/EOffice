@extends('applicant.layouts.master')
@section('title', 'ডকুমেন্ট দর্শন করুণ')
@section('content')
    <p>ডকুমেন্ট দর্শন করুণ</p>
    <hr>

    @include('includes.message')

    <div class="card">
        <div class="card-header p-3">
            <div class="row">
                <div class="col-md-6">
                    ডকুমেন্ট দর্শন করুণ
                </div>
            </div>
        </div>
        <div class="card-body pt-0 mr-1 pl-3">
            <div class="row">
                <div class="col">
                    <?php
                        $ext = pathinfo($app_doc_file->file)['extension'];
                    ?>
                    @if($ext == 'pdf')
                        <embed src="{{ asset($app_doc_file->file) }}" style="width:100%;height: 600px;" type="application/pdf">
                    @else
                        <img src="{{ asset($app_doc_file->file) }}" alt="Document File" style="max-width: 100%;height: auto">
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
