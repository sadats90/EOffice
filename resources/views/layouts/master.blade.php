<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | স্বাগতম রাজশাহী উন্নয়ন কর্তৃপক্ষ</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700"/>
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css"/>
<!--<link rel="stylesheet" href="{{asset('assets/plugins/materialdesign/css/materialdesignicons.min.css')}}"/>-->
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}"/>

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
    <link rel="stylesheet" href="{{ asset('assets/plugins/toaster/toastr.css') }}">
    <!-- Jquery UI-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqueryui/themes/cupertino/jquery-ui.min.css') }}">

    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqueryui/jquery-ui.js') }}"></script>

</head>
<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body" style="font-family: 'kalpurush'">
<div class="mobile-sticky-body-overlay"></div>
<div class="wrapper">
    <!-- Left sidebar with footer-->
    <aside class="left-sidebar bg-sidebar">
        <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Aplication Brand -->
            <div class="app-brand">
                <a href="{{ route('Dashboard') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="40" height="40">
                    <span class="brand-name" style="">ইঅফিস ব্যবস্থাপনা</span>
                </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-scrollbar">
                <!-- sidebar menu -->
                <ul class="nav sidebar-inner" id="sidebar-menu">
                    <li  class="has-sub">
                        <a class="sidenav-item-link" href="{{ route('Dashboard') }}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <b class="nav-text">{{ __('language.dashboard') }}</b>
                        </a>
                    </li>
                    <hr style="border-top: 1px solid white;" class="mt-0 mb-0">
                    @can('isInTask', 'admin:fw:na')
                    <li class="has-sub expand">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dealingofficer1" aria-expanded="false" aria-controls="dealingofficer1">
                            <i class="mdi mdi-account-box"></i> <span class="nav-text">আবেদন</span> <b class="caret"></b>
                        </a>
                        <ul class="collapse show"  id="dealingofficer1" data-parent="#sidebar-menu">
                            @can('isInTask', 'admin:na')
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('newApplication') }}">
                                        <span class="nav-text">
                                            <i class="mdi mdi-subdirectory-arrow-right"></i>
                                            নতুন আবেদন সমূহ
                                             <span class="badge badge-pill badge-primary">
                                                 {{ count(\App\Models\Application::where([['is_new', 1], ['is_complete', 0], ['is_cancel', 0], ['is_failed', 0]])->get()) }}
                                            </span>
                                        </span>
                                        </a>
                                    </li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin:fw')
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('Application') }}">
                                        <span class="nav-text">
                                            <i class="mdi mdi-subdirectory-arrow-right"></i>
                                            ফরওয়ার্ডকৃত আবেদন
                                            <span class="badge badge-pill badge-primary">

                                                @can('isInTask', 'admin')
                                                    @php
                                                        $totals = 0;
                                                        $applications = \App\Models\RecievedApplication::all();
                                                        foreach ($applications as $application){
                                                            if($application->application->is_failed == 0)
                                                                $totals++;
                                                        }
                                                    @endphp
                                                    {{ $totals }}
                                                @endcan
                                                @cannot('isInTask', 'admin')
                                                    @php
                                                        $totals = 0;
                                                        $applications = \App\Models\RecievedApplication::where('to_user_id', \Illuminate\Support\Facades\Auth::id())->get();
                                                        foreach ($applications as $application){
                                                            if($application->application->is_failed == 0)
                                                                $totals++;
                                                        }

                                                    @endphp
                                                    {{ $totals }}
                                                @endcannot
                                            </span>
                                        </span>
                                        </a>
                                    </li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin')
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('complete') }}">
                                        <span class="nav-text">
                                            <i class="mdi mdi-subdirectory-arrow-right"></i> সম্পূর্ণ আবেদন সমূহ
                                             <span class="badge badge-pill badge-primary">
                                                @can('isInTask', 'admin')
                                                     {{ count(\App\Models\Application::where([['is_complete', 1], ['correction_request_status', '<>', 1], ['correction_request_status', '<>', 3]])->get()) }}
                                                 @endcan
                                            </span>
                                        </span>
                                        </a>
                                    </li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin:cr')
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('SwarakReplacement/request') }}">
                                        <span class="nav-text">
                                            <i class="mdi mdi-subdirectory-arrow-right"></i> সংশোধনের আবেদন
                                             <span class="badge badge-pill badge-primary">
                                               {{ count(\App\Models\CorrectionRequest::where([['submitted_at', '<>', null], ['status', 1]])->get())}}
                                            </span>
                                        </span>
                                        </a>
                                    </li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin:cr')
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('SwarakReplacement/index') }}">
                                        <span class="nav-text">
                                            <i class="mdi mdi-subdirectory-arrow-right"></i> একই স্বারকে প্রতিস্থাপন
                                             <span class="badge badge-pill badge-primary">
                                               {{ count(\App\Models\Application::where([['is_complete', 1], ['correction_request_status', 3]])->get()) }}
                                            </span>
                                        </span>
                                        </a>
                                    </li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin:fa')
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('failed') }}">
                                        <span class="nav-text">
                                            <i class="mdi mdi-subdirectory-arrow-right"></i> অনিস্পত্তি আবেদন সমূহ
                                             <span class="badge badge-pill badge-primary">
                                                {{ count(\App\Models\Application::where('is_failed', 1)->get()) }}
                                            </span>
                                        </span>
                                        </a>
                                    </li>
                                </div>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    <li class="has-sub">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#report" aria-expanded="false" aria-controls="report">
                            <i class="mdi mdi-account-box"></i> <span class="nav-text">রিপোর্টস ও রেজিস্টার</span> <b class="caret"></b>
                        </a>
                        <ul class="collapse" id="report" data-parent="#sidebar-menu">
                            @can('isInTask', 'admin:lur')
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('report/landUseSummary') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> আবেদনের সারাংশ</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('report/landUse') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> ভূমি ব্যবহার রিপোর্ট</span></a></li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin:pr')
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('report/position') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> অবস্থান রিপোর্ট</span></a></li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin:bfr')
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('report/bettermentFee') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> উৎকর্ষ ফি  রিপোর্ট</span></a></li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin:er')
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('report/letterIssue') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> চিঠি ইস্যু রেজিস্টার </span></a>
                                    </li>
                                </div>

                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('report/certificateIssue') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> এনওসি সনদপত্র ইস্যু রেজিস্টার </span></a>
                                    </li>
                                </div>
                            @endcan
                            @can('isInTask', 'admin')
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('report/RestoreReport') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> আবেদন পুনরুদ্ধার রিপোর্ট</span></a></li>
                                </div>
                            @endif

                            <div class="sub-menu">
                                <li><a class="sidenav-item-link" href="{{ route('report/dayRange') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> প্রেরণ-গ্রহন রিপোর্ট</span></a></li>
                            </div>
                        </ul>
                    </li>
                    @can('isInTask', 'admin:dc')
                        <li class="has-sub">
                            <a class="sidenav-item-link" href="{{ route('CertificateDuplicateCopy') }}" >
                                <i class="mdi mdi-account-box"></i>
                                <span class="nav-text">এনওসি সনদপত্র অনুলিপি</span>
                            </a>

                        </li>
                    @endcan
                    @can('isInTask', 'wh')
                        <li class="has-sub">
                            <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#extra" aria-expanded="false" aria-controls="extra">
                                <i class="mdi mdi-book-multiple"></i> <span class="nav-text">অতিরিক্ত দায়িত্ব</span> <b class="caret"></b>
                            </a>
                            <ul class="collapse" id="extra" data-parent="#sidebar-menu">
                                <div class="sub-menu">
                                    <li>
                                        <a class="sidenav-item-link" href="{{ route('workHandover/Application') }}">
                                        <span class="nav-text">
                                            <i class="mdi mdi-subdirectory-arrow-right"></i>
                                            ফরওয়ার্ডকৃত আবেদন
                                        </span>
                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    @endcan
                    @can('isInTask', 'admin')
                        <li class="has-sub">
                            <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#setting" aria-expanded="false" aria-controls="setting">
                                <i class="mdi mdi-settings"></i> <span class="nav-text">সেটিংস</span> <b class="caret"></b>
                            </a>
                            <ul class="collapse"  id="setting" data-parent="#sidebar-menu">
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('CertificateText') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> এনওসি সনদপত্রের শর্তাদি সমুহ </span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('Project') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> প্রকল্প সমুহ</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('Fee') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> ফি সমুহ </span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('District') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> জেলা</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('Upazila') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> উপজেলা</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('MouzaAreas') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> মৌজা/এলাকা</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('LandUsePresent') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> জমির বর্তমান অবস্থা</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('LandUseFuture') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> জমির ভবিষ্যৎ ব্যবহার</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('Designation') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> পদবী</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('User') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> ব্যবহারকারী</span></a></li>
                                </div>
                                <div class="sub-menu">
                                    <li><a class="sidenav-item-link" href="{{ route('database/backup') }}"><span class="nav-text"><i class="mdi mdi-subdirectory-arrow-right"></i> ডাটাবেজ ব্যাকআপ</span></a></li>
                                </div>
                            </ul>
                        </li>
                    @endcan
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
                        <input type="text" name="query" id="search-input" class="form-control" placeholder="প্রয়োজনীয় তথ্য খুঁজুন"/>
                    </div>
                    <div id="search-results-container"><ul id="search-results"></ul></div>
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
                                <li> <a href="{{ route('Profile') }}"> <i class="mdi mdi-account"></i> প্রোফাইল ব্যবস্থাপনা</a></li>
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
            <div class="row copyright bg-dark" style="padding:15px 0 5px 30px;">
                <div class="col-sm-6">
                    <p> গ্রহস্বত্ব &copy; <span id="copy-year">{{ \App\Http\Helpers\Helper::ConvertToBangla(\Carbon\Carbon::now()->format('Y')) }}</span>, সর্বস্বত্ব স্বত্বাধিকার সংরক্ষিত,
                        <a class="text-primary" href="http://rda.rajshahi.gov.bd/" target="_blank">রাজশাহী উন্নয়ন কর্তৃপক্ষ</a>
                    </p>
                </div>
                <div class="col-md-3">&nbsp;</div>
                <div class="col-sm-3">
                    <p>কারিগরি সহায়তায়,
                        <a class="text-primary" href="https://www.sunitltd.net" target="_blank"><b>সান আইটি লিমিটেড</b></a>
                    </p>
                </div>
            </div>
        </footer>
        <!--message Model-->
        <div class="modal fade message-modal" id="atp-review-verify-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        </div>
    </div>
</div>
<!-- Common modal -->
<div class="modal fade bd-example-modal-xl" id="common-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<!-- Scripts -->

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
<script src="{{ asset('assets/plugins/toaster/toastr.min.js') }}"></script>
<script src="{{ asset('assets/plugins/print-js/print.min.js') }}"></script>

<script>

    $(document).ready(function() {

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "3000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $('.summerNote').summernote({
            tabsize: 3,
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript', 'fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['picture', 'video', 'link', 'table', 'hr']],
                ['view', ['undo', 'redo', 'codeview','help']],
            ]

        });

    });
    ShowInPopUp = (url, title) => {
        $.ajax({
            type: "GET",
            url: url,
            success: function (res) {
                $('#common-modal .modal-title').html(title);
                $('#common-modal .modal-body').html(res);
                $('#common-modal').modal("show");
            }
        });
    }
</script>
@yield('script')
</body>
</html>
