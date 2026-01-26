@extends('layouts.main_layout', ['title' => 'Dashboard', 'breadcrum' => []])

@section('content')
    <div class="row g-5 g-xl-10 mb-2 mb-xl-2">
        <!--begin::Alert-->
        <div class="alert alert-primary d-flex align-items-center p-5">
            <!--begin::Icon-->
            <i class="ki-duotone ki-notification-bing fs-2hx text-success me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                    class="path2"></span><span class="path3"></span></i>
            <!--end::Icon-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h4 class="mb-1 text-dark">Selamat Datang {{ Auth::user()->name }}</h4>
                <!--end::Title-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        @can('dashboard')
            <div class="row g-5 g-xl-10">
                <!--begin::Col-->
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-light-success card-xl-stretch mb-xl-8">
                        <div class="card-body my-3">
                            <a href="#" class="card-title fw-bold text-success fs-5 mb-3 d-block">Total Users</a>
                            <div class="py-1">
                                <span class="text-dark fs-1 fw-bold me-2">{{ \App\Models\User::count() }}</span>
                                <span class="fw-semibold text-muted fs-7">Registered</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                        <div class="card-body my-3">
                            <a href="#" class="card-title fw-bold text-warning fs-5 mb-3 d-block">Roles</a>
                            <div class="py-1">
                                <span class="text-dark fs-1 fw-bold me-2">{{ \Spatie\Permission\Models\Role::count() }}</span>
                                <span class="fw-semibold text-muted fs-7">Defined</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-light-primary card-xl-stretch mb-xl-8">
                        <div class="card-body my-3">
                            <a href="#" class="card-title fw-bold text-primary fs-5 mb-3 d-block">Permissions</a>
                            <div class="py-1">
                                <span
                                    class="text-dark fs-1 fw-bold me-2">{{ \Spatie\Permission\Models\Permission::count() }}</span>
                                <span class="fw-semibold text-muted fs-7">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-sm-6 col-xl-3">
                    <div class="card bg-light-info card-xl-stretch mb-xl-8">
                        <div class="card-body my-3">
                            <a href="#" class="card-title fw-bold text-info fs-5 mb-3 d-block">My Roles</a>
                            <div class="py-1">
                                <span
                                    class="text-dark fs-1 fw-bold me-2">{{ Auth::user()->getRoleNames()->first() ?? 'N/A' }}</span>
                                <span class="fw-semibold text-muted fs-7">Current Role</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->
            </div>
        @endcan
    </div>
@endsection

@section('script')
@endsection
