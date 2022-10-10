<div class="card">
    <div class="card-header text-right">
        @if($application->is_certificate_make == 1)
            <a href="{{ route('Handover/certificate/reset', ['id' => $application->id]) }}" class="btn btn-sm btn-danger btn-flat confirm-alert"><i class="fas fa-redo-alt"></i> Reset</a>
        @endif
    </div>
    <div class="card-body">
        <form action="{{ route('Handover/certificate', ['id' => $application->id]) }}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-1">
                <label for="certificate_type_id" class="col-form-label col-form-label-sm">সার্টিফিকেটের ধরণ <span class="text-danger">*</span></label>
               @if($application->is_certificate_make == 1)
                   <input type="hidden" name="certificate_type_id" value="{{ $application->certificate->certificate_type_id }}">
                <select class="form-control-sm form-control" disabled>
                   <option value="">-নির্বাচন করুন-</option>
                   @foreach($certificateTypes as $type)
                   <option value="{{ $type->id }}" @if($application->is_certificate_make == 1) {{ $application->certificate->certificate_type_id == $type->id ? 'Selected' : ''}} @endif>{{ $type->name }}</option>
                   @endforeach
               </select>
               @else
                    <select class="form-control-sm form-control" name="certificate_type_id" id="certificate_type_id">
                        <option value="">-নির্বাচন করুন-</option>
                        @foreach($certificateTypes as $type)
                            <option value="{{ $type->id }}" @if($application->is_certificate_make == 1) {{ $application->certificate->certificate_type_id == $type->id ? 'Selected' : ''}} @endif>{{ $type->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
{{--            <div class="form-group mb-1">--}}
{{--                <label for="old_swarok" class="col-form-label col-form-label-sm">পুরাতন স্বারক</label>--}}
{{--                <input type="text" class="form-control form-control-sm" name="old_swarok" id="old_swarok" @if($application->is_certificate_make == 1) value="{{ $application->certificate->old_swarok  }}" @endif>--}}
{{--            </div>--}}
            <div class="card">

                <div class="card-body" id="name_address">
                    @if($application->is_certificate_make == 1)
                        @if($application->certificate->certificate_type_id == 1)
                            <div class="row">
                                @foreach($application->certificate->general_certificate->applicants as $i => $applicant)
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="applicant_name_{{ $i }}" class="col-form-label col-form-label-sm">নাম <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" required name="applicant_names[]" id="applicant_name_{{ $i }}" value="{{ $applicant->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="father_name_{{ $i }}" class="col-form-label col-form-label-sm">পিতা <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-sm" required name="father_names[]" id="father_name_{{ $i }}" value="{{ $applicant->father }}" >
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="village" class="col-form-label col-form-label-sm">সাং <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" required name="village" id="village" value="{{ $application->certificate->general_certificate->village }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="post_office" class="col-form-label col-form-label-sm">ডাকঘর <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm" required name="post_office" id="post_office" value="{{ $application->certificate->general_certificate->post_office }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="thana" class="col-form-label col-form-label-sm">থানা <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" required name="thana" id="thana" value="{{ $application->certificate->general_certificate->thana }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="district" class="col-form-label col-form-label-sm">জেলা <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm" required name="district" id="district" value="{{ $application->certificate->general_certificate->district }}">
                                    </div>
                                </div>

                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="name" class="col-form-label col-form-label-sm">নাম</label>
                                        <input type="text" class="form-control form-control-sm" required name="name" id="name" value="{{ $application->certificate->government->name }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="address" class="col-form-label col-form-label-sm">ঠিকানা</label>
                                        <input class="form-control form-control-sm" required name="address" id="address" value="{{ $application->certificate->government->address }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="form-group mb-1">
                <label for="land_use" class="col-form-label col-form-label-sm">বিষয়<span class="text-danger">*</span></label>
                <textarea class="form-control form-control-sm" name="subject" required id="subject">@if($application->is_certificate_make == 1){{ $application->certificate->subject }}@else রাজশাহী মেট্রোপলিটন ডেভেলপমেন্ট প্ল্যান (২০০৪-২০২৪) অনুযায়ী নিম্ন তফসীল আবেদিত জমি --------------- হিসাবে ব্যবহার্য। @endif</textarea>
            </div>

            <div class="card mb-1" id="law_section" @if($application->is_certificate_make == 1)@if($application->certificate->certificate_type_id == 1) style="display: none;" @endif @else style="display: none;" @endif>
                <div class="card-body ml-1">
                    <label for="user_id" class="col-form-label col-form-label-sm text-dark">সূত্র
                        <span class="text-danger">*</span>
                    </label>
                    <div id="multi_law">
                        @if($application->is_certificate_make == 1)
                           @if($application->certificate->certificate_type_id == 2)
                                @foreach($application->certificate->government->laws as $l_index => $law)
                                    <div class="form-group form-row mb-1">
                                        <input type="text" name="certificate_laws[]" id="certificate_law" placeholder="সূত্র" class="form-control form-control-sm col-11" value="{{ $law->name }}">
                                        <div class="col-1">
                                            @if($l_index == 0)
                                                <button class="btn btn-sm btn-success" id="add_law" type="button"><i class="fas fa-plus"></i></button>
                                            @else
                                                <button class="btn btn-sm btn-danger" id="remove_law" type="button"><i class="fas fa-minus"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                           @endif
                        @else
                            <div class="form-group form-row mb-1">
                                <input type="text" name="certificate_laws[]" id="certificate_law" placeholder="সূত্র" class="form-control form-control-sm col-11">
                                <div class="col-1">
                                    <button class="btn btn-sm btn-success" id="add_law" type="button"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="form-group mb-1">
                <label for="condition" class="col-form-label col-form-label-sm">পালনীয় শর্তাদিসমূহ <span class="text-danger">*</span></label>
                <textarea class="form-control-sm form-control" name="condition" id="condition" required>@if($application->is_certificate_make == 1) {{ $application->certificate->condition_to_be_followed }} @endif</textarea>
            </div>

            <div class="card mb-1" id="ledger_section" @if($application->is_certificate_make == 1)@if($application->certificate->certificate_type_id == 2) style="display: none;" @endif @else style="display: none;" @endif>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <label class="col-form-label col-form-label-sm">জোন <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="zone" id="zone" @if($application->is_certificate_make == 1) @if($application->certificate->certificate_type_id == 1) value="{{ $application->certificate->general_certificate->zone }}" required @endif @endif">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="col-form-label col-form-label-sm">মৌজা <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" name="mouza" id="mouza" @if($application->is_certificate_make == 1) @if($application->certificate->certificate_type_id == 1) value="{{ $application->certificate->general_certificate->mouza }}" required @endif @else value="{{ $application->landInfo->area_name }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="col-form-label col-form-label-sm">দাগ নং (আর.এস.) <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" name="rs_line" id="rs_line" @if($application->is_certificate_make == 1) @if($application->certificate->certificate_type_id == 1) value="{{ $application->certificate->general_certificate->spot_no }}" required @endif @else value="{{ $application->landInfo->rs_plot_no }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="col-form-label col-form-label-sm">জে. এল. নং <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" name="zl_no" id="zl_no" @if($application->is_certificate_make == 1) @if($application->certificate->certificate_type_id == 1) value="{{ $application->certificate->general_certificate->zl_no }}" required @endif @else value="{{ $application->landInfo->jl_section_no }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="col-form-label col-form-label-sm">জমির পরিমান <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" name="land" id="land" @if($application->is_certificate_make == 1) @if($application->certificate->certificate_type_id == 1) value="{{ \App\Http\Helpers\Helper::ConvertToBangla($application->certificate->general_certificate->land_amount) }}" required @endif @else value="{{ \App\Http\Helpers\Helper::ConvertToBangla($application->landInfo->land_amount)}}" @endif>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body ml-1">
                    <label for="user_id" class="col-form-label col-form-label-sm text-dark">সংযুক্তি

                        @if($application->is_certificate_make == 1)
                            @foreach($application->certificate->certificate_attachments as $c_attachment)
                                <a href="{{ asset($c_attachment->path) }}" data-fancybox="gallery" data-caption="verification Attachment">{{ $c_attachment->name }}</a>
                            @endforeach
                        @endif
                    </label>
                    <div id="multi_attachment">
                        <div class="form-group form-row mb-1">
                            <input type="file" class="col-md-5 form-control form-control-sm form-control-file" name="certificate_attach_file[]"/>
                            <input type="text" class="col-md-5 form-control form-control-sm ml-1" placeholder="ফাইল নাম" name="certificate_attach_name[]" />
                            <div class="col-md-1 text-center">
                                <button class="btn btn-sm btn-success" id="add_attachment" type="button"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card mb-1">
                <div class="card-body ml-1">
                    <label for="user_id" class="col-form-label col-form-label-sm text-dark">অনুলিপি প্রাপক</label>
                    <div id="multi">
                        @if($application->is_certificate_make == 1 && count($application->certificate->certificate_duplicates) > 0)
                            @foreach($application->certificate->certificate_duplicates as $d_index => $duplicate)
                                <div class="form-group form-row mb-1 ">
                                    <select class="form-control form-control-sm col-11" name="user_id[]">
                                        <option value="">-বাছাই করুন-</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $duplicate->user_id ? 'selected':'' }}>{{ $user->name }} ({{ $user->designation->name }})</option>
                                        @endforeach
                                    </select>
                                    <div class="col-1">
                                        @if($d_index == 0)
                                            <button class="btn btn-sm btn-success" id="add_user" type="button"><i class="fas fa-plus"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-danger" id="remove_user"><i class="fas fa-minus"></i></button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="form-group form-row mb-1 ">
                                <select class="form-control form-control-sm col-11" name="user_id[]" id="user_id">
                                    <option value="">-বাছাই করুন-</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->designation->name }})</option>
                                    @endforeach
                                </select>
                                <div class="col-1">
                                    <button class="btn btn-sm btn-success" id="add_user" type="button"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-sm btn-primary" type="submit"><i class="fas {{ $application->is_certificate_make == 1 ? 'fa-save' : 'fa-plus' }}"></i> {{ $application->is_certificate_make == 1 ? 'পরিবর্তনগুলোর সংরক্ষন করুন' : 'এনওসি সনদপত্র তৈরি করুন' }}</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function (){
        var htmlUl = `
            @foreach($CertificateTexts as $text)
            <a class="dropdown-item" href="#" role="listitem" data-id="{{ $text->body_text }}">{{ $text->title }}</a>
            @endforeach
        `;
        var EventData = function (context) {
            var layoutInfo = context.layoutInfo;

            var $toolbar = layoutInfo.toolbar;

            var ui = $.summernote.ui;
            var event = ui.buttonGroup([
                ui.button({
                    className: "dropdown-toggle",
                    contents:
                        '<i class="fas fa-spell-check"></i>',
                    tooltip: "Sample Text",
                    data: {
                        toggle: 'dropdown'
                    }
                }),
                ui.dropdown({
                    className: "drop-default summernote-list",
                    contents:htmlUl,
                    callback: function ($dropdown) {
                        $dropdown.find('a').each(function () {
                            $(this).click(function (e) {
                                let text = $(this).data('id');
                                context.invoke('editor.pasteHTML', text);
                                e.preventDefault();
                            });
                        });
                    },
                }),
            ]);

            this.$button = event.render();
            $toolbar.append(this.$button);
        }

        $('#condition').summernote({
            tabsize: 3,
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['eventButton', ['event']],
                ['view', ['codeview','help']],
            ],
            buttons: {
                event: EventData
            }
        });


        let name_address_for_general = ` <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="applicant_name" class="col-form-label col-form-label-sm">নাম</label>
                                <input type="text" class="form-control form-control-sm" required name="applicant_names[]" id="applicant_name" value="{{ $application->user->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="father_name" class="col-form-label col-form-label-sm">পিতা</label>
                                <input class="form-control form-control-sm" required name="father_names[]" id="father_name" value="{{ $application->personalInfo->fname }}" >
                            </div>
                        </div>
                        @foreach($application->personalInfo->applicants as $i => $applicant)
        <div class="col-md-6">
            <div class="form-group mb-1">
                <label for="applicant_name_{{ $i }}" class="col-form-label col-form-label-sm">নাম</label>
                                <input type="text" class="form-control form-control-sm" required name="applicant_names[]" id="applicant_name_{{ $i }}" value="{{ $applicant->applicant_name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="father_name_{{ $i }}" class="col-form-label col-form-label-sm">পিতা</label>
                                <input class="form-control form-control-sm" required name="father_names[]" id="father_name_{{ $i }}" value="{{ $applicant->father_name }}" >
                            </div>
                        </div>
                        @endforeach
        <div class="col-md-6">
            <div class="form-group mb-1">
                <label for="village" class="col-form-label col-form-label-sm">সাং</label>
                <input type="text" class="form-control form-control-sm" required name="village" id="village" value="{{ $application->personalInfo->ta_area }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="post_office" class="col-form-label col-form-label-sm">ডাকঘর</label>
                                <input class="form-control form-control-sm" required name="post_office" id="post_office" value="{{ $application->personalInfo->ta_post }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="thana" class="col-form-label col-form-label-sm">থানা</label>
                                <input type="text" class="form-control form-control-sm" required name="thana" id="thana" value="{{ $application->personalInfo->ta_thana }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="district" class="col-form-label col-form-label-sm">জেলা</label>
                                <input class="form-control form-control-sm" required name="district" id="district" value="{{ $application->personalInfo->ta_district }}">
                            </div>
                        </div>

                    </div>`;
        let name_address_for_govt = ` <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <label for="name" class="col-form-label col-form-label-sm">নাম</label>
                                <input type="text" class="form-control form-control-sm" required name="name" id="name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <label for="address" class="col-form-label col-form-label-sm">ঠিকানা</label>
                                <input class="form-control form-control-sm" required name="address" id="address">
                            </div>
                        </div>
                    </div>`;

        $('#certificate_type_id').change(function (){
            let value = $(this).val();

            $('#ledger_section').hide(300);

            RemoveRequiredAttr('#zone');
            RemoveRequiredAttr('#mouza');
            RemoveRequiredAttr('#rs_line');
            RemoveRequiredAttr('#zl_no');
            RemoveRequiredAttr('#land');
            RemoveRequiredAttr('#certificate_law');

            $('#law_section').hide(300);
            $('#name_address').empty()
            if(value == 1){
                $('#name_address').html(name_address_for_general)
                $('#ledger_section').show(300);
                AddRequiredAttr('#zone');
                AddRequiredAttr('#mouza');
                AddRequiredAttr('#rs_line');
                AddRequiredAttr('#zl_no');
                AddRequiredAttr('#land');
            }
            if(value == 2){

                $('#name_address').html(name_address_for_govt)
                $('#law_section').show(300);
                AddRequiredAttr('#certificate_law');
            }

        });

        function AddRequiredAttr(selector){
            $(selector).attr('required', 'required');
        }

        function RemoveRequiredAttr(selector){
            $(selector).removeAttr('required');
        }

        var j = 1;
        $('#add_user').click(function(){
            if(j < 15){
                j++;
                $('#multi').append(`
                  <div class="form-group form-row mb-1">
                   <select class="form-control form-control-sm col-11" name="user_id[]" id="user_id">
                       <option value="">-বাছাই করুন-</option>
                       @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->designation->name }})</option>
                       @endforeach
                </select>
                <div class="col-1">
                    <button class="btn btn-sm btn-danger" id="remove_user"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            `);
            }
        });

        //Once remove button is clicked
        $('#multi').on('click', '#remove_user', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            j--;
        });

        var k = 1;
        $('#add_law').click(function(){
            if(k < 5){
                k++;
                $('#multi_law').append(`
                  <div class="form-group form-row mb-1">
                   <input type="text" name="certificate_laws[]" placeholder="সূত্র" class="form-control form-control-sm col-11">
                    <div class="col-1">
                        <button class="btn btn-sm btn-danger" id="remove_law"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
            `);
            }
        });

        //Once remove button is clicked
        $('#multi_law').on('click', '#remove_law', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            k--;
        });

        var at = 1;
        $('#add_attachment').click(function(){
            if(at < 5){
                at++;
                $('#multi_attachment').append(`
                  <div class="form-group form-row mb-1">
                   <input type="file" class="col-md-5 form-control form-control-sm form-control-file" name="certificate_attach_file[]">
                     <input type="text" class="col-md-5 form-control form-control-sm ml-1" placeholder="ফাইল নাম" name="certificate_attach_name[]">
                    <div class="col-1 text-center">
                        <button class="btn btn-sm btn-danger" id="remove_attachment"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
            `);
            }
        });

        //Once remove button is clicked
        $('#multi_attachment').on('click', '#remove_attachment', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            at--;
        });
    });
</script>
