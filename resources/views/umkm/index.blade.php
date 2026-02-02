@extends('layouts.main_layout')

@section('content')
    <!--begin::Post-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2 class="fw-bold">Master UMKM</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                @can('umkm_create')
                    <a href="{{ route('master.umkm.create') }}" class="btn btn-primary me-2">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Tambah UMKM
                    </a>
                @endcan
                @can('umkm_import')
                    <a href="{{ route('master.umkm.import') }}" class="btn btn-success">
                        <i class="ki-duotone ki-file-up fs-2"></i>
                        Import UMKM
                    </a>
                @endcan
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
                <thead>
                    <tr>
                        <th>Kode UMKM</th>
                        <th>Nama Usaha</th>
                        <th>Jenis Usaha</th>
                        <th>Pemilik</th>
                        <th>No HP</th>
                        <th>Sumber</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!--end::Card body-->
    
    </div>
    <!--end::Post-->

    <!--begin::Modal - Change Status-->
    <div class="modal fade" id="kt_modal_change_status" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Ubah Status UMKM</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="kt_modal_change_status_form" class="form" action="#">
                        <input type="hidden" name="umkm_id" id="status_umkm_id">
                        <div class="fv-row mb-7">
                            <label class="required fs-6 fw-semibold mb-2">Status</label>
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Pilih Status" name="status_umkm" id="status_umkm_select">
                                <option value="DRAFT">DRAFT</option>
                                <option value="REGISTERED">REGISTERED</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" id="kt_modal_change_status_submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal - Change Status-->
@endsection

@section('script')
    <script src="{{ asset('assets/js/master/umkm.js') }}"></script>
@endsection
