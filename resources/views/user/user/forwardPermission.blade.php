@extends('layouts.master')
@section('title', 'ফরওয়ার্ডিং অনুমতি')
@section('content')
    <p class="m-0 text-black-50">ফরওয়ার্ডিং অনুমতি</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                ফরওয়ার্ডিং অনুমতি
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('User') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>ব্যবহারকারীর তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
            <div class="row">
                <div class="col-md-8 offset-2">
                    <form action="{{ route('User/ForwardPermissionStore', ['id' => $id]) }}" method="post">
                        @csrf
                        <input type="hidden" name="hiddent" value="{{ $id }}" id="id">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm">পদবী</label>
                            <select class="form-control form-control-sm @error('designation_id') is-invalid @enderror" name="designation_id" id="designation_id" onchange="getUserByDesignation(this.value)">
                                <option value="">-নিবাচন করুণ-</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ $designation->id == old('designation_id') ? 'Selected' : '' }}>{{ $designation->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('designation_id'))<small class="form-text text-danger">{{ $errors->first('designation_id') }}</small>@endif
                        </div>
                       <div id="users">
                       </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-sm" type="submit" id="btnSubmit">অনুমতি প্রদান করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('#btnSubmit').hide();
        function getUserByDesignation(id) {
            $("#users").empty();
            if (id != '') {
                user_id = $('#id').val();
                $.ajax({
                    type: 'GET',
                    url: '/getUsersByDesignation/'+id+'/'+user_id,
                    dataType: 'json',
                    success: function (users) {
                        $("#users").empty();
                        if (users.length === 0) {
                            $("#users").empty();
                            $('#btnSubmit').hide();
                        }
                        else {
                            $('#btnSubmit').show();
                            $.each(users, function (i, user) {
                                $("#users")
                                    .append('<div class="form-check"><input class="form-check-input" type="checkbox" value="'+user.id+'" id="user'+user.id+'" name="permitted_users[]"><label class="form-check-label" for="user'+user.id+'">'+user.name+'</label></div>');
                            });
                        }
                    },
                    error: function (ex) {
                        alert('গ্রুপ পুনরুদ্ধার করতে ব্যর্থ হয়েছে: ' + ex);
                        $("#users").empty();
                        $('#btnSubmit').hide();
                    }
                });
            } else {
                $("#users").empty();
                $('#btnSubmit').hide();
            }
        }
    </script>
@endsection
