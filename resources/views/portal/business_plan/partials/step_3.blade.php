<div class="w-100">
    <div class="pb-10 pb-lg-15">
        <h2 class="fw-bold text-dark">Tahap 3: Rencana Pemasaran (7P)</h2>
        <div class="text-muted fw-semibold fs-6">Strategi pemasaran menyeluruh (Marketing Mix).</div>
    </div>

    <!-- 3.1 PRODUCT -->
    <div class="mb-10">
        <h3 class="fw-bold text-dark mb-5">1. Product (Produk)</h3>
        <div class="repeater-init">
            <div data-repeater-list="pemasaran_produk">
                <div data-repeater-item>
                    <div class="form-group row mb-5 border-bottom pb-5">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">Nama Produk</label>
                            <input type="text" class="form-control form-control-solid" name="produk"
                                placeholder="Nama Produk" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kualitas</label>
                            <input type="text" class="form-control form-control-solid" name="kualitas"
                                placeholder="Kualitas (High/Std)" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kemasan</label>
                            <input type="text" class="form-control form-control-solid" name="kemasan"
                                placeholder="Jenis Kemasan" />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Warna</label>
                            <input type="text" class="form-control form-control-solid" name="warna"
                                placeholder="Varian Warna" />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Ukuran</label>
                            <input type="text" class="form-control form-control-solid" name="ukuran"
                                placeholder="Varian Ukuran" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sertifikasi (PIRT/Halal/dll)</label>
                            <input type="text" class="form-control form-control-solid" name="sertifikasi"
                                placeholder="Sertifikasi" />
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger w-100">
                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-3"></i> Tambah Produk
                </a>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-10"></div>

    <!-- 3.2 PRICE -->
    <div class="mb-10">
        <h3 class="fw-bold text-dark mb-5">2. Price (Harga)</h3>
        <div class="repeater-init">
            <div data-repeater-list="pemasaran_harga">
                <div data-repeater-item>
                    <div class="form-group row mb-5 border-bottom pb-5">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">Produk</label>
                            <input type="text" class="form-control form-control-solid" name="produk"
                                placeholder="Nama Produk" />
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Biaya HPP</label>
                            <input type="number" class="form-control form-control-solid" name="biaya" placeholder="0" />
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Harga Jual</label>
                            <input type="number" class="form-control form-control-solid" name="harga_jual"
                                placeholder="0" />
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Harga Pesaing</label>
                            <input type="number" class="form-control form-control-solid" name="harga_pesaing"
                                placeholder="0" />
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Diskon</label>
                            <input type="text" class="form-control form-control-solid" name="diskon"
                                placeholder="Promo/Diskon" />
                        </div>
                        <div class="col-md-10 mb-3">
                            <label class="form-label">Alasan Penetapan Harga</label>
                            <textarea class="form-control form-control-solid" name="alasan_harga" rows="1"
                                placeholder="Kenapa harga sekian?"></textarea>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger w-100">
                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-3"></i> Tambah Harga
                </a>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-10"></div>

    <!-- 3.3 PLACE (Narrative) -->
    <div class="mb-10">
        <h3 class="fw-bold text-dark mb-5">3. Place (Lokasi & Distribusi)</h3>
        <div class="row mb-5">
            <div class="col-md-8">
                <label class="form-label required">Lokasi Usaha</label>
                <textarea class="form-control form-control-solid" name="lokasi_usaha" rows="2"
                    placeholder="Alamat atau deskripsi lokasi"></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Biaya Lokasi (Bulanan)</label>
                <input type="number" class="form-control form-control-solid" name="biaya_lokasi_bulanan"
                    placeholder="0" />
            </div>
        </div>
        <div class="mb-5">
            <label class="form-label">Alasan Memilih Lokasi</label>
            <textarea class="form-control form-control-solid" name="alasan_lokasi" rows="2"
                placeholder="Mengapa lokasi ini strategis?"></textarea>
        </div>
        <div class="row mb-5">
            <div class="col-md-4">
                <label class="form-label required">Metode Distribusi</label>
                <select class="form-select form-select-solid" name="metode_distribusi" data-control="select2"
                    data-hide-search="true">
                    <option value="langsung">Jual Langsung</option>
                    <option value="pengecer">Lewat Pengecer</option>
                    <option value="grosir">Lewat Grosir</option>
                    <option value="online">Online Marketplace</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label">Alasan Distribusi</label>
                <textarea class="form-control form-control-solid" name="alasan_distribusi" rows="1"
                    placeholder="Alasan memilih metode ini"></textarea>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-10"></div>

    <!-- 3.4 PROMOTION -->
    <div class="mb-10">
        <h3 class="fw-bold text-dark mb-5">4. Promotion (Promosi)</h3>
        <div class="repeater-init">
            <div data-repeater-list="pemasaran_promosi">
                <div data-repeater-item>
                    <div class="form-group row mb-5 border-bottom pb-5">
                        <div class="col-md-3 mb-3">
                            <label class="form-label required">Sarana Promosi</label>
                            <input type="text" class="form-control form-control-solid" name="sarana_promosi"
                                placeholder="Misal: Spanduk, IG Ads" />
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Rincian Kegiatan</label>
                            <textarea class="form-control form-control-solid" name="rincian" rows="1"
                                placeholder="Detil promosi"></textarea>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Biaya</label>
                            <input type="number" class="form-control form-control-solid" name="biaya" placeholder="0" />
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger w-100">
                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-3"></i> Tambah Promosi
                </a>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-10"></div>

    <!-- 3.5 PEOPLE -->
    <div class="mb-10">
        <h3 class="fw-bold text-dark mb-5">5. People (SDM)</h3>
        <div class="repeater-init">
            <div data-repeater-list="pemasaran_people">
                <div data-repeater-item>
                    <div class="form-group row mb-5 border-bottom pb-5">
                        <div class="col-md-3 mb-3">
                            <label class="form-label required">Posisi/Peran</label>
                            <input type="text" class="form-control form-control-solid" name="posisi"
                                placeholder="Misal: Sales, Admin" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kriteria/Skill</label>
                            <input type="text" class="form-control form-control-solid" name="kriteria"
                                placeholder="Keahlian yang dibutuhkan" />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Rencana Pelatihan</label>
                            <input type="text" class="form-control form-control-solid" name="pelatihan"
                                placeholder="Training apa?" />
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger w-100">
                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-3"></i> Tambah SDM
                </a>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-10"></div>

    <!-- 3.6 PROCESS -->
    <div class="mb-10">
        <h3 class="fw-bold text-dark mb-5">6. Process (Proses Layanan)</h3>
        <div class="repeater-init">
            <div data-repeater-list="pemasaran_process">
                <div data-repeater-item>
                    <div class="form-group row mb-5 border-bottom pb-5">
                        <div class="col-md-2 mb-3">
                            <label class="form-label required">Langkah Ke-</label>
                            <input type="number" class="form-control form-control-solid" name="langkah_ke"
                                placeholder="1" />
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label required">Penjelasan Langkah</label>
                            <textarea class="form-control form-control-solid" name="penjelasan" rows="1"
                                placeholder="Apa yang dilakukan?"></textarea>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger w-100">
                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-3"></i> Tambah Langkah
                </a>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-10"></div>

    <!-- 3.7 PHYSICAL EVIDENCE -->
    <div class="mb-10">
        <h3 class="fw-bold text-dark mb-5">7. Physical Evidence (Bukti Fisik)</h3>
        <div class="repeater-init">
            <div data-repeater-list="pemasaran_physical">
                <div data-repeater-item>
                    <div class="form-group row mb-5 border-bottom pb-5">
                        <div class="col-md-3 mb-3">
                            <label class="form-label required">Bukti Fisik</label>
                            <input type="text" class="form-control form-control-solid" name="bukti_fisik"
                                placeholder="Misal: Logo, Seragam, Brosur" />
                        </div>
                        <div class="col-md-7 mb-3">
                            <label class="form-label">Penjelasan/Fungsi</label>
                            <textarea class="form-control form-control-solid" name="penjelasan" rows="1"
                                placeholder="Fungsi bukti fisik ini"></textarea>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger w-100">
                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-3"></i> Tambah Bukti
                </a>
            </div>
        </div>
    </div>
</div>