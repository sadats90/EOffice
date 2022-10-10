@extends('layouts.master')
@section('title', ' এনওসি সনদপত্রের শর্তাদি সম্পাদন')
@section('content')
    <p class="m-0 text-black-50"> এনওসি সনদপত্রের শর্তাদি সম্পাদন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="offset-6">

            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('CertificateText') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>সনদপত্রের শর্তাদি সমূহ</a>
            </div>
        </div>
        <div class="card-body container">
            @include('includes.message')
            <form action="{{ route('CertificateText/Update', ['id'=>$certificate_text->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name" class="col-form-label-sm">শিরোনাম</label>
                    <input type="text" name="title" id="title" value="{{ $certificate_text->title }}" required autofocus class="form-control @error('title') is-invalid @enderror">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="body_text" class="col-form-label-sm">শিরোনাম</label>

                    <textarea name="body_text" id="body_text" class="form-control">{{ $certificate_text->body_text }}</textarea>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle-outline mr-1"></i>সম্পাদন করুন</button>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#body_text').summernote({
                tabsize: 3,
                height: 150,
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Times new Roman', 'Nikosh'],
                fontNamesIgnoreCheck: ['Nikosh']
            });
        })
    </script>
@endsection
