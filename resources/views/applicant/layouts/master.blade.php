@php
    use App\Models\Application;

        $applications = Application::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
           $totalLetter = 0;
           foreach ($applications as $application)
           {
                foreach ($application->letter_issues as $letter)
                {
                    if ($application->is_failed == 0){
                        if($letter->letter_type_id == 1 || $letter->letter_type_id == 2)
                        {
                            if ($letter->is_issued == 1 && $letter->is_solved == 0)
                            {
                                $totalLetter++;
                            }
                        }else{
                            if ($letter->is_issued == 1 && $letter->is_read == 0)
                            {
                                $totalLetter++;
                            }
                        }

                    }
                }
           }

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <title>{{ config('app.name', 'RDA') }}</title>--}}
    <title>@yield('title') || রাজশাহী উন্নয়ন কর্তৃপক্ষ</title>


    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
    <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet"/>
    <link href="{{asset('assets/img/favicon.png')}}" rel="shortcut icon"/>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toaster/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flag-icons/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-confirm/css/jquery-confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sleek.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}" media="print">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fancybox/jquery.fancybox.min.css') }}">
    <!-- Jquery UI-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqueryui/themes/cupertino/jquery-ui.min.css') }}">
    <style>
        .select2 {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        @media screen and (prefers-reduced-motion: reduce) {
            .select2 {
                transition: none;
            }
        }

        .select2::-ms-expand {
            background-color: transparent;
            border: 0;
        }

        .select2:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .select2::-webkit-input-placeholder {
            color: #6c757d;
            opacity: 1;
        }

        .select2::-moz-placeholder {
            color: #6c757d;
            opacity: 1;
        }

        .select2:-ms-input-placeholder {
            color: #6c757d;
            opacity: 1;
        }

        .select2::-ms-input-placeholder {
            color: #6c757d;
            opacity: 1;
        }

        .select2::placeholder {
            color: #6c757d;
            opacity: 1;
        }

        .select2:disabled, .select2[readonly] {
            background-color: #e9ecef;
            opacity: 1;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
             border: 0;
             border-radius: 0;
        }
    </style>
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqueryui/jquery-ui.js') }}"></script>
</head>


<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body" style="font-family: 'kalpurush">

<div class="mobile-sticky-body-overlay"></div>
<div class="wrapper">
    <!-- Left sidebar with footer-->
    <aside class="left-sidebar bg-sidebar">
        <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Application Brand -->
            <div class="app-brand">
                <a href="{{ route('Dashboard') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="40" height="40">
                    <span class="brand-name">ইঅফিস ব্যবস্থাপনা</span>
                </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-scrollbar">
                <!-- sidebar menu -->
                <ul class="nav sidebar-inner" id="sidebar-menu">
                    <li  class="has-sub">
                        <a class="sidenav-item-link" href="{{ url('applicant/dashboard') }}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span class="nav-text">ড্যাশবোর্ড</span>
                        </a>
                    </li>
                    <hr style="border-top: 1px solid white;" class="mt-0 mb-0">

                    <li class="has-sub">
                        <a class="sidenav-item-link" href="{{ route('applicant/applications/Index') }}">
                            <i class="mdi mdi-account-box"></i> <span class="nav-text">আবেদন পত্র</span>
                        </a>
                    </li>

{{--                    <li class="has-sub">--}}
{{--                        <a class="sidenav-item-link" href="{{ route('applicant/applications/track') }}">--}}
{{--                            <i class="mdi mdi-account-box"></i> <span class="nav-text">আবেদন ট্র্যাক</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <li class="has-sub">
                        <a class="sidenav-item-link" href="{{ route('applicant/letters') }}">
                            <i class="mdi mdi-account-box"></i> <span class="nav-text">চিঠি সমূহ @if($totalLetter > 0)<span class="badge badge-danger">{{ $totalLetter }}</span>@endif</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    <div class="page-wrapper">
        <!-- Header -->
        <header class="main-header " id="header">
            <nav class="navbar navbar-static-top navbar-expand-lg">
                <!-- Sidebar toggle button -->
                <button id="sidebar-toggler" class="sidebar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <!-- search form -->
                <div class="search-form d-none d-lg-inline-block">
                    <div class="input-group">
                        <button type="button" name="search" id="search-btn" class="btn btn-flat">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <input type="text" name="query" id="search-input" class="form-control" placeholder="প্রয়োজনীয় তথ্য খুঁজুন"
                               autofocus autocomplete="off" />
                    </div>
                    <div id="search-results-container">
                        <ul id="search-results"></ul>
                    </div>
                </div>

                <div class="navbar-right ">
                    <ul class="nav navbar-nav">
                        <!-- User Account -->
                        <li class="dropdown user-menu">
                            <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <table>
                                    <tr>
                                        <td><img src="{{ asset(Auth::user()->photo) }}" class="img-thumbnail mr-2 mt-3" height="50" width="50" alt="{{ Auth::user()->name  }}"/></td>
                                        <td>
                                            <div class="d-none d-lg-inline-block">
                                                <p style="font-size: 16px; margin-top: 12px; text-align: left;">{{ Auth::user()->name }}</p>
                                                <p style="font-size: 10px; margin-top: 6px; text-align: left">{{ Auth::user()->designation->name }}</p>
                                                <p style="font-size: 10px; margin-top: 6px; text-align: left">{{ Auth::user()->address }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <!-- User image -->
                                <li class="dropdown-header">
                                    <div class="d-inline-block"> {{ Auth::user()->name }} <small class="pt-1">{{ Auth::user()->email }}</small></div>
                                </li>
                                <li> <a href="{{ route('applicant/user/changePassword') }}"> <i class="fas fa-lock"></i> পাসওয়ার্ড পরিবর্তন</a></li>
                                <li> <a href="{{ route('applicant/user/changeProfilePic') }}"> <i class="fas fa-image"></i> প্রোফাইল ছবি পরিবর্তন</a></li>

                                <li class="dropdown-footer">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="mdi mdi-logout"></i>লগ আউট করুণ
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="content-wrapper">
            <div class="content p-3">
                @yield('content')
            </div>
        </div>

        <footer class="footer mt-auto">
            <div class="row copyright bg-dark" style="padding: 15px 0px 5px 30px;">
                <div class="col-sm-6">
                    <p> গ্রহস্বত্ব &copy; <span>{{ \App\Http\Helpers\Helper::ConvertToBangla(\Carbon\Carbon::now()->format('Y')) }}</span>, সর্বস্বত্ব স্বত্বাধিকার সংরক্ষিত,
                        <a class="text-primary" href="http://rda.rajshahi.gov.bd/" target="_blank">রাজশাহী উন্নয়ন কর্তৃপক্ষ</a>
                    </p>
                </div>
                <div class="col-md-3">&nbsp;</div>
                <div class="col-sm-3">
                    <p>কারিগরি সহায়তায়,
                        <a class="text-primary" href="https://www.sunitltd.net" target="_blank"><b class="text-white">সান আইটি লিমিটেড</b></a>
                    </p>
                </div>
            </div>


        </footer>
    </div>
</div>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toaster/toastr.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscrollbar/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-confirm/js/jquery-confirm.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-printThis/printThis.js') }}"></script>
<script src="{{ asset('assets/plugins/sheepit-master/jquery.sheepItPlugin.js') }}"></script>
<script src="{{ asset('assets/js/sleek.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/plugins/fontawesome/js/all.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/plugins/fancybox/jquery.fancybox.min.js') }}"></script>

@yield('script')
</body>
</html>
