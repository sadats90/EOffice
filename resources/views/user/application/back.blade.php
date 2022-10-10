@extends('layouts.master')
@section('title', 'নতুন আবেদন')
@section('content')
    <div class="container-fluid">
        <p class="m-0 text-black-50">ফরোওয়ার্ডকৃত আবেদন সমূহ</p>
        <hr>
        <!-- Top Statistics -->
        @include('user.application._application_inc')
    </div>
@endsection
@section('script')
    <script>
       $(document).ready(function (){
           let currentUrl = new URL(window.location);
           $('a[href="'+currentUrl+'"]').addClass('active');
       });
    </script>
@endsection
