
@extends('applicant.layouts.master')
@section('title', 'পাসওয়ার্ড পরিবর্তন')
@section('content')
    <p>পাসওয়ার্ড পরিবর্তন</p>
    <hr>
    <div class="row mt-5">
        <div class="col-md-6 offset-3">
            <div class="card">
                <div class="card-body p-3">
                    @include('includes.message')
                    <form action="{{ route('applicant/user/updatePassword') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="old_password">পুরনো পাসওয়ার্ড <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-sm" id="old_password" name="old_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">নতুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-sm" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">পুনরায় নতুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="পাসওয়ার্ড পরিবর্তন করুণ">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
