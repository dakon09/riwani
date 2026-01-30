<div class="w-100">
    <div class="pb-10 pb-lg-15">
        <h2 class="fw-bold text-dark">Tahap 2: Riset Pasar</h2>
        <div class="text-muted fw-semibold fs-6">Analisis pasar dan pesaing untuk produk Anda.</div>
    </div>

    <!--begin::Repeater-->
    <div class="repeater-init">
        <!--begin::Form group-->
        <div class="form-group">
            <div data-repeater-list="riset_pasar">
                <div data-repeater-item>
                    <div class="form-group row mb-5 border-bottom pb-5">
                        <div class="col-md-3">
                            <label class="form-label required">Produk/Jasa</label>
                            <input type="text" class="form-control form-control-solid mb-2 mb-md-0" name="produk"
                                placeholder="Nama Produk" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required">Target Pelanggan</label>
                            <input type="text" class="form-control form-control-solid mb-2 mb-md-0" name="pelanggan"
                                placeholder="Target Pelanggan" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Kebutuhan Pelanggan</label>
                            <textarea class="form-control form-control-solid mb-2 mb-md-0" name="kebutuhan" rows="1"
                                placeholder="Apa yang dibutuhkan?"></textarea>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:;" data-repeater-delete
                                class="btn btn-sm btn-light-danger mt-3 mt-md-9 w-100">
                                <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></i> Hapus
                            </a>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">Pesaing Utama</label>
                            <input type="text" class="form-control form-control-solid mb-2 mb-md-0" name="pesaing"
                                placeholder="Nama Pesaing" />
                        </div>
                        <div class="col-md-8 mt-3">
                            <label class="form-label">Celah/Peluang Pasar</label>
                            <textarea class="form-control form-control-solid mb-2 mb-md-0" name="celah_pasar" rows="1"
                                placeholder="Kelebihan kita dibanding pesaing"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Form group-->

        <!--begin::Form group-->
        <div class="form-group mt-5">
            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                <i class="ki-duotone ki-plus fs-3"></i>
                Tambah Riset
            </a>
        </div>
        <!--end::Form group-->
    </div>
    <!--end::Repeater-->
</div>

<script>
    // Initialize Repeater (This script block will need to be executed properly, 
    // ideally moved to a main JS file, but placed here for immediate UI testing if parsed)
    // Note: Metronic uses 'jquery.repeater' usually.
    // For now, assume global initialization or manual init in layout.
</script>