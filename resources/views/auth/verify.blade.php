@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">আপনার ইমেইল ভেরিফাই করুণ</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            একটি নতুন লিঙ্ক আপনার ইমেইলে প্রেরণ করা হয়েছে
                        </div>
                    @endif
                        অগ্রসর হওয়ার আগে, ভেরিফিকাশান লিঙ্কের জন্য অনুগ্রহপূর্বক ইমেইল চেক করুণ। যদি আপনি কোন ইমেইল না পেয়ে থাকেন
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">অন্য একটির জন্য অনুরোধ করুণ</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
