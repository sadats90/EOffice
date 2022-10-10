<form @if($app->is_submit == 0) action="{{ route('applicant/applications/Store/LandInfo', ['app_id'=> encrypt($application_id)]) }}" method="POST" @endif class="mt-2" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-md-6">
            <label for="input6" class="col-form-label text-right">বিভাগঃ <span class="text-danger">*</span></label>
            <input name="district" value="রাজশাহী" type="text" class="form-control" id="input6"  readonly>
            <span class="text-danger">{{ $errors->has('district') ? $errors->first('district') : '' }}</span>
        </div>

        <div class="col-md-6">
            <label for="division" class="col-form-label text-right">জেলাঃ <span class="text-danger">*</span></label>
            <input name="division" value="রাজশাহী" type="text" class="form-control" id="division"  readonly>
            <span class="text-danger">{{ $errors->has('district') ? $errors->first('district') : '' }}</span>
        </div>

        <div class="col-md-6">
            <label for="input9" class="col-form-label text-right">জমির বর্তমান ব্যবহার <span class="text-danger">*</span></label>
            <select name="land_currently_use" class="form-control" required="required" id="input9" @if($app->is_submit == 1) disabled="disabled" @endif>
                <option value="">-নির্বাচন করুন-</option>
                @foreach($pluts as $plut)
                    <option value="{{ $plut->id }}" @if(!empty($land_info)) @if($land_info->land_currently_use == $plut->id) selected @endif @endif>{{ $plut->plut_name }}</option>
                @endforeach
            </select>
            <span class="text-danger">{{ $errors->has('land_currently_use') ? $errors->first('land_currently_use') : '' }}</span>
        </div>
        <div class="col-md-6">
            <label for="land_future_use" class="col-form-label text-right">জমির ভবিষ্যৎ ব্যবহার <span class="text-danger">*</span></label>
            <select name="land_future_use" class="form-control" id="land_future_use" disabled="disabled">
                <option value="">{{__('applicant.select')}}</option>
                @foreach($fluts as $flut)
                    <option value="{{ $flut->id }}" @if(!empty($land_info)) @if($land_info->land_future_use == $flut->id) selected @endif @endif>{{ $flut->flut_name }}</option>
                @endforeach
            </select>
            <span class="text-danger">{{ $errors->has('land_future_use') ? $errors->first('land_future_use') : '' }}</span>
        </div>

        <div class="col-md-6">
            <label for="is_own_project" class="col-form-label text-right">আবেদিত প্লট সরকারী কোন দপ্তরের উন্নয়ন প্রকল্পভুক্ত আবাসিক/বাণিজ্যিক প্লট কি-না?  <span class="text-danger">*</span></label>
            <select name="is_own_project" onchange="changeBehaviour(this.value)" required="required" class="form-control" id="is_own_project" @if($app->is_submit == 1) disabled @endif>
                <option value="">-নির্বাচন করুন-</option>
                <option value="হ্যাঁ" {{ $land_info->is_own_project === 'হ্যাঁ' ? 'selected' : '' }}>হ্যাঁ</option>
                <option value="না" {{ $land_info->is_own_project === 'না' ? 'selected' : '' }}>না</option>
            </select>
            <span class="text-danger">{{ $errors->has('is_own_project') ? $errors->first('is_own_project') : '' }}</span>
        </div>

        {{--        Yes Section Start         --}}
        <div class="col-md-6" id="project_input">
            <label for="project_id" class="col-form-label text-right">প্রকল্প/এলাকার নাম  <span class="text-danger">*</span></label>
            <select name="project_id" class="form-control" id="project_id" @if($app->is_submit == 1) disabled @endif>
                <option value="">-নির্বাচন করুন-</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @if($land_info->own_project_info != null) {{ $land_info->own_project_info->project_id == $project->id ? 'selected' : '' }} @endif>{{ $project->name }}</option>
                @endforeach
            </select>
            <span class="text-danger">{{ $errors->has('project_id') ? $errors->first('project_id') : '' }}</span>
        </div>
        <div class="col-md-6" id="plot_input">
            <label for="plot_no" class="col-form-label text-right">প্লট নং <span class="text-danger">*</span></label>
            <input name="plot_no" @if($land_info->own_project_info != null) value="{{ $land_info->own_project_info->plot_no }}" @endif type="text" class="form-control" id="plot_no" @if($app->is_submit == 1) readonly @endif>
            <span class="text-danger">{{ $errors->has('area_name') ? $errors->first('area_name') : '' }}</span>
        </div>
        <div class="col-md-12 card mt-2 ml-2" id="land_info_group">
            <div class="card-body p-0 pb-2" id="infos">
                @if($land_info->not_own_project_info != null)
                    @foreach($land_info->not_own_project_info->not_own_project_extra_infos as $i => $info)
                        <div class="row">
                            <div class="col-md-3">
                                <label for="upazila_id" class="col-form-label text-right">উপজেলাঃ<span class="text-danger">*</span></label>
                                <select name="upazila_id[]" class="select2" id="upazila_id" onchange="getMouzaAreas(this.value, `10{{ $i }}`)" @if($app->is_submit == 1) disabled @endif>
                                    <option value="">-নির্বাচন করুন-</option>
                                    @foreach($upazilas as $thana)
                                        <option value="{{ $thana->id }}" @if($land_info->not_own_project_info != null) @if($info->mouzaArea->upazila_id == $thana->id) selected @endif @endif>{{ $thana->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->has('upazila_id') ? $errors->first('upazila_id') : '' }}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="mouza_area_id_{{ $i }}" class="col-form-label text-right">মৌজা/এলাকা  <span class="text-danger">*</span></label>
                                <select name="mouza_area_id[]" onchange="getJlNumber(this.value, '10_{{ $i }}')" class="select2 mouza_area_id" id="mouza_area_id_{{ $i }}" @if($app->is_submit == 1) disabled @endif>
                                    <option value="">-নির্বাচন করুন-</option>
                                    @foreach($info->mouzaAreas as $mouzaArea)
                                        <option value="{{ $mouzaArea->id }}" {{ $info->mouza_area_id ==  $mouzaArea->id ? 'selected' : ''}}>{{ $mouzaArea->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->has('mouza_area_id') ? $errors->first('mouza_area_id') : '' }}</span>
                            </div>
                            <div class="col-md-2">
                                <label for="jl_no" class="col-form-label text-right">জে.এল</label>
                                <input name="jl_no" type="text" value="{{ $info->mouzaAreas->find($info->mouza_area_id)->jl_name }}" class="form-control" id="jl_no_{{ $i }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="rs_line_no" class="col-form-label text-right">আর এস দাগ নং</label>
                                <input name="rs_line_no[]" type="text" class="form-control" value="{{ $info->rs_line_no }}" id="rs_line_no" @if($app->is_submit == 1) readonly @endif>
                                <span class="text-danger">{{ $errors->has('rs_line_no') ? $errors->first('rs_line_no') : '' }}</span>
                            </div>
                            <div class="col-md-1">
                                @if($i == 0)
                                    <button class="btn btn-success" style="margin-top: 40px" id="add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                                @else
                                    <button class="btn btn-danger" style="margin-top: 40px" id="remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছুন...">-</button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row">
                        <div class="col-md-3">
                            <label for="upazila_id" class="col-form-label text-right">উপজেলাঃ<span class="text-danger">*</span></label>
                            <select name="upazila_id[]" class="form-control select2" id="upazila_id" onchange="getMouzaAreas(this.value, '100')" @if($app->is_submit == 1) disabled @endif>
                                <option value="">-নির্বাচন করুন-</option>
                                @foreach($upazilas as $thana)
                                    <option value="{{ $thana->id }}" @if($land_info->not_own_project_info != null) @if($land_info->not_own_project_info->upazila_id == $thana->id) selected @endif @endif>{{ $thana->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->has('upazila_id') ? $errors->first('upazila_id') : '' }}</span>
                        </div>
                        <div class="col-md-3">
                            <label for="mouza_area_id_100" class="col-form-label text-right">মৌজা/এলাকা  <span class="text-danger">*</span></label>
                            <select name="mouza_area_id[]" onchange="getJlNumber(this.value, 100)" class="select2 mouza_area_id " id="mouza_area_id_100" disabled @if($app->is_submit == 1) disabled @endif>
                                <option value="">-নির্বাচন করুন-</option>
                            </select>
                            <span class="text-danger">{{ $errors->has('mouza_area_id') ? $errors->first('mouza_area_id') : '' }}</span>
                        </div>
                        <div class="col-md-2">
                            <label for="jl_no" class="col-form-label text-right">জেএল</label>
                            <input name="jl_no" type="text" class="form-control" id="jl_no_100" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="rs_line_no" class="col-form-label text-right">আর এস দাগ নং</label>
                            <input name="rs_line_no[]" value="@if(!empty($land_info)){{ $land_info->rs_line_no }}@endif" type="text" class="form-control" id="rs_line_no" @if($app->is_submit == 1) readonly @endif>
                            <span class="text-danger">{{ $errors->has('rs_line_no') ? $errors->first('rs_line_no') : '' }}</span>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-success" style="margin-top: 40px" id="add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <label for="land_amount" class="col-form-label text-right">জমির পরিমান (একর)<span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <input id="land_amount" type="text" value="{{ \App\Http\Helpers\Helper::ConvertToBangla($land_info->land_amount)}}" oninput="calculationAcresToKatha(this.value, 'land_amount_katha')" class="form-control" placeholder="" name="land_amount" required  @if($app->is_submit == 1) disabled="disabled" @endif>
                <div class="input-group-append">
                    <span class="input-group-text" id="land_amount_katha">০.০০০ কাঠা</span>
                </div>
            </div>
            <span class="text-danger">{{ $errors->has('land_amount') ? $errors->first('land_amount') : '' }}</span>
        </div>
        <div class="col-md-6" id="is_acquisition_input">
            <label for="is_acquisition" class="col-form-label text-right">আবেদিত জমি হতে সরকারী কোন সংস্থা কর্তৃক জমি অধিগ্রহণ হয়েছে কি না (হ্যাঁ/না)  <span class="text-danger">*</span></label>
            <select name="is_acquisition" onchange="changeBehaviourForAcquisition(this.value)" class="form-control" id="is_acquisition" @if($app->is_submit == 1) disabled @endif>
                <option value="">-নির্বাচন করুন-</option>
                <option value="হ্যাঁ" @if($land_info->not_own_project_info != null) {{ $land_info->not_own_project_info->is_acquisition == 'হ্যাঁ' ? 'selected' : '' }} @endif>হ্যাঁ</option>
                <option value="না" @if($land_info->not_own_project_info != null) {{ $land_info->not_own_project_info->is_acquisition == 'না' ? 'selected' : '' }} @endif>না</option>
            </select>
            <span class="text-danger">{{ $errors->has('project_id') ? $errors->first('project_id') : '' }}</span>
        </div>

        <div class="col-md-4" id="amount_input">
            <label for="acquisition_land_amount" class="col-form-label text-right">অধিগ্রহনের পরিমান(একর)<span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <input id="acquisition_land_amount" @if($land_info->not_own_project_info != null) value="{{ \App\Http\Helpers\Helper::ConvertToBangla($land_info->not_own_project_info->acquisition_amount) }}" @endif oninput="calculationAcresToKatha(this.value, 'acquisition_land_amount_katha')" type="text" class="form-control"  @if($app->is_submit == 1) disabled="disabled" @endif name="acquisition_land_amount">
                <div class="input-group-append">
                    <span class="input-group-text" id="acquisition_land_amount_katha">০.০০০ কাঠা</span>
                </div>
            </div>
            <span class="text-danger">{{ $errors->has('acquisition_land_amount') ? $errors->first('acquisition_land_amount') : '' }}</span>
        </div>

        <div class="col-md-4" id="rest_input">
            <label for="land_amount_rest" class="col-form-label text-right">অবশিষ্ট জমির পরিমান(একর) <span class="text-danger">*</span></label>
            <div class="input-group">
                <input id="land_amount_rest" type="text" class="form-control" placeholder="" name="land_amount_rest" disabled>
                <div class="input-group-append">
                    <span class="input-group-text" id="land_amount_rest_katha">০ কাঠা</span>
                </div>
            </div>
            <span class="text-danger">{{ $errors->has('land_amount_rest') ? $errors->first('land_amount_rest') : '' }}</span>
        </div>
        <div class="col-md-4" id="acquisition_document_input">
            <label for="acquisition_document" class="col-form-label text-right">অধিগ্রহনের ডকুমেন্ট <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="file" class="col-md-10 form-control" name="acquisition_document" id="acquisition_document" required accept="image/jpg,image/png,image/gif,image/jpeg,.wmf,application/pdf"  @if($app->is_submit == 1) disabled="disabled" @endif>
                @if($land_info->not_own_project_info != null)
                    <div class="input-group-append">
                        <a data-fancybox data-type="iframe" data-src="{{ asset($land_info->not_own_project_info->document_path) }}" href="javascript:;" class="ml-1">
                            <img class="img-fluid img-thumbnail" src="{{ asset('images/file-icon') }}" width="45">
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="input-group mb-3 mt-3 mr-3 justify-content-end">
            @if($app->is_submit == 0)
                <button type="submit" class="btn btn-secondary" style="background-color: #69419f"><i class="mdi mdi-cloud"></i> সংরক্ষন করুন</button>
            @endif
            @if($app->is_submit == 1)
                <button class="btn btn-success" disabled="disabled"> জমির তথ্য সংরক্ষন করুন</button>
            @endif
        </div>
    </div>
</form>

<script>
    const yesSection = ['project_input', 'plot_input'];
    const yesInputs = ['project_id', 'plot_no'];

    const noSection = ['upazila_input', 'land_info_group', 'is_acquisition_input'];
    const noInputs = ['upazila_id', 'mouza_area_id', 'rs_line_no', 'is_acquisition'];

    const acquisitionSection = ['amount_input', 'rest_input', 'acquisition_document_input'];
    const acquisitionInputs = ['acquisition_land_amount', 'acquisition_document'];

    $(document).ready(function (){
        const landInfo = {!! $land_info_json !!};
        calculationAcresToKatha(landInfo.land_amount ?? 0, 'land_amount_katha');
        if(landInfo.is_own_project !== null){
            if(landInfo.is_own_project === 'হ্যাঁ'){
                show(yesSection);
                addRequiredAttr(yesInputs);
                hide(noSection.concat(acquisitionSection));
            }else{
                hide(yesSection);
                removeRequiredAttr(yesInputs);

                show(noSection);
                addRequiredAttr(noInputs);

                const notOwnProjectInfo = {!! $not_own_project_info !!};
                if(notOwnProjectInfo.is_acquisition === 'হ্যাঁ'){
                    show(acquisitionSection);
                    addRequiredAttr(acquisitionInputs);
                    calculationAcresToKatha(notOwnProjectInfo.acquisition_amount, 'acquisition_land_amount_katha')
                }else{
                    hide(acquisitionSection);
                    removeRequiredAttr(acquisitionInputs);
                }
            }
        }else{
            hide(yesSection.concat(noSection, acquisitionSection));
        }

    });


    const changeBehaviour = value => {
        if(value === ''){
            hide(yesSection.concat(noSection.concat(acquisitionSection)));
            removeRequiredAttr(yesInputs.concat(noInputs.concat(acquisitionInputs)));
        }

        if(value === 'হ্যাঁ'){
            show(yesSection);
            hide(noSection.concat(acquisitionSection));

            addRequiredAttr(yesInputs);
            removeRequiredAttr(noInputs.concat(acquisitionInputs));
        }

        if(value === 'না'){
            show(noSection);
            hide(yesSection);

            removeRequiredAttr(yesInputs);
            addRequiredAttr(noInputs);
        }
    };

    const changeBehaviourForAcquisition = value => {
        if(value === ''){
            hide(acquisitionSection);
            removeRequiredAttr(acquisitionInputs);
        }

        if(value === 'হ্যাঁ'){
            show(acquisitionSection);
            addRequiredAttr(acquisitionInputs);
        }
        if(value === 'না'){
            hide(acquisitionSection);
            removeRequiredAttr(acquisitionInputs);
        }
    };

    let show = elements => {
        elements.map((item) =>{
            $('#'+item).show();
        });
    };

    const addRequiredAttr = elements => {
        elements.map((item) =>{
            $('#'+item).attr('required', 'required');
        });
    };

     const removeRequiredAttr = elements => {
            elements.map((item) =>{
                $('#'+item).removeAttr('required');
            });
        };

    const hide = (elements) => {
        elements.map((item) =>{
            $('#'+item).hide();
        });
    }

    const getJlNumber = (value, indicator) => {
        if(value !== ''){
            const jl = areas.filter(x => x.id === Number(value));
            $(`#jl_no_${indicator}`).val(jl[0].jl_name);
        }else{
            $(`#jl_no_${indicator}`).val('');
        }
    }

    const getMouzaAreas = (value, identity) => {
        let elements = $(`#mouza_area_id_${identity}`);
        elements.attr('disabled', true);
        $(`#jl_no_${identity}`).val('');
        if(value !== ''){
            elements.empty();
            elements.append('<option value="">-লোড হচ্ছে-</option>')
            $.ajax({
                url:'{{ route('MouzaAreas/ByUpazilaId') }}',
                type: "post",
                data: {'id':value, '_token':$('meta[name=csrf-token]').attr("content")},
                dataType: "html",
                success: function(data){
                    let areaItems = JSON.parse(data)
                    areas = areaItems;
                    if(areaItems.length > 0){
                        elements.attr('disabled', false);
                        elements.empty();
                        elements.append('<option value="">-নির্বাচন করুন-</option>');
                        areaItems.map(item => {
                            elements.append(`<option value="${item.id}">${item.name} (${item.jl_name})</option>`)
                        })
                    }else{
                        elements.empty();
                        elements.append('<option value="">-নির্বাচন করুন-</option>')
                    }
                },
                error: function (ex) {
                    alert('গ্রুপ পুনরুদ্ধার করতে ব্যর্থ হয়েছে: ' + ex);
                }
            });
        }else{
            elements.empty();
            elements.append('<option value="">-নির্বাচন করুন-</option>')
        }
    }

    const calculationAcresToKatha = (value, setValueId) => {
        $(`#${setValueId}`).text(`${convertEnglishToBanglaNumber(convertAcresToKatha(value).toFixed(3))} কাঠা`);
        calculateRestAmountOfLand();
    }

    const convertAcresToKatha = (value) => {
        value = convertBanglaToEnglishNumber(value);
        return (1 / 0.0165) * Number(value);
    }

    const calculateRestAmountOfLand = () => {
        const totalAmountOfLand = Number(convertBanglaToEnglishNumber($('#land_amount').val()));
        const acquisitionAmountOfLand = Number(convertBanglaToEnglishNumber($('#acquisition_land_amount').val()));

        if(totalAmountOfLand >= acquisitionAmountOfLand){
            $('#land_amount_rest').val(convertEnglishToBanglaNumber(totalAmountOfLand - acquisitionAmountOfLand));
            $('#land_amount_rest_katha').text(`${convertEnglishToBanglaNumber(convertAcresToKatha(totalAmountOfLand - acquisitionAmountOfLand).toFixed(3).toString())} কাঠা`)
        }else{
            alert('অধিগ্রহণ জমির পরিমান মোট জমির পরিমান এর চাইতে কম হতে হবে');
            $(`#acquisition_land_amount_katha`).text(`০.০০০ কাঠা`);
            $('#acquisition_land_amount').val(convertEnglishToBanglaNumber(0));
        }

    }

    let maxField = 5;
    //Land document dynamic multiple form
    let l = 1;
    $('#add').click(function(){

        if(l < maxField){
            l++;
            $('#infos').append(`
                 <div class="row">
                         <div class="col-md-3">
                            <label for="upazila_id" class="col-form-label text-right">উপজেলাঃ<span class="text-danger">*</span></label>
                            <select name="upazila_id[]" class="select2" id="upazila_id" onchange="getMouzaAreas(this.value, ${l})" @if($app->is_submit == 1) disabled @endif>
                                <option value="">-নির্বাচন করুন-</option>
                                @foreach($upazilas as $thana)
                            <option value="{{ $thana->id }}" @if($land_info->not_own_project_info != null) @if($land_info->not_own_project_info->upazila_id == $thana->id) selected @endif @endif>{{ $thana->name }}</option>
                                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->has('upazila_id') ? $errors->first('upazila_id') : '' }}</span>
                      </div>
                      <div class="col-md-3">
                       <label for="mouza_area_id_${l}" class="col-form-label text-right">মৌজা/এলাকা  <span class="text-danger">*</span></label>
                       <select name="mouza_area_id[]" onchange="getJlNumber(this.value, ${l})" disabled class="select2 mouza_area_id" id="mouza_area_id_${l}" @if($app->is_submit == 1) disabled @endif>
                           <option value="">-নির্বাচন করুন-</option>
                       </select>
                       <span class="text-danger">{{ $errors->has('mouza_area_id') ? $errors->first('mouza_area_id') : '' }}</span>
                   </div>
                   <div class="col-md-2">
                       <label for="jl_no" class="col-form-label text-right">জেএল</label>
                       <input name="jl_no" type="text" class="form-control" id="jl_no_${l}" readonly>
                   </div>
                   <div class="col-md-3">
                       <label for="rs_line_no" class="col-form-label text-right">আর এস দাগ নং</label>
                       <input name="rs_line_no[]" value="@if(!empty($land_info)){{ $land_info->rs_line_no }}@endif" type="text" class="form-control" id="rs_line_no" @if($app->is_submit == 1) readonly @endif>
                       <span class="text-danger">{{ $errors->has('rs_line_no') ? $errors->first('rs_line_no') : '' }}</span>
                   </div>
                   <div class="col-md-1">
                       <button class="btn btn-danger" style="margin-top: 40px" id="remove" type="button" data-toggle="tooltip" data-placement="top" title="মুছুন...">-</button>
                   </div>
               </div>`);

            $('.select2').select2();
        }
    });

    //Once remove button is clicked
    $('#infos').on('click', '#remove', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        l--;
    });

    const convertBanglaToEnglishNumber = (str) => {
        let banglaNumber = {
            '০': '0',
            '১': '1',
            '২': '2',
            '৩': '3',
            '৪': '4',
            '৫': '5',
            '৬': '6',
            '৭': '7',
            '৮': '8',
            '৯': '9'
        }
        return convertDigit(banglaNumber, str);
    }

    const convertEnglishToBanglaNumber = (str) => {
        let banglaNumber = {
            '0': '০',
            '1': '১',
            '2': '২',
            '3': '৩',
            '4': '৪',
            '5': '৫',
            '6': '৬',
            '7': '৭',
            '8': '৮',
            '9': '৯'
        }
        return convertDigit(banglaNumber, str);
    }

    const convertDigit = (numbers, str) =>{

        for (let x in numbers) {
            str = str.toString().replace(new RegExp(x, 'g'), numbers[x]);
        }
        return str;
    }

</script>
