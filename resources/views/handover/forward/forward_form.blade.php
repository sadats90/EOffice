
<form autocomplete="off" action="{{ route('workHandover/application/forward/Create', ['id' => $application->id, 'to_user_id' => $application->receive_application->to_user_id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-8">
                    <label class="col-form-label col-form-label-sm" for="message">
                        <strong class="text-primary">নতুন অনুচ্ছেদঃ</strong>
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
                <label class="col-form-label col-form-label-sm" for="forward_to">প্রেরণ করুণ <span class="text-danger">*</span></label>
                <select name="forward_to" id="forward_to" class="form-control form-control-sm" required onchange="getUserInfo(this.value)">
                    <option value="">-বাছাই করুণ-</option>
                    @foreach($forward_users as $user)
                        <option value="{{ $user->permitted_user_id }}">{{ $user->permitted_user_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label col-form-label-sm" for="expired-date">পদবী</label>
                    <input type="text" name="designation" class="form-control form-control-sm" id="designation" readonly>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label col-form-label-sm" for="expired-date">অফিসের ঠিকানা</label>
                    <input name="address" type="text" class="form-control form-control-sm" id="office_address" readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-outline-primary btn-sm" @if($application->is_new == 1)@if($application->is_report_initiate == 0) disabled @endif @endif><i class="far fa-arrow-alt-circle-right"></i> প্রেরণ করুন</button>
                </div>
            </div>
        </div>
    </div>
</form>

