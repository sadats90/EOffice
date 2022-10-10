@extends('applicant.layouts.master')
@section('title', 'সংশোধনের জন্য অনুরোধ')
@section('content')
    <p>সংশোধনের জন্য অনুরোধ</p>
    <hr>
    <div style="font-family: kalpurush;">
        @include('includes.message')

        <div class="alert alert-warning text-center mt-1" id="warning-alert">
            <span style="font-size:20px;">--- উক্ত ফরমের সকল তথ্য আবশ্যিকভাবে বাংলায় পূরণ করতেই হবে ---</span>
        </div>

        <div class="card" style="color: #000000;">

            <div class="card-body pt-0 mr-1 pl-3">
                <form action="{{ route('applicant/applications/correctionRequestStore', ['id' => encrypt($application->id)]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="subject" class="col-form-label text-right">বিষয়ঃ <span class="text-danger">*</span></label>
                            <input
                                name="subject"
                                value="{{ empty($application->correction_request) ? old('subject') : $application->correction_request->subject }}"
                                type="text"
                                class="form-control @error('subject') is-invalid @enderror"
                                id="subject"
                                {{ !empty($application->correction_request) ? $application->correction_request->submitted_at != null ? 'disabled' : '' : '' }}
                                required/>

                            <span class="text-danger">{{ $errors->has('subject') ? $errors->first('subject') : '' }}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="attachment" class="col-form-label text-right">সংযুক্তিঃ </label>
                            <div class="input-group">
                                <input
                                    name="attachment"
                                    type="file"
                                    class="form-control @error('attachment') is-invalid @enderror"
                                    {{ !empty($application->correction_request) ? $application->correction_request->submitted_at != null ? 'disabled' : '' : '' }}
                                    id="attachment">
                                @if($application->correction_request != null)
                                   @if($application->correction_request->attachment != null)
                                        <div class="input-group-append">
                                            <a data-fancybox data-type="iframe" data-src="{{ asset($application->correction_request->attachment) }}" href="javascript:;" class="ml-1">
                                                <img class="img-fluid img-thumbnail" src="{{ asset('images/file-icon') }}" width="45">
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <span class="text-danger">{{ $errors->has('attachment') ? $errors->first('attachment') : '' }}</span>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="col-form-label text-right">বিস্তারিত <span class="text-danger">*</span></label>
                            <textarea
                                name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                required>
                                {{ empty($application->correction_request) ? old('description') : $application->correction_request->description }}
                            </textarea>
                            <span class="text-danger">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                        </div>

                        <div class="col-md-12 text-right mt-2">
                            <button type="submit" class="btn btn-secondary" style="background-color: #69419f" {{ !empty($application->correction_request) ? $application->correction_request->submitted_at != null ? 'disabled' : '' : '' }}>
                                <i class="mdi mdi-cloud"></i> সংরক্ষন করুন</button>
                           @if(!empty($application->correction_request))
                                <a href="{{ route('applicant/applications/correctionRequestPreview', ['id' => encrypt($application->correction_request->id)]) }}" target="_blank" class="btn btn-success"><i class="mdi mdi-printer"></i> প্রিভিউ</a>
                               @if($application->correction_request->submitted_at == null)
                                    <a href="{{ route('applicant/applications/correctionRequestSent', ['id' => encrypt($application->correction_request->id)]) }}" class="btn btn-primary"><i class="mdi mdi-content-save"></i> পাঠান</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    $(document).ready(() => {
        $('#description').summernote({
            height: 200
        });
    });

    let $wcolor = 'red';
    setInterval(function(){
        $('#warning-alert').css({'border':'solid 1px '+$wcolor, 'color':$wcolor});
        if($wcolor === 'red'){
            $wcolor = '#806520';
        }
        else {
            $wcolor = 'red';
        }
    },1000);

</script>

    @if(!empty($application->correction_request))
        @if($application->correction_request->submitted_at != null)
            <script>
                $(document).ready(() => {
                    $('#description').summernote('disable');
                });
            </script>
        @endif
    @endif
@endsection
