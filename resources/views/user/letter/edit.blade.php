@extends('layouts.master')
@section('title', 'চিঠি সম্পাদন')
@section('content')
    <p class="m-0 text-black-50">চিঠি সম্পাদন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
       <div class="col-md-10 offset-1">
           <div class="card">
               <div class="card-header">
                  <div class="row">
                      <div class="col-md-6 card-title mb-0">
                          চিঠি সম্পাদন
                      </div>
                      <div class="col-md-6 text-right">
                          @if($hit == 'list')
                              <a href="{{ route('letter', ['id' => encrypt($app_id), 'type' => $type]) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> চিঠি সমূহ</a>
                          @else
                              <a href="{{ route('application/forward', ['id' => encrypt($app_id), 'type' => $type]) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-up"></i> ফিরে যান</a>
                          @endif
                      </div>
                  </div>
               </div>
               <div class="card-body p-4">
               @include('includes.message')<!-- Message template -->
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('letter/update', ["id" => encrypt($issue_letter->id), "app_id" => encrypt($issue_letter->application_id), 'type' => $type, 'hit' => $hit]) }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-form-label-sm col-sm-2 text-right" for="letter_type">চিঠির ধরণ<small class="text-danger">*</small></label>
                                    <select class="form-control form-control-sm col-sm-9" name="letter_type_id" id="letter_type" required onchange="getForm(this.value)">
                                        <option value="">-নির্বাচন-</option>
                                        @foreach($letter_types as $letterType)
                                            <option value="{{ $letterType->id }}" {{ $issue_letter->letter_type_id == $letterType->id ? 'selected' : ''}}>{{ $letterType->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->has('letter_type_id') ? $errors->first('letter_type_id') : '' }}</span>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label-sm col-sm-2 text-right" for="subject">বিষয়ঃ<small class="text-danger">*</small></label>
                                    <input type="text" name="subject" id="subject" class="form-control form-control-sm col-sm-9" required value="{{  $issue_letter->subject }}">
                                    <span class="text-danger">{{ $errors->has('subject') ? $errors->first('subject') : '' }}</span>
                                </div>

                                <div id="laws" @if($issue_letter->letter_type_id != 4) style="display: none;" @endif>
                                    <div class="form-group row">
                                        <label class="col-form-label-sm col-sm-2 text-right" for="subject">নামঃ<small class="text-danger">*</small></label>
                                        <input type="text" name="name" id="name" class="form-control form-control-sm col-sm-9" value="{{ $issue_letter->name }}">
                                        <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label-sm col-sm-2 text-right" for="subject">ঠিকানাঃ<small class="text-danger">*</small></label>
                                        <textarea name="address" id="address" class="form-control form-control-sm col-sm-9" >{{ $issue_letter->address }}</textarea>
                                        <span class="text-danger">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                    </div>
                                   @if(count($issue_letter->letter_laws) > 0)
                                        @foreach($issue_letter->letter_laws as $i => $law)
                                            <div class="form-group row">
                                                <label class="col-form-label-sm col-sm-2 text-right" for="law">সূত্রঃ<small class="text-danger">*</small></label>
                                                <input type="text" class="col-sm-9 form-control form-control-sm law" name="law[]" id="law" value="{{ $law->law_name }}">
                                                <div class="col-sm-1 text-left">
                                                    @if($i == 0)
                                                        <button class="btn btn-success btn-sm add" type="button" title="অধিক...">+</button>
                                                    @else
                                                        <button class="btn btn-danger btn-sm remove" type="button" title="মুছে ফেলুন">-</button>
                                                    @endif

                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="form-group row">
                                            <label class="col-form-label-sm col-sm-2 text-right" for="law">সূত্রঃ<small class="text-danger">*</small></label>
                                            <input type="text" class="col-sm-9 form-control form-control-sm law" name="law[]" id="law" >
                                            <div class="col-sm-1 text-left">
                                                <button class="btn btn-success btn-sm add" id="add" type="button" title="অধিক...">+</button>
                                            </div>
                                        </div>
                                   @endif

                                </div>

                                <div id="dynamic_form">
                                    @if($issue_letter->letter_type_id == 1)
                                        <div class="form-group row">
                                            <label class="col-form-label-sm col-sm-2 text-right">সমস্যাকৃত ডকুমেন্ট<small class="text-danger">*</small></label>
                                           <div class="col-sm-9 m-0">
                                               @foreach($document_types as $document_type)
                                                   <div class="form-check">
                                                       <input class="form-check-input" type="checkbox" name="document_type_id[]" value="{{ $document_type->id }}" id="document_type{{ $document_type->id }}" @if(!empty($problem_papers->where('document_type_id', $document_type->id)->first())) checked @endif>
                                                       <label class="form-check-label" for="document_type{{ $document_type->id }}">
                                                           {{ $document_type->name }}
                                                       </label>
                                                   </div>
                                               @endforeach
                                           </div>
                                        </div>
                                    @endif
                                    @if($issue_letter->letter_type_id == 2)
                                            <div class="form-group row">
                                                <label for="implement_project" class="col-form-label-sm col-sm-2 text-right">প্রকল্প <small class="text-danger">*</small></label>
                                                <select class="form-control-sm form-control col-sm-9" name="implement_project" id="implement_project" required>
                                                    <option value="">-নির্বাচন করুন-</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->id }}" {{  $issue_letter->betterment_fee->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        <div class="form-group row">
                                            <label for="road_section" class="col-form-label-sm col-sm-2 text-right">রাস্তার পরিমাণ <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control-sm form-control col-sm-9" name="road_section" id="road_section" required value="{{ $issue_letter->betterment_fee->road_section }}">
                                        </div>
                                        <div class="form-group row">
                                            <label for="betterment_fee" class="col-form-label-sm col-sm-2 text-right">উৎকর্ষ ফি <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control-sm form-control col-sm-9" name="betterment_fee" id="betterment_fee" required value="{{ \App\Http\Helpers\Helper::ConvertToBangla($issue_letter->betterment_fee->betterment_fee)  }}">
                                        </div>
                                        <div class="form-group mb-1 row">
                                            <div class="col-2">

                                            </div>
                                            <div class="col-10 form-check">
                                                <input type="checkbox" name="promise" class="form-check-input" id="promise" {{ $issue_letter->betterment_fee->is_promise_required == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label " for="promise">অঙ্গিকার নামা দিতে হবে কি?</label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group row" id="date" @if($issue_letter->letter_type_id == 4 || $issue_letter->letter_type_id == 3) style="display: none" @endif>
                                    <label for="expired_date" class="col-form-label-sm col-sm-2 text-right">মেয়াদ শেষ হওয়া তারিখ<small class="text-danger">*</small></label>
                                    <input type="text" class="form-control-sm form-control datePicker col-sm-9" name="expired_date" id="expired_date" required value="{{ $issue_letter->expired_date }}">
                                    <span class="text-danger">{{ $errors->has('expired_date') ? $errors->first('expired_date') : '' }}</span>
                                </div>
                                <div class="form-group row">
                                    <label for="message" class="col-form-label-sm col-sm-2 text-right">অনুচ্ছেদঃ</label>
                                    <textarea class="form-control form-control-sm col-sm-9" name="message" id="message">{{ $issue_letter->message }}</textarea>
                                    <span class="text-danger">{{ $errors->has('message') ? $errors->first('message') : '' }}</span>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-11 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary" id="submit_btn"><i class="fas fa-edit"></i> সম্পাদন করুন</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
               </div>
           </div>
       </div>
    </div>
@endsection
@section('script')
    <script>

        function getForm(value)
        {
            ResetForm();
            if (value != ''){
                $( "#submit_btn" ).prop( "disabled", false );
               if(value == '1')
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

               if (value == '2'){
                    $('#dynamic_form').append(`
                         <div class="form-group row">
                            <label for="implement_project" class="col-form-label-sm col-sm-2 text-right">প্রকল্প বাস্তবায়ন <small class="text-danger">*</small></label>
                            <input type="text" class="form-control-sm form-control col-sm-9" name="implement_project" id="implement_project" required>
                         </div>
                        <div class="form-group row">
                            <label for="road_section" class="col-form-label-sm col-sm-2 text-right">রাস্তার পরিমাণ <small class="text-danger">*</small></label>
                            <input type="text" class="form-control-sm form-control col-sm-9" name="road_section" id="road_section" required>
                        </div>
                        <div class="form-group row">
                            <label for="betterment_fee" class="col-form-label-sm col-sm-2 text-right">উৎকর্ষ ফি <small class="text-danger">*</small></label>
                            <input type="text" class="form-control-sm form-control col-sm-9" name="betterment_fee" id="betterment_fee" required>
                        </div>
                    `)
               }
                if (value == '5'){
                    $('#dynamic_form').empty();
                    $('#laws').show(300);
                    AddRequiredAttr('.law');
                    AddRequiredAttr('#name');
                    AddRequiredAttr('#address');
                    $('#date').hide(300);
                    RemoveRequiredAttr('#expired_date');
                }else{
                    $('#laws').hide(300);
                    RemoveRequiredAttr('.law');
                    RemoveRequiredAttr('#name');
                    RemoveRequiredAttr('#address');
                    AddRequiredAttr('#expired_date');
                    $('#date').show(300);
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
            AddRequiredAttr('#expired_date');
            $('#date').show(300);
        }

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function() {
            $('#message').summernote({
                tabsize: 3,
                height: 150
            });

            var maxField = 5;
            //Land document dynamic multiple form
            var l = @if(count($issue_letter->letter_laws) > 0) {{ count($issue_letter->letter_laws) }} @else 1 @endif;
            $('.add').click(function(){
                if(l < maxField){
                    l++;
                    $('#laws').append(`
                    <div class="form-group row">
                                   <label class="col-form-label-sm col-sm-2 text-right" for="subject">সূত্রঃ<small class="text-danger">*</small></label>
                                   <input type="text" class="col-sm-9 form-control form-control-sm law" name="law[]" required>
                                   <div class="col-sm-1 text-left">
                                       <button class="btn btn-danger btn-sm remove" type="button" title="মুছে ফেলুন">-</button>
                                   </div>
                               </div>
                    `);
                }
            });

            //Once remove button is clicked
            $('#laws').on('click', '.remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                l--;
            });
        });
    </script>

@endsection
