
@extends('applicant.layouts.master')
@section('title', 'পাসওয়ার্ড পরিবর্তন')
@section('content')
    <p>পাসওয়ার্ড পরিবর্তন</p>
    <hr>
    <div class="row mt-1">
        <div class="col-md-6 offset-3">
            <div class="card">
                <div class="card-header text-right">
                    <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-info"><i class="mdi mdi-view-dashboard-outline"></i> ড্যাশবোর্ডে ফিরে যান</a>
                </div>
                <div class="card-body p-2">
                    @include('includes.message')
                    <form action="{{ route('applicant/user/updateProfilePic') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group text-center">
                            <img class="img-thumbnail m-3" src="{{  asset(\Illuminate\Support\Facades\Auth::user()->photo) }}" alt="{{ \Illuminate\Support\Facades\Auth::user()->name }}" height="250" width="200">
                            <div class="custom-file">
                                <input name="image" type="file" class="custom-file-input form-control-sm" id="image" required accept="image/jpg,image/png,image/jpeg,image/gif,.wmf">
                                <label id="image_label" class="custom-file-label" for="image">ফাইল বাছাই করুন</label>
                                <small class="text-danger">ফাইল ফরমেট অবশ্যই jpg / png / jpeg হবে</small>
                            </div>
                            <button class="btn btn-primary mt-2" type="submit"><i class="fas fa-edit"></i> পরিবর্তন করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('#image').change(function(e){
            var fileName = e.target.files[0].name;
            $('#image_label').html(fileName);
        });
    </script>
@endsection
