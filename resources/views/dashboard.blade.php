@extends('layouts.main_layout', ['title' => 'Dashboard', 'breadcrum' => []])

@section('content')
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-12">
            <!--begin::Engage widget 10-->
            <div class="card card-flush h-md-100">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0"
                    style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
                    <!--begin::Wrapper-->
                    <div class="mb-10">
                        <!--begin::Title-->
                        <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                            <span class="me-2">Selamat Datang,
                                <span class="position-relative d-inline-block text-danger">
                                    <a href="javascript:void(0)"
                                        class="text-danger opacity-75-hover">{{ Auth::user()->name }}</a>
                                    <!--begin::Separator-->
                                    <span
                                        class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                    <!--end::Separator-->
                                </span></span><br />
                            di Dashboard Aplikasi
                        </div>
                        <!--end::Title-->
                        <!--begin::Action-->
                        <div class="text-center">
                            <a href="#" class="btn btn-sm btn-dark fw-bold" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_create_app">Mulai Eksplorasi</a>
                        </div>
                        <!--begin::Action-->
                    </div>
                    <!--begin::Wrapper-->
                    <!--begin::Illustration-->
                    <img class="mx-auto h-150px h-lg-200px theme-light-show"
                        src="assets/media/illustrations/misc/upgrade.svg" alt="" />
                    <img class="mx-auto h-150px h-lg-200px theme-dark-show"
                        src="assets/media/illustrations/misc/upgrade-dark.svg" alt="" />
                    <!--end::Illustration-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Engage widget 10-->
        </div>
        <!--end::Col-->
    </div>

    @can('dashboard')
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <div class="card h-lg-100 card-flush hover-elevate-up shadow-sm parent-hover">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <i class="ki-duotone ki-people fs-2hx text-success mb-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </div>
                        <div class="d-flex flex-column my-7">
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ \App\Models\User::count() }}</span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">Total Users Registered</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <div class="card h-lg-100 card-flush hover-elevate-up shadow-sm parent-hover">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <i class="ki-duotone ki-security-user fs-2hx text-warning mb-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <div class="d-flex flex-column my-7">
                            <span
                                class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ \Spatie\Permission\Models\Role::count() }}</span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">Roles Defined</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <div class="card h-lg-100 card-flush hover-elevate-up shadow-sm parent-hover">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <i class="ki-duotone ki-shield-tick fs-2hx text-primary mb-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <div class="d-flex flex-column my-7">
                            <span
                                class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ \Spatie\Permission\Models\Permission::count() }}</span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">Permissions Available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <div class="card h-lg-100 card-flush hover-elevate-up shadow-sm parent-hover">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <i class="ki-duotone ki-badge fs-2hx text-info mb-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </div>
                        <div class="d-flex flex-column my-7">
                            <span
                                class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ Auth::user()->getRoleNames()->first() ?? 'N/A' }}</span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">Your Current Role</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Col-->
        </div>
    @endcan
@endsection

@section('script')
@endsection
