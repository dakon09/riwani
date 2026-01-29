@extends('layouts.main_layout')

@section('content')
<!--begin::Post-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h2 class="fw-bold">Import UMKM</h2>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('master.umkm.index') }}" class="btn btn-light">
                <i class="ki-duotone ki-arrow-left fs-2"></i>
                Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-information fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="fw-bold mb-1">Panduan Import UMKM</h4>
                <span class="fs-6 text-gray-600">1. Download template terlebih dahulu.<br>2. Isi data UMKM sesuai kolom yang tersedia.<br>3. Upload file yang sudah diisi.<br>4. Sistem akan memvalidasi dan menyimpan data.</span>
            </div>
        </div>
        <!--end::Alert-->

        <!--begin::Download Template-->
        <div class="card bg-light mb-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold text-gray-800 mb-1">Template Import UMKM</h4>
                        <span class="text-gray-600 fs-6">Download template Excel untuk mengisi data UMKM</span>
                    </div>
                    <div>
                        <a href="{{ route('master.umkm.download-template') }}" class="btn btn-primary">
                            <i class="ki-duotone ki-download fs-2"></i>
                            Download Template
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Download Template-->

        <!--begin::Form Upload-->
        <form id="importForm">
            @csrf
            
            <!--begin::Dropzone-->
            <div class="dropzone rounded-3" id="kt_dropzonejs">
                <div class="dz-message needsclick">
                    <i class="ki-duotone ki-file-up fs-3x text-gray-400 mb-2"></i>
                    <h3 class="fs-5 fw-bold mb-1">Drop file Excel atau click untuk upload</h3>
                    <span class="fs-7 fw-bold text-gray-400">Format yang didukung: .xlsx, .xls, .csv (Maks. 10MB)</span>
                </div>
            </div>
            <!--end::Dropzone-->

            <!--begin::Preview Table-->
            <div id="previewSection" class="mt-10" style="display: none;">
                <h4 class="text-gray-900 fw-bold fs-4 mb-6">Preview Import</h4>
                
                <!--begin::Summary Cards-->
                <div class="row g-5 mb-5">
                    <div class="col-md-3">
                        <div class="card bg-light-primary">
                            <div class="card-body text-center py-5">
                                <h3 class="fw-bold fs-1 text-primary mb-0" id="totalRow">0</h3>
                                <span class="text-gray-600 fw-bold fs-6">Total Baris</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body text-center py-5">
                                <h3 class="fw-bold fs-1 text-success mb-0" id="successRow">0</h3>
                                <span class="text-gray-600 fw-bold fs-6">Berhasil</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-danger">
                            <div class="card-body text-center py-5">
                                <h3 class="fw-bold fs-1 text-danger mb-0" id="failedRow">0</h3>
                                <span class="text-gray-600 fw-bold fs-6">Gagal</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-warning">
                            <div class="card-body text-center py-5">
                                <h3 class="fw-bold fs-1 text-warning mb-0" id="warningRow">0</h3>
                                <span class="text-gray-600 fw-bold fs-6">Peringatan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Summary Cards-->

                <!--begin::Errors Table-->
                <div id="errorsSection" style="display: none;">
                    <h5 class="text-gray-800 fw-bold mb-4">Error pada Baris Berikut:</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Usaha</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody id="errorsTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Errors Table-->

                <!--begin::Actions-->
                <div class="d-flex justify-content-end mt-10">
                    <button type="button" class="btn btn-light me-3" id="cancelBtn">
                        <i class="ki-duotone ki-cross fs-2"></i>
                        Batal
                    </button>
                    <a href="{{ route('master.umkm.index') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-check fs-2"></i>
                        Selesai
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Preview Table-->
        </form>
        <!--end::Form Upload-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Post-->
@endsection

 @section('script')
<script src="{{ asset('assets/js/master/umkm-import.js') }}"></script>
@endsection

