<form action="{{ route('Handover/Letter/store', ['id' => $application->id, 'hit' => $hit]) }}" method="post" autocomplete="off">
    @csrf
    <div class="form-group row">
        <label class="col-form-label-sm col-sm-2 text-right" for="letter_type">চিঠির ধরণ<small class="text-danger">*</small></label>
        <select class="form-control form-control-sm col-sm-9 " name="letter_type_id" id="letter_type" required onchange="getForm(this.value)">
            <option value="">-নির্বাচন-</option>
            @foreach($letter_types as $letterType)
                <option value="{{ $letterType->id }}">{{ $letterType->name }}</option>
            @endforeach
        </select>
        <span class="text-danger">{{ $errors->has('letter_type_id') ? $errors->first('letter_type_id') : '' }}</span>
    </div>
    <div class="form-group row">
        <label class="col-form-label-sm col-sm-2 text-right" for="subject">বিষয়ঃ<small class="text-danger">*</small></label>
        <input type="text" name="subject" id="subject" class="form-control form-control-sm col-sm-9" required>
        <span class="text-danger">{{ $errors->has('subject') ? $errors->first('subject') : '' }}</span>
    </div>
    <div id="laws" style="display: none;">
        <div class="form-group row">
            <label class="col-form-label-sm col-sm-2 text-right" for="subject">নামঃ<small class="text-danger">*</small></label>
            <input type="text" name="name" id="name" class="form-control form-control-sm col-sm-9">
            <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
        </div>
        <div class="form-group row">
            <label class="col-form-label-sm col-sm-2 text-right" for="subject">ঠিকানাঃ<small class="text-danger">*</small></label>
            <textarea name="address" id="address" class="form-control form-control-sm col-sm-9" ></textarea>
            <span class="text-danger">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
        </div>
        <div class="form-group row">
            <label class="col-form-label-sm col-sm-2 text-right" for="law">সূত্রঃ<small class="text-danger">*</small></label>
            <input type="text" class="col-sm-9 form-control form-control-sm law" name="law[]" id="law" >
            <div class="col-sm-1 text-left">
                <button class="btn btn-success btn-sm" id="add" type="button" data-toggle="tooltip" data-placement="top" title="অধিক...">+</button>
            </div>
        </div>
    </div>
    <div id="dynamic_form">

    </div>

    <div class="form-group row" id="date">
        <label for="expired_date" class="col-form-label-sm col-sm-2 text-right">মেয়াদ শেষ হওয়া তারিখ<small class="text-danger">*</small></label>
        <input type="text" class="form-control-sm form-control datePicker col-sm-9" name="expired_date" id="expired_date" required placeholder="dd/mm/yy">
        <span class="text-danger">{{ $errors->has('expired_date') ? $errors->first('expired_date') : '' }}</span>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <textarea class="form-control form-control-sm" name="message" id="message"></textarea>
            <span class="text-danger">{{ $errors->has('message') ? $errors->first('message') : '' }}</span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-11 text-right ">
            <button type="submit" class="btn btn-sm btn-primary" id="submit_btn" disabled>তৈরি করুন</button>
        </div>
    </div>
</form>
