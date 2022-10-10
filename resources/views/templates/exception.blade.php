@extends('layouts.master')
@section('content')
    <div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="sb-page-header-content py-3">
                <h1 class="sb-page-header-title">
                    <div class="sb-page-header-icon"></div>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n10">
        <div class="card sb-card-header-actions">
            <div class="card-header text-danger">
                Exception
            </div>
            <div class="card-body">

                <div class="sbp-preview">
                    <div class="sbp-preview-content">
                        @if(!empty($exception))
                            <span class="text-danger">{!! $exception !!}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
