@extends('layouts.master')
@section('title', 'কাজের অনুমতি বরাদ্দ করুন')
@section('content')
    <p class="m-0 text-black-50">কাজের অনুমতি বরাদ্দ করুন</p>
    <hr>
    <!-- Top Statistics -->
    <div class="card card-default">
        <div class="card-header card-header-border-bottom p-3">
            <div class="col-md-6">
                কাজের অনুমতি বরাদ্দ করুন
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('User') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-table mr-1"></i>ব্যবহারকারীর তালিকা</a>
            </div>
        </div>
        <div class="card-body p-2">
            @include('includes.message')
            <div class="row">
                <div class="col-md-8 offset-2">
                    <form action="{{ route('User/WorkingPermissionStore', ['id'=>$id]) }}" method="post">
                        @csrf
                        @foreach($tasks as $task)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $task->id }}" id="task_id_{{ $task->id }}" name="task_id[]">
                                <label class="form-check-label" for="task_id_{{ $task->id }}">{{ $task->name }}</label>
                            </div>
                        @endforeach

                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-sm" type="submit" id="btnSubmit">অনুমতি প্রদান করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

