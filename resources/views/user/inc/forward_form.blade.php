
<form autocomplete="off" action="{{ route('application/forward/Create', ['id' => encrypt($application->id), 'type' => $type]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-8">
                    <label class="col-form-label" for="message">
                        <strong class="text-primary">{{ \App\Http\Helpers\Helper::ConvertToBangla($messageNo + 1) }} নং অনুচ্ছেদঃ</strong>
                    </label>

                </div>
                <div class="col-md-4 text-right mb-2">
                    <button class="btn btn-primary btn-sm" onclick="return ShowInPopUp('{{ route("attachment/add", ["id" => $application->id]) }}', 'সংযুক্তি যোগ')" type="button"><i class="fas fa-plus"></i> পতাকা যোগ করুন</button>
                </div>
                <div class="col-sm-12">
                    <textarea name="message" class="form-control form-control-sm message" id="message" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-form-label" for="forward_to">প্রেরণ করুণ <span class="text-danger">*</span></label>
                <select name="forward_to" id="forward_to" class="form-control select2" required onchange="getUserInfo(this.value)">
                    <option value="">-বাছাই করুণ-</option>
                    @foreach($forward_users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->designation->name }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label" for="expired-date">পদবী</label>
                    <input type="text" name="designation" class="form-control" id="designation" readonly>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label" for="expired-date">অফিসের ঠিকানা</label>
                    <input name="address" type="text" class="form-control" id="office_address" readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-outline-primary"  @if($application->is_new == 1)@if($application->is_report_initiate == 0) disabled @endif @endif><i class="far fa-arrow-alt-circle-right"></i> প্রেরণ করুন</button>
                </div>
            </div>
        </div>
    </div>
</form>

