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

            <form action="{{ route('master.umkm.store-import-fix') }}" method="POST" id="fixForm">
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
    <script>
        $(document).ready(function () {
            // Function to init Select2 with AJAX
            function initAjaxSelect($element, url, placeholder, parentId = null) {
                // Determine if we need to pass a parent ID (e.g. for city -> provinceId)
                var ajaxConfig = {
                    url: function () {
                        // If parentId is needed and provided, construct dynamic URL
                        // But standard Select2 ajax url can be a function or string.
                        // Here we might need to replace a placeholder in the URL string.
                        // However, the cleanest way for dependent dropdowns in Select2 
                        // is to pass the parent value as a query parameter.
                        // My backend routes are: /api/cities/{province_code}
                        // So I need to construct this dynamic URL.

                        if (url.includes('/0')) {
                            // It's a dependent dropdown
                            // We need to find the value of the parent.
                            // But wait, $element is the specific row's select.
                            // We can find the parent val from the sibling select.

                            // Strategy: usage below will pass the base "template" URL
                            // and we replace /0 with the actual value inside `transport` or before `ajax`.
                            // Actually, simpler: simpler custom data function.
                            return url;
                        }
                        return url;
                    },
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.code
                                }
                            })
                        };
                    },
                    cache: true
                };

                $element.select2({
                    width: '100%',
                    placeholder: placeholder,
                    allowClear: true,
                    ajax: ajaxConfig
                });
            }

            // 1. Provinces - Valid for all rows immediately
            $('.province-select').select2({
                width: '100%',
                placeholder: 'Pilih Provinsi',
                allowClear: true,
                ajax: {
                    url: "{{ route('api.provinces') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return { text: item.name, id: item.code }
                            })
                        };
                    }
                }
            });

            // 2. Dependent Dropdowns (City, District, Village)
            // Since the URL depends on the parent value, we need to re-initialize or configure 
            // the AJAX url dynamically when the parent changes OR use a dynamic URL function.

            // Reusable initializer for dependent fields
            function initDependent($element, urlTemplate, parentVal) {
                if (!parentVal) return;

                var finalUrl = urlTemplate.replace('/0', '/' + parentVal);

                $element.select2({
                    width: '100%',
                    placeholder: $element.data('placeholder'),
                    allowClear: true,
                    ajax: {
                        url: finalUrl,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) { return { q: params.term }; },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return { text: item.name, id: item.code }
                                })
                            };
                        }
                    }
                });
                $element.prop('disabled', false);
            }

            // Events

            // Province Change -> Init City
            $(document).on('change', '.province-select', function () {
                var provinceId = $(this).val();
                var $row = $(this).closest('tr');
                var $city = $row.find('.city-select');

                // Clear and Disable Children
                $row.find('.city-select, .district-select, .village-select').empty().prop('disabled', true);

                if (provinceId) {
                    var url = "{{ route('api.cities', 0) }}";
                    initDependent($city, url, provinceId);
                }
            });

            // City Change -> Init District
            $(document).on('change', '.city-select', function () {
                var cityId = $(this).val();
                var $row = $(this).closest('tr');
                var $district = $row.find('.district-select');

                $row.find('.district-select, .village-select').empty().prop('disabled', true);

                if (cityId) {
                    var url = "{{ route('api.districts', 0) }}";
                    initDependent($district, url, cityId);
                }
            });

            // District Change -> Init Village
            $(document).on('change', '.district-select', function () {
                var districtId = $(this).val();
                var $row = $(this).closest('tr');
                var $village = $row.find('.village-select');

                $row.find('.village-select').empty().prop('disabled', true);

                if (districtId) {
                    var url = "{{ route('api.villages', 0) }}";
                    initDependent($village, url, districtId);
                }
            });

            // Initial styling for disabled inputs (make them look like selects)
            $('.city-select, .district-select, .village-select').select2({
                width: '100%',
                placeholder: 'Pilih...',
                disabled: true
            });
        });
    </script>
@endsection