@extends('applicant.layouts.master')
@section('title', 'আবেদনের ধরণ')
@section('content')
    <p>আবেদনের ধরণ</p>
    <hr>
    <!-- Top Statistics -->
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card card-mini mb-4">
                <div class="card-body">
                   <form action="{{ route('applicant/application/Payment', ['id' => $id]) }}" method="post">
                       @csrf
                       <div class="form-group">
                        <label class="col-form-label-sm" for="app_type">আবেদনের ধরণ</label>
                           <select class="form-control-sm form-control" id="app_type" name="app_type" required>
                               <option value="">-নির্বাচন করুন-</option>
                               <option value="Normal">সাধারণ</option>
                               <option value="Emergency">জরুরী</option>
                           </select>
                       </div>
                       <div class="form-group text-right">
                            <button type="submit" class="btn btn-sm btn-primary">ক্রয় করুন</button>
                       </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
@endsection
