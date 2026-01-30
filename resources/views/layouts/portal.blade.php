<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<!--begin::Head-->

<head>
    <title>{{ config('app.name', 'BoilerPlate Harma') }}</title>
    <meta charset="utf-8" />
    <base href="{{ url('/') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('/') }}">
    <meta name="description" content="{{ config('app.name', 'BoilerPlate Harma') }}" />
    <meta name="keywords" content="{{ config('app.name', 'BoilerPlate Harma') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ config('app.name', 'BoilerPlate Harma') }}" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="{{ config('app.name', 'BoilerPlate Harma') }}" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    @yield('css')
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
    <style>
        .menu .menu-item .menu-link.active {
            color: #f1f1f4 !important;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="light-header" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="false" data-kt-app-sidebar-fixed="false" data-kt-app-sidebar-hoverable="false"
    data-kt-app-sidebar-push-header="false" data-kt-app-sidebar-push-toolbar="false"
    data-kt-app-sidebar-push-footer="false" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Page loading(append to body)-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header shadow-sm" data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
                <!--begin::Header container-->
                <div class="app-container container-xxl d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <!--begin::Sidebar mobile toggle-->
                    <!-- (Removed for Portal) -->
                    <!--end::Sidebar mobile toggle-->
                    <!--begin::Mobile logo-->
                    <!--begin::Logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
                        <a href="#">
                            <img alt="Logo" src="{{ asset('assets/media/logo-long-black.png') }}"
                                class="h-25px h-lg-40px" />
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--end::Mobile logo-->
                    <!--begin::Header wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <!--begin::Menu wrapper-->
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                            data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                                id="kt_app_header_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div class="menu-item me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <a class="menu-link active" href="{{ route('portal.profile') }}">
                                        <span class="menu-title">Profil Usaha</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                        <!--begin::Navbar-->
                        <div class="app-navbar flex-shrink-0">
                            <!--begin::Logout Button-->
                            <div class="app-navbar-item ms-1 ms-md-4">
                                <form action="{{ route('portal.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                                </form>
                            </div>
                            <!--end::Logout Button-->
                            <!--begin::Header menu toggle-->
                            <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                                <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                                    id="kt_app_header_menu_toggle">
                                    <i class="ki-duotone ki-element-4 fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <!--end::Header menu toggle-->
                            <!--begin::Aside toggle-->
                            <!--end::Header menu toggle-->
                        </div>
                        <!--end::Navbar-->
                    </div>
                    <!--end::Header wrapper-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->

            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                <!-- (Sidebar Removed for Portal) -->
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                                <!--begin::Page title-->
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    <!--begin::Title-->
                                    <h1
                                        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                        {{ isset($title) ? $title : 'Dashboard' }}
                                    </h1>
                                    <!--end::Title-->
                                    <!--begin::Breadcrumb-->
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        @if (isset($breadcrum))
                                            @foreach ($breadcrum as $item)
                                                @if (!$loop->last)
                                                    <li class="breadcrumb-item text-muted">
                                                        <a href="javascript:void(0);"
                                                            class="text-muted text-hover-primary">{{ $item }}</a>
                                                    </li>
                                                    <li class="breadcrumb-item">
                                                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                                    </li>
                                                @else
                                                    <li class="breadcrumb-item text-muted">{{ $item }}</li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>
                                <!--end::Page title-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-xxl">
                                @yield('content')
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    <div id="kt_app_footer" class="app-footer">
                        <!--begin::Footer container-->
                        <div
                            class="app-container container-xxl d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <!--begin::Copyright-->
                            <div class="text-gray-900 order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">2025&copy;</span>
                            </div>
                            <!--end::Copyright-->
                        </div>
                        <!--end::Footer container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "{{ asset('assets') }}";
        var csrf_token = document.querySelector('meta[name="csrf-token"]').content;
        var base_url = document.querySelector('meta[name="base_url"]').content;
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script>
        function delay(fn, ms) {
            let timer = 0
            return function (...args) {
                clearTimeout(timer)
                timer = setTimeout(fn.bind(this, ...args), ms || 0)
            }
        }
    </script>
    @yield('script')
    @if (session()->has('success'))
        <script>
            swal.fire({
                title: "Sukses",
                text: "{{ session()->get('success') }}",
                timer: 1500,
                showConfirmButton: false,
                icon: 'success'
            })
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            swal.fire({
                title: "Error",
                text: "{{ session()->get('error') }}",
                timer: 1500,
                showConfirmButton: false,
                icon: 'error'
            })
        </script>
    @endif
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    <!--begin::Modal - Edit Profile-->
    <div class="modal fade" id="kt_modal_edit_profile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_edit_profile_header">
                    <h2 class="fw-bold">Edit Profile</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="kt_modal_edit_profile_form" class="form" action="#">
                        @csrf
                        <div class="mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                            <div class="style-user-profile d-flex flex-column align-items-center">
                                <div class="symbol symbol-100px mb-5">
                                    <img src="{{ asset('assets/media/avatars/blank.png') }}" class="shadow-sm"
                                        alt="user" />
                                </div>
                                <div class="fs-7 text-muted">Allowed file types: png, jpg, jpeg.</div>
                            </div>
                        </div>
                        <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse"
                            href="#kt_modal_edit_profile_user_info" role="button" aria-expanded="false"
                            aria-controls="kt_modal_edit_profile_user_info">User Information
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                        <div id="kt_modal_edit_profile_user_info" class="collapse show">
                            <div class="row g-9 mb-7">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Full Name</label>
                                    <div class="input-group input-group-solid mb-5">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-user fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Full Name" name="name"
                                            value="{{ Auth::guard('umkm')->user()?->name ?? '' }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Email</label>
                                    <div class="input-group input-group-solid mb-5">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-sms fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <input type="email" class="form-control form-control-solid"
                                            placeholder="Email Address" name="email"
                                            value="{{ Auth::guard('umkm')->user()?->email ?? '' }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse"
                            href="#kt_modal_edit_profile_password_info" role="button" aria-expanded="false"
                            aria-controls="kt_modal_edit_profile_password_info">Change Password
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                        <div id="kt_modal_edit_profile_password_info" class="collapse show">
                            <div
                                class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                                <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">Password Notice</h4>
                                        <div class="fs-6 text-gray-700">Leave the password fields blank to keep your
                                            current password.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-9 mb-7">
                                <div class="col-md-6 fv-row">
                                    <label class="fs-6 fw-semibold mb-2">New Password</label>
                                    <div class="input-group input-group-solid mb-5">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-key fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <input type="password" class="form-control form-control-solid"
                                            placeholder="New Password" name="password" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="fs-6 fw-semibold mb-2">Confirm Password</label>
                                    <div class="input-group input-group-solid mb-5">
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-check fs-2"></i>
                                        </span>
                                        <input type="password" class="form-control form-control-solid"
                                            placeholder="Confirm Password" name="password_confirmation" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" id="kt_modal_edit_profile_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal - Edit Profile-->
</body>
<!--end::Body-->

</html>