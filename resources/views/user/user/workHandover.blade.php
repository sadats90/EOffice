@if($is_valid == 1)
<div class="card card-default">
    <div class="card-body p-2">
        @include('includes.message')
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('User/WorkHandoverStore', ['id'=>$id]) }}" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group m-0">
                        <label for="user_id" class="col-form-label">ব্যবহারকারী</label>
                        <select class="form-control" name="user_id" id="user_id" required>
                            <option value="">-বাছাই করুন-</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}, {{ $user->designation->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group m-0">
                        <label for="FromDate" class="col-form-label"> শুরুর তারিখ</label>
                       <input type="date" class="form-control datePicker" name="fromDate" id="FromDate" required/>
                    </div>
                    <div class="form-group m-0">
                        <label for="toDate" class="col-form-label"> শেষ তারিখ</label>
                       <input type="date" class="form-control datePicker" name="toDate" id="toDate" required/>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary btn-sm" type="submit" id="btnSubmit">দায়িত্ব হস্তান্তর করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
    <div class="alert alert-danger">
        <p>ব্যবহারকারী খুঁজে পাওয়া যায় নি</p>
    </div>
@endif
