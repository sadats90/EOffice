@extends('layouts.master')
@section('title', 'আবেদন যাচাইকরণ')
@section('content')
    <p class="m-0 text-black-50"> আবেদন যাচাইকরণ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          <span class="card-title"> <strong class="text-danger">{{ \App\Http\Helpers\Helper::ConvertToBangla($application->app_id) }}</strong> নং আবেদন যাচাইকরণ <span class="text-danger">{{ $application->user->name }}</span></span>
                      </div>
                      <div class="col-md-6 text-right">
                          <a href="{{ route('SwarakReplacement/request') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i>একই স্বারকে প্রতিস্থাপনের অনুরোধ</a>
                      </div>
                  </div>
               </div>
               <div class="card-body">
                   @include('includes.message')
                   <div class="row">
                       <div class="col-md-6 col-lg-6 col-sm-12">
                               <div class="form-group row">
                                   <div class="col-sm-12">
                                       <div class="card">
                                           <div class="card-body" style="max-height: 550px;overflow-y: auto;">
                                               @include('user.inc.report_view')
                                           </div>
                                       </div>
                                   </div>
                               </div>
                       </div>
                       <div class="col-md-6 col-lg-6 col-sm-12">
                           <div class="card">
                               <div class="card-body" style="max-height: 550px;overflow-y: auto;">
                                   <ul class="nav nav-pills mb-1 drafts-verification-application-menu" id="pills-tab" role="tablist">
                                       <li class="nav-item">
                                           <a class="nav-link active" id="pills-home-tab-1" data-toggle="pill" href="#pills-home-1" role="tab" aria-controls="pills-home" aria-selected="true">অনুরোধের তথ্য</a>
                                       </li>
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">আবেদনের তথ্য</a>
                                       </li>
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">জমির তথ্য</a>
                                       </li>
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">কাগজ সমূহ</a>
                                       </li>
                                       @can('isInTask', 'admin:lp:li')
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-letter-tab" data-toggle="pill" href="#pills-letter" role="tab" aria-controls="pills-letter" aria-selected="false">চিঠি</a>
                                       </li>
                                       @endcan
                                       @can('isInTask', 'admin:cm:cv:cs:cd')
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-certificate-tab" data-toggle="pill" href="#pills-certificate" role="tab" aria-controls="pills-certificate" aria-selected="false">এনওসি সনদপত্র</a>
                                       </li>
                                       @endcan
                                   </ul>
                                   <div class="tab-content" id="pills-tabContent">
                                       <!-- Application Information -->
                                       <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel" aria-labelledby="pills-home-tab">
                                           @include('user.inc.correctionRequestView')
                                       </div>
                                       <div class="tab-pane fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                           @include('user.inc.applicationInfo')
                                       </div>
                                       <!-- Land Information -->
                                       <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                           @include('user.inc.landInfo')
                                       </div>
                                       <!-- Document Information -->
                                       <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                          @include('user.inc.documentView')
                                       </div>
                                        @can('isInTask', 'admin:lp:li')
                                           <!-- Letter Information -->
                                           <div class="tab-pane fade" id="pills-letter" role="tabpanel" aria-labelledby="pills-letter-tab" style="min-height: 150px; padding-top: 10px; width: 100%; overflow-y: auto">
                                               <div class="card mt-2">
                                                    <div class="card-header p-1">
                                                        <span class="card-title m-0"> চিঠি সমুহ</span>
                                                    </div>
                                                   <div class="card-body">
                                                       <div class="table-responsive">
                                                           @if(count($application->letter_issues ) > 0)
                                                               <table class="table table-bordered table-striped table-sm">
                                                                   <thead>
                                                                   <tr>
                                                                       <td class="text-center">ক্র নং</td>
                                                                       <td class="text-center">চিঠির ধরণ</td>
                                                                       <td class="text-center">বিষয়</td>
                                                                       <td class="text-center">প্রেরণের তথ্য</td>
                                                                       <td class="text-center">শেষ তারিখ</td>
                                                                       <td class="text-right">কার্যক্রম</td>
                                                                   </tr>
                                                                   </thead>
                                                                   <tbody>
                                                                   @php($sl = 1)
                                                                   @foreach($application->letter_issues as $letter)
                                                                       <tr>
                                                                           <td class="text-center">{{ \App\Http\Helpers\Helper::ConvertToBangla($sl++) }}</td>
                                                                           <td>{{ $letter->letterType->name }}</td>
                                                                           <td>{{ $letter->subject }}</td>
                                                                           <td>
                                                                               @if($letter->is_issued == 1)
                                                                                   <small>প্রেরণের তারিখঃ {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->issue_date))) }} </small>
                                                                                   <br>
                                                                                   <small>{{ $letter->is_read == 1 ? 'আবেদনকারী দেখেছে' : 'আবেদনকারী দেখেনি' }}</small>
                                                                                   <br>
                                                                                   <small>{{ $letter->is_solved == 1 ? 'সমাধান হয়েছে' : 'সমাধান হয়নি' }}</small>
                                                                               @else
                                                                                   <span class="text-warning">প্রেরণ হয়নি</span>
                                                                               @endif
                                                                           </td>
                                                                           <td class="text-center">
                                                                                {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->expired_date))) }}
                                                                           </td>
                                                                           <td class="text-right">
                                                                               @can('isInTask', 'admin:lp:li')
                                                                                   <button class="btn btn-sm btn-info" onclick="return ShowInPopUp('{{ route("letter/show", ["id" => encrypt($letter->id), "app_id" => encrypt($application->id)]) }}', 'চিঠির বিস্তারিত')" data-toggle="tooltip" data-placement="top" title="বিস্তারিত"><i class="fas fa-desktop"></i></button>
                                                                               @endcan
                                                                           </td>
                                                                       </tr>
                                                                   @endforeach
                                                                   </tbody>
                                                               </table>
                                                           @else
                                                               <h4 class="text-center text-secondary">এই আবেদন এর কোন চিঠি নাই</h4>
                                                           @endif
                                                       </div>
                                                   </div>
                                               </div>
                                       </div>
                                       @endcan

                                       <!--Certificate -->
                                       <div class="tab-pane fade" id="pills-certificate" role="tabpanel" aria-labelledby="pills-certificate-tab">
                                           @include('user.inc.certificate_view')
                                       </div>
                                   </div>
                               </div>
                           </div>

                       </div>

                       <div class="col-md-12 col-lg-12 col-sm-12 mt-2">
                           <div class="card">
                               <div class="card-body p-2">

                                   <form autocomplete="off" action="{{ route('SwarakReplacement/store', ['id' => encrypt($application->id)]) }}" method="POST" enctype="multipart/form-data">
                                       @csrf
                                       <div class="row">
                                           <div class="col-md-12">
                                               <div class="form-group row">
                                                   <div class="col-md-8">
                                                       <label class="col-form-label" for="message">
                                                           <strong class="text-primary">নতুন অনুচ্ছেদঃ</strong><b class="alert-danger" style="background-color: black; color: yellow; padding: 5px;"> নতুন অনুচ্ছেদে অবশ্যই ক্রমিক নং দিন</b>
                                                       </label>
                                                   </div>
                                                   <div class="col-md-4 text-right mb-2">
                                                       <button class="btn btn-primary btn-sm" onclick="return ShowInPopUp('{{ route("attachment/add", ["id" => $application->id]) }}', 'সংযুক্তি যোগ')" type="button"><i class="fas fa-plus"></i> পতাকা যোগ করুন</button>
                                                   </div>
                                                   <div class="col-sm-12">
                                                       <textarea name="message" required class="form-control form-control-sm message" id="message" cols="30" rows="10"></textarea>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-12 text-right">
                                               <button type="submit" class="btn btn-outline-primary" ><i class="far fa-arrow-alt-circle-right"></i> প্রতিস্থাপন করুন</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>
    <span id="attachments" data-attachments="{{ $attachments }}"></span>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        let attachments = $('#attachments').data('attachments');
        htmlEdittor(attachments);
    });

    function htmlEdittor(attachments){
        let textArea =  $('.message');
        textArea.summernote('destroy');

        var htmlUl = '<ul id="attachment_list">'
        $.each(attachments, function( index, attachment ) {
            htmlUl += '<li data-link="'+ window.location.origin +'/' + attachment.path +'"><span class="btn btn-default text-primary btn-sm">' + attachment.name+ '</span></li>';
        });
        htmlUl += '</ul>'

        var EventData = function (context) {
            var layoutInfo = context.layoutInfo;

            var $toolbar = layoutInfo.toolbar;

            var ui = $.summernote.ui;
            var event = ui.buttonGroup([
                ui.button({
                    className: "dropdown-toggle",
                    contents:
                        '<i class="fas fa-paperclip"></i>',
                    tooltip: "সংযুক্তি",
                    data: {
                        toggle: 'dropdown'
                    }
                }),
                ui.dropdown({
                    className: "drop-default summernote-list",
                    contents:htmlUl,
                    callback: function ($dropdown) {
                        $dropdown.find('li').each(function () {
                            $(this).click(function (e) {
                                let text = $(this).text();
                                let link = $(this).data('link');
                                context.invoke('editor.pasteHTML', '<a href="'+link+'" data-fancybox data-caption="'+text+'">'+text+'</a>');
                                e.preventDefault();
                            });
                        });
                    },
                }),
            ]);

            this.$button = event.render();
            $toolbar.append(this.$button);
        }

        textArea.summernote({
            tabsize: 3,
            height: 150,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript', 'fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['picture', 'video', 'link', 'table', 'hr']],
                ['eventButton', ['event']],
                ['view', ['undo', 'redo', 'codeview','help']]

            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Times new Roman', 'Nikosh'],
            fontNamesIgnoreCheck: ['Nikosh'],
            buttons: {
                event: EventData
            }
        });
    }

    PostForm = form => {
        try {
            $.ajax({
                type: 'POST',
                url: form.action,
                data: new FormData(form),
                contentType: false,
                processData: false,
                success: function (res) {
                    $('#common-modal .modal-title').html('সংযুক্তি যোগ');
                    $('#common-modal .modal-body').html(res.body);
                    $('#common-modal').modal("show");

                    htmlEdittor(res.attachments);
                    toastr.success(res.msg);
                },
                error: function (err) {
                    console.log(err)
                }
            })
            //to prevent default form submit event
            return false;
        } catch (ex) {
            console.log(ex)
        }
    }
</script>
@endsection

