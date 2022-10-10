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
                          <a href="{{ route('workHandover/Application') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফরওয়ার্ডকৃত আবেদন সমূহ</a>
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
                                           <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">আবেদনের তথ্য</a>
                                       </li>
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">জমির তথ্য</a>
                                       </li>
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">কাগজ সমূহ</a>
                                       </li>
                                       @can('handoverIsInTask', ['admin:lp:li', $application->receive_application->to_user_id])
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-letter-tab" data-toggle="pill" href="#pills-letter" role="tab" aria-controls="pills-letter" aria-selected="false">চিঠি</a>
                                       </li>
                                       @endcan
                                       @can('handoverIsInTask', ['admin:cm:cv:cs:cd', $application->receive_application->to_user_id])
                                       <li class="nav-item">
                                           <a class="nav-link" id="pills-certificate-tab" data-toggle="pill" href="#pills-certificate" role="tab" aria-controls="pills-certificate" aria-selected="false">এনওসি সনদপত্র</a>
                                       </li>
                                       @endcan
                                   </ul>
                                   <div class="tab-content" id="pills-tabContent">
                                       <!-- Application Information -->
                                       <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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
                                        @can('handoverIsInTask', ['admin:lp:li', $application->receive_application->to_user_id])
                                           <!-- Letter Information -->
                                           <div class="tab-pane fade" id="pills-letter" role="tabpanel" aria-labelledby="pills-letter-tab" style="min-height: 150px; padding-top: 10px; width: 100%; overflow-y: auto">
                                               @can('handoverIsInTask', ['admin:lp', $application->receive_application->to_user_id])
                                                   <div class="card">
                                                        <div class="card-header pb-1 text-danger" id="create_letter" onclick="createLetter()" style="cursor: pointer;">
                                                           <div class="row">
                                                                <div class="col-6">
                                                                    <span class="card-title m-0">চিঠি তৈরি করুন</span>
                                                                </div>
                                                               <div class="col-6 text-right">
                                                                   <span ><i class="fas fa-plus" id="create_icon"></i> </span>
                                                               </div>
                                                           </div>
                                                        </div>
                                                        <div class="card-body" id="create_letter_form" style="display: none;">
                                                            @include('handover.letter._letter_form')
                                                        </div>
                                                   </div>
                                                @endcan
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
                                                                               @if($letter->letter_type_id == 1 || $letter->letter_type_id == 2 )
                                                                                    {{ \App\Http\Helpers\Helper::ConvertToBangla(date('d/m/Y', strtotime($letter->expired_date))) }}
                                                                               @else
                                                                                   <span>নাই</span>
                                                                               @endif
                                                                           </td>
                                                                           <td class="text-right">
                                                                               @can('handoverIsInTask', ['admin:lp:li', $application->receive_application->to_user_id])
                                                                                   <button class="btn btn-sm btn-info" onclick="return ShowInPopUp('{{ route("Handover/Letter/show", ["id" => $letter->id, "app_id" => $application->id]) }}', 'চিঠির বিস্তারিত')" data-toggle="tooltip" data-placement="top" title="বিস্তারিত"><i class="fas fa-desktop"></i></button>
                                                                               @endcan
                                                                               @if($letter->is_issued == 0)
                                                                                   @can('handoverIsInTask', ['admin:lp:li', $application->receive_application->to_user_id])
                                                                                       <a href="{{ route('Handover/Letter/edit', ['id' => $letter->id, 'app_id'=> $application->id, 'hit' => $hit]) }}" class="btn btn-sm btn-primary mt-1" data-toggle="tooltip" data-placement="top" title="সম্পাদন"><i class="fas fa-edit"></i></a>
                                                                                   @endcan
                                                                                   @can('handoverIsInTask', ['admin:li', $application->receive_application->to_user_id])
                                                                                       <a href="{{ route('Handover/Letter/sent', ['id' => $letter->id, 'app_id'=> $application->id, 'hit' => $hit, 'userId' => $application->receive_application->to_user_id]) }}" class="btn btn-sm confirm-alert btn-warning mt-1" data-toggle="tooltip" data-placement="top" title="পাঠান"><i class="far fa-envelope"></i></a>
                                                                                   @endcan
                                                                                   @can('handoverIsInTask', ['admin:lp', $application->receive_application->to_user_id])
                                                                                       <a href="{{ route('Handover/Letter/delete', ['id' => $letter->id, 'app_id'=> $application->id, 'hit' => $hit, 'userId' => $application->receive_application->to_user_id]) }}" class="btn btn-sm btn-danger confirm-alert mt-1" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"><i class="fas fa-trash-alt"></i></a>
                                                                                   @endcan
                                                                               @endif
                                                                               @if($letter->is_solved == 1)
                                                                                   <a href="{{ route('Handover/Letter/solveReview', ['id' => $letter->id, 'userId' => $application->receive_application->to_user_id]) }}" class="btn btn-sm btn-primary mt-1" data-toggle="tooltip" data-placement="top" title="সমাধান পর্যালচনা" target="_blank"><i class="fas fa-envelope"></i></a>
                                                                               @endif
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
                                           @if($application->is_certificate_make == 0 )
                                               @can('handoverIsInTask', ['admin:cm', $application->receive_application->to_user_id])
                                                @include('handover.certificate.make_certificate_form')
                                               @endcan
                                           @else
                                              <div class="text-right">
                                                  @can('handoverIsInTask', ['admin:cm:cv:cs:cd', $application->receive_application->to_user_id])
                                                  <a href="{{ route('Handover/certificate/view', ['id' => $application->id, 'userId' => $application->receive_application->to_user_id]) }}" class="btn btn-info btn-sm mb-2" style="border-radius: 0" target="_blank"><i class="fas fa-desktop"></i> বিস্তারিত</a>
                                                  @endcan
                                                  @can('handoverIsInTask', ['admin:cv', $application->receive_application->to_user_id])
                                                      @if($application->certificate->is_issue == 0)
                                                          <a href="{{ route('Handover/certificate/issue', ['id' => $application->id, 'userId' => $application->receive_application->to_user_id]) }}" class="btn btn-warning btn-sm mb-2 confirm-alert" style="border-radius: 0"><i class="fas fa-clipboard-check"></i> ইস্যু</a>
                                                      @endif
                                                  @endcan
                                                  @can('handoverIsInTask', ['admin:cd', $application->receive_application->to_user_id])
                                                      @if($application->certificate->is_issue == 1)
                                                              <button type="button" class="btn btn-secondary btn-sm mb-2" style="border-radius: 0" onclick="Print('print_this')"><i class="fas fa-print"></i> প্রিন্ট করুন</button>
                                                              <a href="{{ route('Handover/certificate/complete', ['id' => $application->id, 'userId' => $application->receive_application->to_user_id]) }}" class="btn btn-success btn-sm mb-2 confirm-alert" style="border-radius: 0"><i class="fas fa-check-circle"></i> আবেদন সম্পুর্ন</a>
                                                      @endif

                                                  @endcan
                                              </div>
                                                @if($application->certificate->is_issue == 1)
                                                   @include('user.inc.certificate_view')
                                                @else
                                                   @include('handover.certificate.make_certificate_form')
                                                @endif
                                           @endif
                                       </div>
                                   </div>
                               </div>
                           </div>

                       </div>
                       <div class="col-md-12 col-lg-12 col-sm-12 mt-2">
                           <div class="card">
                               <div class="card-body p-2">
                                    @include('handover.forward.forward_form')
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
                    ['view', ['undo', 'redo', 'codeview','help']],

                ],
                buttons: {
                    event: EventData
                }
            });
        }
        function getDetailsForm(value){
            if(value == 1){
                $('#plans').show(300);
            }else{
                $('#plans').hide(300);
            }
        }
        function createLetter(){
            $('#create_letter_form').toggle(300);
            if($('#create_icon').hasClass('fa-plus')){
                $('#create_icon').addClass('fa-minus')
            }
            if($('#create_icon').hasClass('fa-minus')){
                $('#create_icon').addClass('fa-plus')
            }
        }

        function getUserInfo(value) {
           if(value != ''){
                $.ajax({
                    url:'{{ route('user/Info') }}',
                    type: "post",
                    data: {'id':value, '_token':$('meta[name=csrf-token]').attr("content")},
                    dataType: "html",
                    success: function(data){
                        let user = JSON.parse(data)
                       $('#designation').val(user.designation);
                       $('#office_address').val(user.address);
                    },
                    error: function (ex) {
                        alert('গ্রুপ পুনরুদ্ধার করতে ব্যর্থ হয়েছে: ' + ex);
                    }
                });
            }else{
               $('#designation').val('');
               $('#address').val('');
           }
        }
        var maxField = 5;
        //Land document dynamic multiple form
        var l = 1;
        $('#add_map_file').click(function(){
            if(l < 15){
                l++;
                $('#add_map').append(`
                   <div class="row form-group">
                        <div class="col-md-5">
                            <input type="file" name="mapFiles[]" class="form-control form-control-sm" accept="image/*,application/pdf">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="mapFilesName[]" class="form-control form-control-sm" placeholder="ফাইল নাম">
                        </div>
                        <div class="col-md-2 ">
                            <button class="btn btn-sm btn-danger" type="button" id="remove_map_file">-</button>
                        </div>
                    </div>
                    `);
            }
        });

        //Once remove button is clicked
        $('#add_map').on('click', '#remove_map_file', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            l--;
        });

        //Land document dynamic multiple form
        var j = 1;
        $('#add_plan').click(function(){
            if(j < maxField){
                j++;
                $('#plans').append(`
                   <div class="row form-group">
                       <div class="col-md-5">
                            <input type="file" name="dev_plans[]" class="form-control form-control-sm" accept="image/*,application/pdf">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="dev_plansName[]" class="form-control form-control-sm" placeholder="ফাইল নাম">
                        </div>
                        <div class="col-md-2 ">
                            <button class="btn btn-sm btn-danger" type="button" id="remove_plan">-</button>
                        </div>
                    </div>
                    `);
            }
        });

        //Once remove button is clicked
        $('#plans').on('click', '#remove_plan', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            j--;
        });

        var f = 1;


        $('#add_file').click(function(){
            if(f < 15){
                f++;
                $('#multi_file').append(`
                <div class="row" >
                    <div class="form-group col-md-6">
                        <input name="v_files[]" type="file" class="form-control form-control-sm form-control-file">
                    </div>
                    <div class="form-group col-md-5">
                        <input name="file_names[]" type="text" class="form-control form-control-sm" placeholder="ফাইল নাম">
                    </div>
                    <div class="form-group col-md-1 p-0">
                        <button class="btn btn-danger btn-sm" type="button" id="remove_file"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
            `);
            }
        });

        //Once remove button is clicked
        $('#multi_file').on('click', '#remove_file', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            f--;
        });

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
    @include('user.inc.letter_create_js')
@endsection

