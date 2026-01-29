@extends('layouts.main_layout')

@section('content')
<!--begin::Post-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h2 class="fw-bold">Detail UMKM - {{ $data->nama_usaha }}</h2>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('master.umkm.index') }}" class="btn btn-light">
                <i class="ki-duotone ki-arrow-left fs-2"></i>
                Kembali
            </a>
            @can('umkm_edit')
            <a href="{{ route('master.umkm.edit', $data->id) }}" class="btn btn-primary ms-2">
                <i class="ki-duotone ki-pencil fs-2"></i>
                Edit
            </a>
            @endcan
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-stack">
            <!--begin::Info-->
            <div class="d-flex flex-column flex-grow-1">
                <div class="d-flex flex-wrap mb-5">
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                        <div class="fs-6 text-gray-400 text-start">Kode UMKM</div>
                        <div class="fw-bold fs-3 text-gray-800">{{ $data->umkm_code }}</div>
                    </div>
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                        <div class="fs-6 text-gray-400 text-start">Sumber</div>
                        <div class="fw-bold fs-3 text-gray-800">{{ $data->source_input }}</div>
                    </div>
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                        <div class="fs-6 text-gray-400 text-start">Status</div>
                        <div class="fw-bold fs-3 text-gray-800">{{ $data->status_umkm }}</div>
                    </div>
                </div>
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->

        <div class="separator my-6"></div>

        <h4 class="text-gray-900 fw-bold fs-4 mb-6">Data Usaha</h4>

        <!--begin::Row-->
        <div class="row g-5 mb-10">
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Nama Usaha</label>
                <div class="text-gray-600">{{ $data->nama_usaha }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Jenis Usaha</label>
                <div class="text-gray-600">{{ $data->jenis_usaha }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Sektor Usaha</label>
                <div class="text-gray-600">{{ $data->sektor_usaha }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Tahun Berdiri</label>
                <div class="text-gray-600">{{ $data->tahun_berdiri ?? '-' }}</div>
            </div>
            <div class="col-12">
                <label class="fw-bold fs-6 text-gray-800">Alamat Usaha</label>
                <div class="text-gray-600">{{ $data->alamat_usaha }}</div>
            </div>
            <div class="col-md-3">
                <label class="fw-bold fs-6 text-gray-800">Provinsi</label>
                <div class="text-gray-600">{{ $data->provinsi }}</div>
            </div>
            <div class="col-md-3">
                <label class="fw-bold fs-6 text-gray-800">Kabupaten</label>
                <div class="text-gray-600">{{ $data->kabupaten }}</div>
            </div>
            <div class="col-md-3">
                <label class="fw-bold fs-6 text-gray-800">Kecamatan</label>
                <div class="text-gray-600">{{ $data->kecamatan ?? '-' }}</div>
            </div>
            <div class="col-md-3">
                <label class="fw-bold fs-6 text-gray-800">Kelurahan</label>
                <div class="text-gray-600">{{ $data->kelurahan ?? '-' }}</div>
            </div>
            <div class="col-md-3">
                <label class="fw-bold fs-6 text-gray-800">Kode Pos</label>
                <div class="text-gray-600">{{ $data->kode_pos ?? '-' }}</div>
            </div>
        </div>
        <!--end::Row-->

        <div class="separator my-6"></div>

        <h4 class="text-gray-900 fw-bold fs-4 mb-6">Data Pemilik</h4>

        <!--begin::Row-->
        <div class="row g-5 mb-10">
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Nama Pemilik</label>
                <div class="text-gray-600">{{ $data->nama_pemilik }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">NIK Pemilik</label>
                <div class="text-gray-600">{{ $data->nik_pemilik ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">No HP</label>
                <div class="text-gray-600">{{ $data->no_hp }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Email</label>
                <div class="text-gray-600">{{ $data->email ?? '-' }}</div>
            </div>
            <div class="col-12">
                <label class="fw-bold fs-6 text-gray-800">Alamat Pemilik</label>
                <div class="text-gray-600">{{ $data->alamat_pemilik ?? '-' }}</div>
            </div>
        </div>
        <!--end::Row-->

        <div class="separator my-6"></div>

        <h4 class="text-gray-900 fw-bold fs-4 mb-6">Legalitas Usaha</h4>

        <!--begin::Row-->
        <div class="row g-5 mb-10">
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Bentuk Badan Usaha</label>
                <div class="text-gray-600">{{ $data->bentuk_badan_usaha }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Status Legalitas</label>
                <div class="text-gray-600">{{ $data->status_legalitas }}</div>
            </div>
            <div class="col-md-4">
                <label class="fw-bold fs-6 text-gray-800">NPWP</label>
                <div class="text-gray-600">{{ $data->npwp ?? '-' }}</div>
            </div>
            <div class="col-md-4">
                <label class="fw-bold fs-6 text-gray-800">NIB</label>
                <div class="text-gray-600">{{ $data->nib ?? '-' }}</div>
            </div>
            <div class="col-md-4">
                <label class="fw-bold fs-6 text-gray-800">Izin Usaha</label>
                <div class="text-gray-600">{{ $data->izin_usaha ?? '-' }}</div>
            </div>
        </div>
        <!--end::Row-->

        <div class="separator my-6"></div>

        <h4 class="text-gray-900 fw-bold fs-4 mb-6">Informasi Sistem</h4>

        <!--begin::Row-->
        <div class="row g-5">
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Dibuat Oleh</label>
                <div class="text-gray-600">{{ $data->createdBy->name ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Diverifikasi Oleh</label>
                <div class="text-gray-600">{{ $data->verifiedBy->name ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Tanggal Dibuat</label>
                <div class="text-gray-600">{{ $data->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold fs-6 text-gray-800">Terakhir Diupdate</label>
                <div class="text-gray-600">{{ $data->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Post-->
@endsection
