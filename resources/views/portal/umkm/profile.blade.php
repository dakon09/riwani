@extends('layouts.portal')

@section('content')
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ asset('assets/media/avatars/blank.png') }}" alt="image" />
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                        </div>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a href="#"
                                    class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $data->nama_usaha }}</a>
                                <a href="#">
                                    <i class="ki-duotone ki-verify fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                            </div>
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>{{ $data->nama_pemilik }}
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-geolocation fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>{{ $data->city->name ?? '-' }}, {{ $data->province->name ?? '-' }}
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <i class="ki-duotone ki-sms fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>{{ $data->email ?? '-' }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::Actions-->
                        <div class="d-flex my-4">
                            <a href="{{ route('portal.profile.edit') }}" class="btn btn-sm btn-primary me-3">Edit
                                Profile</a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        @php
                                            $badges = [
                                                'DRAFT' => 'badge-light-warning',
                                                'REGISTERED' => 'badge-light-info',
                                                'REVIEW' => 'badge-light-primary',
                                                'ACTIVE' => 'badge-light-success',
                                                'REJECTED' => 'badge-light-danger',
                                                'INACTIVE' => 'badge-light-secondary',
                                            ];
                                            $badgeClass = $badges[$data->status_umkm] ?? 'badge-light-gray';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-4 fw-bold">{{ $data->status_umkm }}</span>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Status UMKM</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        @php
                                            $legalBadges = [
                                                'BELUM_LENGKAP' => 'badge-light-warning',
                                                'LENGKAP' => 'badge-light-success',
                                            ];
                                            $legalBadge = $legalBadges[$data->status_legalitas] ?? 'badge-light-gray';
                                        @endphp
                                        <span
                                            class="badge {{ $legalBadge }} fs-4 fw-bold">{{ $data->status_legalitas }}</span>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Status Legalitas</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
        </div>
    </div>
    <!--end::Navbar-->

    <!--begin::details View-->
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <!--begin::Card header-->
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Detail Usaha</h3>
            </div>
        </div>
        <!--begin::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-9">
            <!--begin::Row-->
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Nama Usaha</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->nama_usaha }}</span>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Jenis Usaha</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $data->jenis_usaha }}</span>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Sektor Usaha</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->sektor_usaha }}</span>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Tahun Berdiri</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->tahun_berdiri ?? '-' }}</span>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Alamat Usaha</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->alamat_usaha }}</span>
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Wilayah (Provinsi/Kota)</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">
                        {{ $data->province->name ?? '-' }} / {{ $data->city->name ?? '-' }}
                    </span>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::details View-->

    <!--begin::Owner Details-->
    <div class="card mb-5 mb-xl-10" id="kt_profile_owner_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Data Pemilik</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Nama Pemilik</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->nama_pemilik }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">NIK</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->nik_pemilik ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">No. HP</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->no_hp }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Email</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->email ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    <!--end::Owner Details-->

    <!--begin::Legal Details-->
    <div class="card mb-5 mb-xl-10" id="kt_profile_legal_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Legalitas Usaha</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Badan Usaha</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->bentuk_badan_usaha ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">NPWP</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->npwp ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">NIB</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->nib ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">No Ijin Usaha</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $data->nomor_ijin_usaha ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    <!--end::Legal Details-->
@endsection