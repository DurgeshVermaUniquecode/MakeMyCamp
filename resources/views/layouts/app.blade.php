<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" dir="ltr" data-skin="bordered"
    data-template="horizontal-menu-template" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/' . config('app.favicon')) }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/highlight/highlight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-chat.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/notyf/notyf.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    </script>
    <style type="text/css">
        .layout-menu-fixed .layout-navbar-full .layout-menu,
        .layout-menu-fixed-offcanvas .layout-navbar-full .layout-menu {
            top: 56px !important;
        }

        .layout-page {
            padding-top: 56px !important;
        }

        .content-wrapper {
            padding-bottom: 54px !important;
        }
    </style>
    <script src="{{ asset('assets/js/config.js') }}"></script>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->
            <nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
                <div class="container-fluid">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4 ms-0">
                        <a href="javascript:void(0)" class="app-brand-link">
                            <span class="app-brand-logo demo">
                                <span class="text-primary">
                                    <img src="{{ asset('images/' . config('app.logo')) }}" width="50">
                                </span>
                            </span>
                            <span
                                class="app-brand-text demo menu-text fw-bold text-heading">{{ config('app.name') }}</span>
                        </a>

                        <a href="javascript:void(0)" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i
                                class="icon-base ti tabler-x icon-sm d-flex align-items-center justify-content-center"></i>
                        </a>
                    </div>

                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base ti tabler-menu-2 icon-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                            <!-- Search -->
                            <li class="nav-item navbar-search-wrapper btn btn-text-secondary btn-icon rounded-pill">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0)">
                                    <span class="d-inline-block text-body-secondary fw-normal"
                                        id="autocomplete"></span>
                                </a>
                            </li>
                            <!-- /Search -->

                            <!-- Style Switcher -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                    id="nav-theme" href="javascript:void(0)" data-bs-toggle="dropdown">
                                    <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
                                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center active"
                                            data-bs-theme-value="light" aria-pressed="false">
                                            <span><i class="icon-base ti tabler-sun icon-22px me-3"
                                                    data-icon="sun"></i>Light</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center"
                                            data-bs-theme-value="dark" aria-pressed="true">
                                            <span><i class="icon-base ti tabler-moon-stars icon-22px me-3"
                                                    data-icon="moon-stars"></i>Dark</span>
                                        </button>
                                    </li>
                                </ul>
                            </li>
                            <!-- / Style Switcher-->

                            <!-- Quick links  -->
                            {{-- <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                    href="javascript:void(0)" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                    aria-expanded="false">
                                    <i class="icon-base ti tabler-layout-grid-add icon-22px text-heading"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h6 class="mb-0 me-auto">Shortcuts</h6>
                                            <a href="javascript:void(0)"
                                                class="dropdown-shortcuts-add py-2 btn btn-text-secondary rounded-pill btn-icon"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Add shortcuts"><i
                                                    class="icon-base ti tabler-plus icon-20px text-heading"></i></a>
                                        </div>
                                    </div>
                                    <div class="dropdown-shortcuts-list scrollable-container">
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base ti tabler-calendar icon-26px text-heading"></i>
                                                </span>
                                                <a href="#" class="stretched-link">Calendar</a>
                                                <small>Appointments</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i
                                                        class="icon-base ti tabler-file-dollar icon-26px text-heading"></i>
                                                </span>
                                                <a href="#" class="stretched-link">Invoice App</a>
                                                <small>Manage Accounts</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base ti tabler-user icon-26px text-heading"></i>
                                                </span>
                                                <a href="#" class="stretched-link">User App</a>
                                                <small>Manage Users</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base ti tabler-users icon-26px text-heading"></i>
                                                </span>
                                                <a href="#" class="stretched-link">Role
                                                    Management</a>
                                                <small>Permission</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i
                                                        class="icon-base ti tabler-device-desktop-analytics icon-26px text-heading"></i>
                                                </span>
                                                <a href="{{ url('dashboard') }}" class="stretched-link">Dashboard</a>
                                                <small>User Dashboard</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base ti tabler-settings icon-26px text-heading"></i>
                                                </span>
                                                <a href="{{ url('account-settings') }}"
                                                    class="stretched-link">Setting</a>
                                                <small>Account Settings</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i
                                                        class="icon-base ti tabler-help-circle icon-26px text-heading"></i>
                                                </span>
                                                <a href="#" class="stretched-link">FAQs</a>
                                                <small>FAQs & Articles</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base ti tabler-square icon-26px text-heading"></i>
                                                </span>
                                                <a href="#" class="stretched-link">Modals</a>
                                                <small>Useful Popups</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                            <!-- Quick links -->


                            @php
                                use App\Models\Notifications;
                                $notifications = Notifications::where(['user_id'=>Auth::user()->id])->whereNull('read_at')->get();


                            @endphp
                            <!-- Notification -->
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                    href="javascript:void(0)" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                    aria-expanded="false">
                                    <span class="position-relative">
                                        <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
                                        @if(count($notifications))
                                        <span
                                            class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                                            @endif
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-0">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h6 class="mb-0 me-auto">Notification</h6>
                                            <div class="d-flex align-items-center h6 mb-0">
                                                <span class="badge bg-label-primary me-2">{{count($notifications)}} New</span>
                                                <a href="{{route('read_notifications')}}"
                                                    class="dropdown-notifications-all p-2 btn btn-icon"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Mark all as read"><i
                                                        class="icon-base ti tabler-mail-opened text-heading"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($notifications as $notification)
                                                 <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">

                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-1">{{$notification->title}}</h6>
                                                        <small class="mb-1 d-block text-body">{{$notification->message}}</small>
                                                        <small class="text-body-secondary">{{$notification->created_at}}</small>
                                                    </div>

                                                </div>
                                            </li>
                                            @endforeach


                                        </ul>
                                    </li>
                                    {{-- <li class="border-top">
                                        <div class="d-grid p-4">
                                            <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0)">
                                                <small class="align-middle">View all notifications</small>
                                            </a>
                                        </div>
                                    </li> --}}
                                </ul>
                            </li>
                            <!--/ Notification -->
                            @php
                                $profile_image = 'images/user-1.svg';
                                if (auth()->user()->gender == 'Female') {
                                    $profile_image = 'images/user-2.svg';
                                }
                            @endphp
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0)"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('profile_images/' . auth()->user()->image) }}"
                                            onerror="this.onerror=null;this.src='{{ asset($profile_image) }}';" alt
                                            class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item mt-0" href="javascript:void(0)">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('profile_images/' . auth()->user()->image) }}"
                                                            onerror="this.onerror=null;this.src='{{ asset($profile_image) }}';"
                                                            alt class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                                    <small
                                                        class="text-body-secondary">{{ Auth::user()->code }}</small><br>
                                                    <small
                                                        class="text-body-secondary">{{ Auth::user()->roles->role_name }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1 mx-n2"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('view_profile') }}">
                                            <i class="icon-base ti tabler-user me-3 icon-md"></i><span
                                                class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('change_password') }}">
                                            <i class="icon-base ti tabler-lock me-3 icon-md"></i><span
                                                class="align-middle">Change Password</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="d-grid px-2 pt-2 pb-1">
                                            <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <small class="align-middle">Logout</small>
                                                <i class="icon-base ti tabler-logout ms-2 icon-14px"></i>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0"
                        style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        <div class="d-flex h-100 container-fluid">
                            <ul class="menu-inner">
                                <!-- Dashboards -->
                                <li class="menu-item ">
                                    <a href="{{ route('dashboard') }}" class="menu-link">
                                        <i class="menu-icon icon-base ti tabler-smart-home"></i>
                                        <div data-i18n="Dashboards">Dashboard</div>
                                    </a>
                                </li>

                                @if (in_array(Auth::user()->role, [1, 2]))
                                    <li class="menu-item">
                                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                                            <i class="menu-icon icon-base ti tabler-user"></i>
                                            <div data-i18n="Users">Users</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item ">
                                                <a href="{{ route('user_list', ['user']) }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-user"></i>
                                                    <div data-i18n="User">User</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('user_list', ['employee']) }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-user-check"></i>
                                                    <div data-i18n="Employee">Employee</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('user_list', ['bank-associate']) }}"
                                                    class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-user-shield"></i>
                                                    <div data-i18n="Bank Associate">Bank Associate</div>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('user_package_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-file-info"></i>
                                                    <div data-i18n="User Package">User Packages</div>
                                                </a>
                                            </li>
                                            <li class="menu-item ">
                                                <a href="{{ route('commission') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-currency-rupee"></i>
                                                    <div data-i18n="User Commision">User Commision</div>
                                                </a>
                                            </li>
                                            <li class="menu-item ">
                                                <a href="{{ route('user_step_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-rollercoaster"></i>
                                                    <div data-i18n="User Steps">User Steps</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="menu-item">
                                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                                            <i class="menu-icon icon-base ti tabler-user-screen"></i>
                                            <div data-i18n="Courses">Courses</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item">
                                                <a href="{{ route('package_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-package"></i>
                                                    <div data-i18n="Packages">Packages</div>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('business_categories_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-category"></i>
                                                    <div data-i18n="Categories">Categories</div>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('course_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-certificate"></i>
                                                    <div data-i18n="Courses">Courses</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif


                                @if (in_array(Auth::user()->role, [1, 2, 3]))
                                    <li class="menu-item">
                                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                                            <i class="menu-icon icon-base ti tabler-vector-bezier-circle"></i>
                                            <div data-i18n="CRM">CRM</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item">
                                                <a href="{{ route('lead_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-package"></i>
                                                    <div data-i18n="Leads">Leads</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('task_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-category"></i>
                                                    <div data-i18n="Courses">Tasks</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                @if (in_array(Auth::user()->role, [1, 2, 3, 5]))
                                    <li class="menu-item">
                                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                                            <i class="menu-icon icon-base ti tabler-script"></i>
                                            <div data-i18n="Document">Document</div>
                                        </a>
                                        <ul class="menu-sub">
                                        @if (in_array(Auth::user()->role, [1, 2]))
                                            <li class="menu-item">
                                                <a href="{{ route('document_type_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-file-info"></i>
                                                    <div data-i18n="Type">Type</div>
                                                </a>
                                            </li>
                                        @endif
                                            <li class="menu-item">
                                                <a href="{{ route('user_document_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-file"></i>
                                                    <div data-i18n="User Documents">User Documents</div>
                                                </a>
                                            </li>


                                        </ul>
                                    </li>
                                @endif


                                @if (in_array(Auth::user()->role, [1, 2]))
                                    <li class="menu-item">
                                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                                            <i class="menu-icon icon-base ti tabler-brand-blogger"></i>
                                            <div data-i18n="Manage Blogs">Manage Blogs</div>
                                        </a>
                                        <ul class="menu-sub">

                                            <li class="menu-item">
                                                <a href="{{ route('blog_categories') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-package"></i>
                                                    <div data-i18n="Categories">Categories</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('blog_list') }}" class="menu-link">
                                                    <i class="menu-icon icon-base ti tabler-category"></i>
                                                    <div data-i18n="Blogs">Blogs</div>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                @endif

                                @if (in_array(Auth::user()->role, [1, 5]))
                                    <li class="menu-item">
                                        <a href="{{ route('loans') }}" class="menu-link">
                                            <i class="menu-icon icon-base ti tabler-a-b-2"></i>
                                            <div data-i18n="Loans">Loans</div>
                                        </a>
                                    </li>
                                @endif



                                @if (in_array(Auth::user()->role, [4]))

                                    {{-- <li class="menu-item">
                                        <a href="{{ route('user_packages_list') }}" class="menu-link">
                                            <i class="menu-icon icon-base ti tabler-a-b-2"></i>
                                            <div data-i18n="My Traning Status">My Traning Status</div>
                                        </a>
                                    </li> --}}
                                    <li class="menu-item">
                                        <a href="{{ route('user_packages_list') }}" class="menu-link">
                                            <i class="menu-icon icon-base ti tabler-a-b-2"></i>
                                            <div data-i18n="Packages">Packages</div>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="{{ route('user_documents_list') }}" class="menu-link">
                                            <i class="menu-icon icon-base ti tabler-files"></i>
                                            <div data-i18n="Business Documents">Business Documents</div>
                                        </a>
                                    </li>


                                    <li class="menu-item">
                                        <a href="{{ route('user_courses_list') }}" class="menu-link">
                                            <i class="menu-icon icon-base ti tabler-book"></i>
                                            <div data-i18n="Courses">Courses</div>
                                        </a>
                                    </li>
                                @endif

                                <li class="menu-item">
                                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                                        <i class="menu-icon icon-base ti tabler-device-mobile-message"></i>
                                        <div data-i18n="Support">Support</div>
                                    </a>
                                    <ul class="menu-sub">
                                        <li class="menu-item">
                                            <a href="{{ route('ticket_list', ['Pending']) }}" class="menu-link">
                                                <i class="menu-icon icon-base ti tabler-ticket"></i>
                                                <div data-i18n="Pending Tickets">Pending Tickets</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('ticket_list', ['Open']) }}" class="menu-link">
                                                <i class="menu-icon icon-base ti tabler-devices-pin"></i>
                                                <div data-i18n="Opend Tickets">Opend Tickets</div>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('ticket_list', ['Closed']) }}" class="menu-link">
                                                <i class="menu-icon icon-base ti tabler-ticket-off"></i>
                                                <div data-i18n="Close Tickets">Close Tickets</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                @if (in_array(Auth::user()->role, [1, 2]))
                                    <li class="menu-item">
                                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                                            <i class="menu-icon icon-base ti tabler-settings"></i>
                                            <div data-i18n="Settings">Settings</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item">
                                                <a href="{{ route('steps_list') }}" class="menu-link">
                                                    <div data-i18n="Steps Master">Steps Master</div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider my-1 mx-n2"></div>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('image_list') }}" class="menu-link">
                                                    <div data-i18n="Images ">Images </div>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('video_list') }}" class="menu-link">
                                                    <div data-i18n="Videos ">Videos </div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider my-1 mx-n2"></div>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('static_content', ['about-us']) }}"
                                                    class="menu-link">
                                                    <div data-i18n="About Us">About Us</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('static_content', ['terms']) }}" class="menu-link">
                                                    <div data-i18n="Terms & Conditions">Terms & Conditions</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('static_content', ['privacy-policy']) }}"
                                                    class="menu-link">
                                                    <div data-i18n="Privacy Policy">Privacy Policy</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('static_content', ['refund-policy']) }}"
                                                    class="menu-link">
                                                    <div data-i18n="Refund Policy">Refund Policy</div>
                                                </a>
                                            </li>

                                            <li class="menu-item">
                                                <a href="{{ route('faq_list') }}" class="menu-link">
                                                    <div data-i18n="Faq's">Faq's</div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider my-1 mx-n2"></div>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('edit_config') }}" class="menu-link">
                                                    <div data-i18n="Config">Config </div>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </aside>
                    <!-- / Menu -->

                    <!-- Content -->
                    <div class="flex-grow-1 container-p-y container-fluid">
                        @yield('content')
                    </div>
                    <!--/ Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-fluid">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="text-body">
                                    © {{ date('Y') }} , made with ❤️ by <a href="{{ config('app.url') }}"
                                        target="_blank" class="footer-link">{{ config('app.name') }}</a>
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="{{ url('privacy') }}" target="_blank"
                                        class="footer-link d-none d-sm-inline-block">Privacy</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>
            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Bootstrap Image Modal -->
    <div class="modal fade" id="dynamicImageModal" tabindex="-1" aria-labelledby="dynamicModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicModalLabel">Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="dynamicModalBody">
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap End Image Modal -->
    <!-- Toast with Animation -->
    <div class="bs-toast toast toast-ex animate__animated my-2" role="alert" aria-live="assertive"
        aria-atomic="true" data-bs-delay="10000">
        <div class="toast-header">
            <i class="icon-base ti tabler-bell icon-xs me-2"></i>
            <div class="me-auto fw-medium" id="toast-status">Success</div>
            <small id="toast-date">Now</small>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-message">Message.</div>
    </div>
    <!--/ Toast with Animation -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>


    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>



    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/notyf/notyf.js') }}"></script>

    <!-- Form Validation -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/highlight/highlight.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>





    @if (session('status') && session('message'))
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function(e) {
                let toastStatus = document.getElementById('toast-status');
                let toastDate = document.getElementById('toast-date');
                let toastMessage = document.getElementById('toast-message');
                let toastAnimationExample = document.querySelector('.toast-ex');

                toastDate.value = "Now";
                toastStatus.innerText = "{{ session('status') }}";
                toastMessage.innerText = "{{ session('message') }}";
                selectedType = "bg-" + "{{ session('status') }}"; //"bg-success"
                selectedAnimation = "animate__tada";
                toastAnimationExample.classList.add(selectedAnimation);
                toastAnimationExample.querySelector('.ti').classList.add(selectedType);
                toastAnimation = new bootstrap.Toast(toastAnimationExample);
                toastAnimation.show();
            });
        </script>
    @endif

    <script type="text/javascript">
        function getStates(countryId, selectedStateId = null, stateSelectId = '#state') {
            const $stateSelect = $(stateSelectId);

            $stateSelect.empty();
            $stateSelect.html('<option disabled selected>Loading...</option>');
            $stateSelect.trigger('change');
            const isSelectedValid = selectedStateId !== null && selectedStateId !== undefined && selectedStateId !== '';

            $.ajax({
                url: "{{ route('states', ':id') }}".replace(':id', countryId),
                method: 'GET',
                success: function(data) {

                    $stateSelect.empty();

                    if (!isSelectedValid) {
                        $stateSelect.append('<option disabled selected>Select State</option>');
                    }

                    data.forEach(function(state) {
                        const isSelected = isSelectedValid && state.id == selectedStateId;
                        const option = new Option(state.name, state.id, isSelected, isSelected);
                        $stateSelect.append(option);
                    });

                    $stateSelect.trigger('change');
                },
                error: function(xhr, status, error) {
                    $stateSelect.empty();
                    $stateSelect.trigger('change');
                }
            });
        }


        function getCities(stateId, selectedCityId = null, citySelectId = '#city') {
            const $citySelect = $(citySelectId);

            $citySelect.empty();
            $citySelect.html('<option disabled selected>Loading...</option>');
            $citySelect.trigger('change');
            const isSelectedValid = selectedCityId !== null && selectedCityId !== undefined && selectedCityId !== '';

            $.ajax({
                url: "{{ route('cities', ':id') }}".replace(':id', stateId),
                method: 'GET',
                success: function(data) {
                    $citySelect.empty();

                    if (!isSelectedValid) {
                        $citySelect.append('<option disabled selected>Select City</option>');
                    }

                    data.forEach(function(city) {
                        const isSelected = isSelectedValid && state.id == selectedCityId;
                        const option = new Option(city.name, city.id, isSelected, isSelected);
                        $citySelect.append(option);
                    });
                    $citySelect.trigger('change');
                },
                error: function(xhr, status, error) {
                    $citySelect.empty();
                    $citySelect.trigger('change');
                }
            });
        }

        const fullToolbar = [
            [{
                    font: []
                },
                {
                    size: []
                }
            ],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                    color: []
                },
                {
                    background: []
                }
            ],
            [{
                    script: 'super'
                },
                {
                    script: 'sub'
                }
            ],
            [{
                    header: '1'
                },
                {
                    header: '2'
                },
                'blockquote',
                'code-block'
            ],
            [{
                    list: 'ordered'
                },
                {
                    indent: '-1'
                },
                {
                    indent: '+1'
                }
            ],
            [{
                direction: 'rtl'
            }, {
                align: []
            }],
            ['link', 'image', 'video', 'formula'],
            ['clean']
        ];



        function initializeDataTable(selector, ajaxUrl, columns, extraDataCallback = null) {
            const datatable = document.querySelector(selector);
            if (!datatable) return;

            return new DataTable(datatable, {
                processing: true,
                serverSide: true,
                ajax: {
                    url: ajaxUrl,
                    data: function(d) {
                        if (typeof extraDataCallback === 'function') {
                            extraDataCallback(d);
                        }
                    }
                },
                columns: columns,
                layout: {
                    topStart: {
                        rowClass: 'row m-3 my-0 justify-content-between',
                        features: [{
                            pageLength: {
                                menu: [10, 25, 50, 100],
                                text: '_MENU_'
                            }
                        }]
                    },
                    topEnd: {
                        features: [{
                                search: {
                                    placeholder: 'Search here',
                                    text: '_INPUT_'
                                }
                            },
                            {
                                buttons: [{
                                    extend: 'collection',
                                    className: 'btn btn-label-secondary dropdown-toggle',
                                    text: `<span class="d-flex align-items-center gap-2"><i class="icon-base ti tabler-upload icon-xs"></i> <span class="d-none d-sm-inline-block">Export</span></span>`,
                                    buttons: [{
                                            extend: 'print',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-printer me-1"></i>Print</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [0, 1, 2]
                                            }
                                        },
                                        {
                                            extend: 'csv',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-file-text me-1"></i>Csv</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [0, 1, 2]
                                            }
                                        },
                                        {
                                            extend: 'excel',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-file-spreadsheet me-1"></i>Excel</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [0, 1, 2]
                                            }
                                        },
                                        {
                                            extend: 'pdf',
                                            text: `<span class="d-flex align-items-center"><i class="icon-base ti tabler-file-description me-1"></i>Pdf</span>`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [0, 1, 2]
                                            }
                                        },
                                        {
                                            extend: 'copy',
                                            text: `<i class="icon-base ti tabler-copy me-1"></i>Copy`,
                                            className: 'dropdown-item',
                                            exportOptions: {
                                                columns: [0, 1, 2]
                                            }
                                        }
                                    ]
                                }]
                            }
                        ]
                    },
                    bottomStart: {
                        rowClass: 'row mx-3 justify-content-between',
                        features: ['info']
                    },
                    bottomEnd: 'paging'
                },
                language: {
                    paginate: {
                        next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                        previous: '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                        first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                        last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>'
                    }
                }
            });
        }

        function openImageModal(url) {
            var content = `<img src="${url}" alt="Image" class="img-fluid" style="width: 100%;">`;
            $('#dynamicModalBody').html(content);
            $('#dynamicModal').modal('show');
        }
    </script>

    @stack('scripts')
</body>

</html>
