@extends('layouts.main_layout')

@section('content')
    <div class="card card-flush">
        <div class="card-header">
            <div class="card-title">
                <h2 class="fw-bold">Preview & Perbaikan Data Import</h2>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                <i class="ki-duotone ki-shield-cross fs-2hx text-warning me-4">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-warning">Ditemukan Data Tidak Valid</h4>
                    <span>Beberapa baris data memiliki informasi wilayah yang tidak sesuai. Silakan perbaiki data di bawah
                        ini menggunakan dropdown. Data yang sudah diperbaiki akan disimpan bersama data valid.</span>
                </div>
            </div>

            <form action="{{ route('master.umkm.store-import-fix') }}" method="POST" id="fixForm"
                data-provinces-url="{{ route('api.provinces') }}"
                data-cities-url="{{ route('api.cities', 0) }}"
                data-districts-url="{{ route('api.districts', 0) }}"
                data-villages-url="{{ route('api.villages', 0) }}">
                @csrf
                <input type="hidden" name="valid_rows" value="{{ json_encode($validRows) }}">

                <div class="table-responsive" style="min-height: 300px;">
                    <table class="table table-row-bordered table-striped align-middle gs-4 gy-4">
                        <thead class="bg-light fw-bold text-gray-800">
                            <tr class="fs-6 border-bottom-2 border-gray-200">
                                <th class="text-center" style="width: 50px;">No</th>
                                <th style="min-width: 200px;">Info Usaha</th>
                                <th style="width: 250px; min-width: 200px;">Provinsi</th>
                                <th style="width: 250px; min-width: 200px;">Kabupaten/Kota</th>
                                <th style="width: 250px; min-width: 200px;">Kecamatan</th>
                                <th style="width: 250px; min-width: 200px;">Kelurahan</th>
                                <th style="min-width: 200px;">Diagnosa Error</th>
                            </tr>
                        </thead>
                        <tbody class="fs-6 text-gray-700">
                            @foreach ($invalidRows as $index => $row)
                                <tr>
                                    <td class="text-center fw-bold">{{ $row['row'] }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $row['data']['nama_usaha'] }}</span>
                                            <span class="text-muted fs-7">{{ $row['data']['alamat_usaha'] ?? '-' }}</span>
                                        </div>
                                        <input type="hidden" name="fixes[{{ $index }}][data]"
                                            value="{{ json_encode($row['data']) }}">
                                    </td>
                                    <td>
                                        <select name="fixes[{{ $index }}][provinsi_id]"
                                            class="form-select form-select-solid province-select"
                                            data-row="{{ $index }}" data-placeholder="Pilih Provinsi" required>
                                            <option value="">Pilih Provinsi</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="fixes[{{ $index }}][kabupaten_id]"
                                            class="form-select form-select-solid city-select"
                                            data-row="{{ $index }}" data-placeholder="Pilih Kota" required disabled>
                                            <option value="">Pilih Kota</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="fixes[{{ $index }}][kecamatan_id]"
                                            class="form-select form-select-solid district-select"
                                            data-row="{{ $index }}" data-placeholder="Pilih Kecamatan" required disabled>
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="fixes[{{ $index }}][kelurahan_id]"
                                            class="form-select form-select-solid village-select"
                                            data-row="{{ $index }}" data-placeholder="Pilih Kelurahan" required disabled>
                                            <option value="">Pilih Kelurahan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-danger">
                                            <i class="ki-duotone ki-information-2 fs-4 me-2 text-danger"></i>
                                            <span
                                                class="fw-semibold ms-2">{{ $row['errors'][0]['message'] ?? 'Data tidak valid' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-10">
                    <a href="{{ route('master.umkm.index') }}" class="btn btn-light me-3">Batal</a>
                    <button type="submit" class="btn btn-primary">Proses Perbaikan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/master/umkm-import-preview.js') }}"></script>
@endsection
