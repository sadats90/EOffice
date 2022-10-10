<script>
    function getForm(value)
    {
        ResetForm();
        if (value != ''){
            $( "#submit_btn" ).prop( "disabled", false );
            if(value === '1'){
                $('#dynamic_form').append(`
                       <div class="form-group row">
                           <label class="col-form-label-sm col-sm-2 text-right">সমস্যাকৃত ডকুমেন্ট<small class="text-danger">*</small></label>
                           <div class="col-sm-9">
                             @foreach($document_types as $document_type)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="document_type_id[]" value="{{ $document_type->id }}" id="document_type{{ $document_type->id }}">
                                        <label class="form-check-label" for="document_type{{ $document_type->id }}">
                                        {{ $document_type->name }}
                </label>
            </div>
@endforeach
                </div>
           </div>
`);
            }
            if (value === '2'){
                $('#dynamic_form').append(`
                         <div class="form-group row">
                            <label for="implement_project" class="col-form-label-sm col-sm-2 text-right">প্রকল্প <small class="text-danger">*</small></label>
                            <select class="form-control-sm form-control col-sm-9"name="implement_project" id="implement_project" required>
                            <option value="">-নির্বাচন করুন-</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                            </select>

                         </div>
                        <div class="form-group row">
                            <label for="road_section" class="col-form-label-sm col-sm-2 text-right">রাস্তার পরিমাণ <small class="text-danger">*</small></label>
                            <select class="form-control-sm form-control col-sm-9" name="road_section" id="road_section" required>
                            <option value="">-নির্বাচন করুন-</option>
                            <option value="০-১০০ ফুট">০-১০০ ফুট</option>
                            <option value="১০১-২০০ ফুট">১০১-২০০ ফুট</option>
                            <option value="২০১-৩০০ ফুট">২০১-৩০০ ফুট</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="betterment_fee" class="col-form-label-sm col-sm-2 text-right">উৎকর্ষ ফি <small class="text-danger">*</small></label>
                            <input type="text" class="form-control-sm form-control col-sm-9" name="betterment_fee" id="betterment_fee" required oninput="Calculation()">
                        </div>
                         <div class="form-group row mb-1">
                             <label for="vat" class="col-form-label-sm col-sm-2 text-right">ভ্যাট ({{ \App\Http\Helpers\Helper::ConvertToBangla(\App\Models\Fee::first()->vat) }}%) <small class="text-danger">*</small></label>
                            <input type="text" class="form-control-sm form-control col-sm-9" name="vat" id="vat" required readonly>
                        </div>
                      <div class="form-group mb-1 row">
                           <div class="col-2">

                           </div>
                           <div class="col-10 form-check">
                                <input type="checkbox" name="promise" class="form-check-input" id="promise">
                                <label class="form-check-label " for="exampleCheck1">অঙ্গিকার নামা দিতে হবে কি?</label>
                           </div>
                      </div>

                    `)
            }

            if (value == '3'){
                $('#dynamic_form').empty();
            }else if(value == '4'){
                $('#dynamic_form').empty();
                $('#laws').show(300);
                AddRequiredAttr('.law');
                AddRequiredAttr('#name');
                AddRequiredAttr('#address');

            }else{
                $('#laws').hide(300);
                $('#date').show(300);
                RemoveRequiredAttr('.law');
                RemoveRequiredAttr('#name');
                RemoveRequiredAttr('#address');
            }

        }else{
            ResetForm();
        }
    }


    function AddRequiredAttr(selector){
        $(selector).attr('required', 'required');
    }

    function RemoveRequiredAttr(selector){
        $(selector).removeAttr('required');
    }

    function  ResetForm(){
        $('#dynamic_form').empty();
        $( "#submit_btn" ).prop( "disabled", true );
        $('#laws').hide(300);

        RemoveRequiredAttr('.law');
        RemoveRequiredAttr('#name');
        RemoveRequiredAttr('#address');
    }
    function Calculation(){
        let vat = {{ \App\Models\Fee::first()->vat }};
        $('#vat').val(($('#betterment_fee').val() * vat)/100);
    }


    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });

    $(document).ready(function() {
        $('#message').summernote({
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
        });

        var maxField = 5;
        //Land document dynamic multiple form
        var l = 1;
        $('#add').click(function(){
            if(l < maxField){
                l++;
                $('#laws').append(`
                    <div class="form-group row">
                                   <label class="col-form-label-sm col-sm-2 text-right" for="subject">সূত্রঃ<small class="text-danger">*</small></label>
                                   <input type="text" class="col-sm-9 form-control form-control-sm law" name="law[]" required>
                                   <div class="col-sm-1 text-left">
                                       <button class="btn btn-danger btn-sm" id="remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
            }
        });

        //Once remove button is clicked
        $('#laws').on('click', '#remove', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            l--;
        });
    });
</script>
