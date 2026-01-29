@extends('layouts.main_layout')

@section('content')
    <!--begin::Post-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2 class="fw-bold">Tambah UMKM</h2>
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
            <form action="{{ route('master.umkm.store') }}" method="POST">
                @csrf

                <h4 class="text-gray-900 fw-bold fs-4 mb-6">Data Usaha</h4>

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="required form-label">Nama Usaha</label>
                    <input type="text" name="nama_usaha" class="form-control form-control-solid"
                        value="{{ old('nama_usaha') }}" placeholder="Masukkan nama usaha" required>
                    @error('nama_usaha')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="required form-label">Jenis Usaha</label>
                    <select name="jenis_usaha" class="form-select form-select-solid" data-control="select2"
                        data-placeholder="Pilih jenis usaha" required>
                        <option value="">Pilih Jenis Usaha</option>
                        <option value="Jasa" {{ old('jenis_usaha') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                        <option value="Dagang" {{ old('jenis_usaha') == 'Dagang' ? 'selected' : '' }}>Dagang</option>
                        <option value="Manufaktur" {{ old('jenis_usaha') == 'Manufaktur' ? 'selected' : '' }}>Manufaktur
                        </option>
                    </select>
                    @error('jenis_usaha')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="required form-label">Sektor Usaha</label>
                    <input type="text" name="sektor_usaha" class="form-control form-control-solid"
                        value="{{ old('sektor_usaha') }}" placeholder="Contoh: Kuliner, Fashion, Teknologi" required>
                    @error('sektor_usaha')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="form-label">Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" class="form-control form-control-solid"
                        value="{{ old('tahun_berdiri') }}" placeholder="Contoh: 2020" min="1900" max="{{ date('Y') }}">
                    @error('tahun_berdiri')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="required form-label">Alamat Usaha</label>
                    <textarea name="alamat_usaha" class="form-control form-control-solid" rows="3"
                        placeholder="Masukkan alamat lengkap usaha" required>{{ old('alamat_usaha') }}</textarea>
                    @error('alamat_usaha')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row mb-7 mb-md-0">
                        <label class="required form-label">Provinsi</label>
                        <select name="provinsi_id" id="provinsi_id" class="form-select form-select-solid"
                            data-control="select2" data-placeholder="Pilih Provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        @error('provinsi_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required form-label">Kabupaten/Kota</label>
                        <select name="kabupaten_id" id="kabupaten_id" class="form-select form-select-solid"
                            data-control="select2" data-placeholder="Pilih Kabupaten/Kota" required disabled>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        @error('kabupaten_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row mb-7 mb-md-0">
                        <label class="form-label">Kecamatan</label>
                        <select name="kecamatan_id" id="kecamatan_id" class="form-select form-select-solid"
                            data-control="select2" data-placeholder="Pilih Kecamatan" disabled>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        @error('kecamatan_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row mb-7 mb-md-0">
                        <label class="form-label">Kelurahan</label>
                        <select name="kelurahan_id" id="kelurahan_id" class="form-select form-select-solid"
                            data-control="select2" data-placeholder="Pilih Kelurahan" disabled>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                        @error('kelurahan_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control form-control-solid"
                            value="{{ old('kode_pos') }}" placeholder="Kode Pos">
                        @error('kode_pos')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <h4 class="text-gray-900 fw-bold fs-4 mb-6 mt-10">Data Pemilik</h4>

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="required form-label">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" class="form-control form-control-solid"
                        value="{{ old('nama_pemilik') }}" placeholder="Masukkan nama pemilik usaha" required>
                    @error('nama_pemilik')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="form-label">NIK Pemilik</label>
                    <input type="text" name="nik_pemilik" class="form-control form-control-solid"
                        value="{{ old('nik_pemilik') }}" placeholder="16 digit NIK" maxlength="16">
                    @error('nik_pemilik')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row mb-7 mb-md-0">
                        <label class="required form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control form-control-solid" value="{{ old('no_hp') }}"
                            placeholder="08xxxxxxxxxx" required>
                        @error('no_hp')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control form-control-solid" value="{{ old('email') }}"
                            placeholder="email@example.com">
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="form-label">Alamat Pemilik</label>
                    <textarea name="alamat_pemilik" class="form-control form-control-solid" rows="3"
                        placeholder="Masukkan alamat pemilik">{{ old('alamat_pemilik') }}</textarea>
                    @error('alamat_pemilik')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <h4 class="text-gray-900 fw-bold fs-4 mb-6 mt-10">Legalitas Usaha</h4>

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="form-label">Bentuk Badan Usaha</label>
                    <select name="bentuk_badan_usaha" class="form-select form-select-solid" data-control="select2"
                        data-placeholder="Pilih bentuk badan usaha">
                        <option value="">Pilih Bentuk Badan Usaha</option>
                        <option value="Perorangan" {{ old('bentuk_badan_usaha') == 'Perorangan' ? 'selected' : '' }}>
                            Perorangan</option>
                        <option value="CV" {{ old('bentuk_badan_usaha') == 'CV' ? 'selected' : '' }}>CV</option>
                        <option value="PT" {{ old('bentuk_badan_usaha') == 'PT' ? 'selected' : '' }}>PT</option>
                    </select>
                    @error('bentuk_badan_usaha')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row mb-7 mb-md-0">
                        <label class="form-label">NPWP</label>
                        <input type="text" name="npwp" class="form-control form-control-solid" value="{{ old('npwp') }}"
                            placeholder="Nomor NPWP">
                        @error('npwp')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="form-label">NIB</label>
                        <input type="text" name="nib" class="form-control form-control-solid" value="{{ old('nib') }}"
                            placeholder="Nomor Induk Berusaha">
                        @error('nib')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="form-label">Izin Usaha</label>
                    <input type="text" name="izin_usaha" class="form-control form-control-solid"
                        value="{{ old('izin_usaha') }}" placeholder="Nomor izin usaha">
                    @error('izin_usaha')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <label class="form-label">Status Legalitas</label>
                    <select name="status_legalitas" class="form-select form-select-solid" data-control="select2"
                        data-placeholder="Pilih status legalitas">
                        <option value="">Pilih Status</option>
                        <option value="BELUM" {{ old('status_legalitas') == 'BELUM' ? 'selected' : '' }}>Belum Lengkap
                        </option>
                        <option value="LENGKAP" {{ old('status_legalitas') == 'LENGKAP' ? 'selected' : '' }}>Lengkap</option>
                    </select>
                    @error('status_legalitas')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Actions-->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('master.umkm.index') }}" class="btn btn-light me-3">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Post-->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Init Select2 for static fields if not already working
            // $('[data-control="select2"]').select2();

            // Load Provinces on page load
            $.ajax({
                url: "{{ route('api.provinces') }}",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('#provinsi_id').append('<option value="' + value.code + '">' + value.name + '</option>');
                    });
                }
            });

            // On Province Change
            $('#provinsi_id').on('change', function () {
                var provinceId = $(this).val();
                $('#kabupaten_id').empty().append('<option value="">Pilih Kabupaten/Kota</option>').prop('disabled', true);
                $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
                $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', true);

                if (provinceId) {
                    var url = "{{ route('api.cities', 0) }}";
                    url = url.replace('/0', '/' + provinceId);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                $('#kabupaten_id').append('<option value="' + value.code + '">' + value.name + '</option>');
                            });
                            $('#kabupaten_id').prop('disabled', false);
                        }
                    });
                }
            });

            // On City Change
            $('#kabupaten_id').on('change', function () {
                var cityId = $(this).val();
                $('#kecamatan_id').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
                $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', true);

                if (cityId) {
                    var url = "{{ route('api.districts', 0) }}";
                    url = url.replace('/0', '/' + cityId);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                $('#kecamatan_id').append('<option value="' + value.code + '">' + value.name + '</option>');
                            });
                            $('#kecamatan_id').prop('disabled', false);
                        }
                    });
                }
            });

            // On District Change
            $('#kecamatan_id').on('change', function () {
                var districtId = $(this).val();
                $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', true);

                if (districtId) {
                    var url = "{{ route('api.villages', 0) }}";
                    url = url.replace('/0', '/' + districtId);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                $('#kelurahan_id').append('<option value="' + value.code + '">' + value.name + '</option>');
                            });
                            $('#kelurahan_id').prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endsection