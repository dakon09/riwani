@extends('layouts.main_layout')

@section('content')
    <!--begin::Post-->
    <!--begin::Post-->
    <form action="{{ route('master.umkm.store') }}" method="POST" id="umkm_form" class="form"
        data-provinces-url="{{ route('api.provinces') }}"
        data-cities-url="{{ route('api.cities', 0) }}"
        data-districts-url="{{ route('api.districts', 0) }}"
        data-villages-url="{{ route('api.villages', 0) }}"
        data-initial-province=""
        data-initial-city=""
        data-initial-district=""
        data-initial-village="">
        @csrf
        
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold fs-2 mb-0">Tambah UMKM</h2>
            <a href="{{ route('master.umkm.index') }}" class="btn btn-light">
                <i class="ki-duotone ki-arrow-left fs-2"></i> Kembali
            </a>
        </div>
        <!--end::Toolbar-->

        <div class="d-flex flex-column gap-5 gap-lg-10">
            <!--begin::Card Data Usaha-->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Data Usaha</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
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

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required form-label">Jenis Usaha</label>
                            <select name="jenis_usaha" class="form-select form-select-solid" data-control="select2"
                                data-placeholder="Pilih jenis usaha" required>
                                <option value="">Pilih Jenis Usaha</option>
                                <option value="Jasa" {{ old('jenis_usaha') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                <option value="Dagang" {{ old('jenis_usaha') == 'Dagang' ? 'selected' : '' }}>Dagang</option>
                                <option value="Manufaktur" {{ old('jenis_usaha') == 'Manufaktur' ? 'selected' : '' }}>Manufaktur</option>
                            </select>
                            @error('jenis_usaha')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required form-label">Sektor Usaha</label>
                            <input type="text" name="sektor_usaha" class="form-control form-control-solid"
                                value="{{ old('sektor_usaha') }}" placeholder="Contoh: Kuliner, Fashion, Teknologi" required>
                            @error('sektor_usaha')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Row-->

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

                    <!--begin::Row - Regional-->
                    <div class="row mb-7">
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
                    </div>
                    <!--end::Row-->

                    <!--begin::Row - Regional-->
                    <div class="row mb-7">
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
                        <div class="col-md-4 fv-row">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control form-control-solid"
                                value="{{ old('kode_pos') }}" placeholder="Kode Pos">
                            @error('kode_pos')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
            </div>
            <!--end::Card Data Usaha-->

            <!--begin::Card Data Pemilik-->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Data Pemilik</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
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
                        <div class="col-md-6 fv-row mb-7 mb-md-0">
                            <label class="required form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control form-control-solid" value="{{ old('no_hp') }}"
                                placeholder="08xxxxxxxxxx" required>
                            @error('no_hp')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid" value="{{ old('email') }}"
                                placeholder="email@example.com" required>
                            @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
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
                </div>
            </div>
            <!--end::Card Data Pemilik-->

            <!--begin::Card Akun UMKM-->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Akun UMKM</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="fv-row mb-7">
                        <label class="required form-label">Username</label>
                        <input type="text" name="username" class="form-control form-control-solid"
                            value="{{ old('username') }}" placeholder="Masukkan username" required>
                        @error('username')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-solid"
                            placeholder="Masukkan password" required>
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <!--end::Card Akun UMKM-->

            <!--begin::Card Legalitas-->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Legalitas Usaha</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
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
                        <div class="col-md-6 fv-row mb-7 mb-md-0">
                            <label class="form-label">NPWP</label>
                            <input type="text" name="npwp" class="form-control form-control-solid" value="{{ old('npwp') }}"
                                placeholder="Nomor NPWP">
                            @error('npwp')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="form-label">NIB</label>
                            <input type="text" name="nib" class="form-control form-control-solid" value="{{ old('nib') }}"
                                placeholder="Nomor Induk Berusaha">
                            @error('nib')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
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
                </div>
            </div>
            <!--end::Card Legalitas-->

            <!--begin::Actions-->
            <div class="d-flex justify-content-end">
                <a href="{{ route('master.umkm.index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <!--end::Actions-->
        </div>
    </form>
    <!--end::Post-->
@endsection

@section('script')
    <script src="{{ asset('assets/js/master/umkm-form.js') }}"></script>
@endsection
