# BRIEF TEKNIS FINAL
## Modul: Business Plan UMKM – Riwani Globe (100% SYB Compliant)

Dokumen ini berisi **matrix teknis lengkap** untuk pengembangan modul Business Plan UMKM, disusun **100% mengikuti struktur dan tabel pada dokumen SYB (Start Your Business – Rencana Usaha)**.

Struktur matrix:
**Stage → Sub-Form → Tabel → Field → Tipe Data**

Dokumen ini ditujukan sebagai **acuan langsung tim development (Backend, Frontend, QA)** tanpa interpretasi ulang.

---

## Prinsip Teknis
- Stage tetap (S1–S10)
- Sub-form mengikuti pembagian tabel di buku SYB
- Tabel bersifat repeatable (array of object)
- Semua data disimpan dalam `data_json`
- Hasil perhitungan disimpan dalam `calculated_json`
- Tidak ada dynamic workflow atau custom field

---

## S1 – Ide Usaha
### Sub-Form: Narasi Ide Usaha
| Field | Tipe Data |
|---|---|
| nama_usaha | string |
| jenis_usaha | enum (produsen, jasa, pengecer, grosir, lainnya) |
| produk_jasa | text |
| pelanggan | text |
| cara_menjual | text |
| kebutuhan_pelanggan | text |
| motivasi_usaha | text |

---

## S2 – Riset Pasar
### Sub-Form: Tabel Riset Pasar
| Field | Tipe Data |
|---|---|
| produk | string |
| pelanggan | string |
| kebutuhan_preferensi | text |
| pesaing | string |
| celah_pasar | text |

---

## S3 – Rencana Pemasaran (7P)

### S3.1 Product
| Field | Tipe Data |
|---|---|
| produk | string |
| kualitas | string |
| warna | string |
| ukuran | string |
| kemasan | string |
| sertifikasi | string |

### S3.2 Price
| Field | Tipe Data |
|---|---|
| produk | string |
| biaya | decimal |
| harga_pelanggan | decimal |
| harga_pesaing | decimal |
| harga_jual | decimal |
| alasan_harga | text |
| diskon | string |
| alasan_diskon | text |
| kredit | string |
| alasan_kredit | text |

### S3.3 Place (Narasi)
| Field | Tipe Data |
|---|---|
| lokasi_usaha | text |
| alasan_lokasi | text |
| biaya_lokasi_bulanan | decimal |
| metode_distribusi | string |
| alasan_distribusi | text |

### S3.4 Promotion
| Field | Tipe Data |
|---|---|
| sarana_promosi | string |
| rincian | text |
| biaya | decimal |

### S3.5 People
| Field | Tipe Data |
|---|---|
| posisi | string |
| kriteria | text |
| pelatihan | text |

### S3.6 Process
| Field | Tipe Data |
|---|---|
| langkah_ke | integer |
| penjelasan | text |

### S3.7 Physical Evidence
| Field | Tipe Data |
|---|---|
| bukti_fisik | string |
| penjelasan | text |

---

## S4 – Estimasi Penjualan
### Sub-Form: Estimasi Penjualan Bulanan
| Field | Tipe Data |
|---|---|
| produk | string |
| jenis_distribusi | enum (langsung, pengecer, grosir) |
| jan | integer |
| feb | integer |
| mar | integer |
| apr | integer |
| mei | integer |
| jun | integer |
| jul | integer |
| agu | integer |
| sep | integer |
| okt | integer |
| nov | integer |
| des | integer |
| total_volume | integer (auto) |

**Calculated JSON**
- total_volume_penjualan (integer)
- total_penjualan_pasar (integer)
- pangsa_pasar (decimal)

---

## S5 – Struktur Organisasi & SDM

### S5.1 Struktur Organisasi
| Field | Tipe Data |
|---|---|
| tugas | text |
| posisi | string |
| staf | integer |

### S5.2 Persyaratan & Biaya Staf
| Field | Tipe Data |
|---|---|
| tugas | text |
| keterampilan | text |
| dikerjakan_oleh | string |
| upah_bulanan | decimal |
| kontribusi_pensiun_asuransi | decimal |

---

## S6 – Badan Usaha & Kepatuhan

### S6.1 Bentuk Badan Usaha
| Field | Tipe Data |
|---|---|
| bentuk_usaha | enum (perorangan, cv, pt, koperasi) |
| alasan | text |
| nama_pemilik | string |
| jabatan | string |
| skill | text |
| pengalaman | text |

### S6.2 Tanggung Jawab & Asuransi
| Field | Tipe Data |
|---|---|
| pajak | string |
| peraturan_ketenagakerjaan | string |
| lisensi | string |
| biaya_lisensi | decimal |
| asuransi | string |
| biaya_asuransi | decimal |
| tanggung_jawab_lain | text |

---

## S7 – Perhitungan Biaya Usaha

### S7.1 Biaya Produk (Conditional)
| Field | Tipe Data |
|---|---|
| produk | string |
| bahan_baku | decimal |
| tenaga_kerja | decimal |
| overhead | decimal |
| total_biaya_produk | decimal (auto) |

### S7.2 Biaya Tetap
| Field | Tipe Data |
|---|---|
| jenis_biaya | string |
| nilai_bulanan | decimal |

### S7.3 Depresiasi
| Field | Tipe Data |
|---|---|
| aset | string |
| harga_beli | decimal |
| umur_pakai_bulan | integer |
| penyusutan_bulanan | decimal (auto) |

### S7.4 Biaya Tidak Tetap
| Field | Tipe Data |
|---|---|
| produk | string |
| kuantitas_bulanan | integer |
| biaya_per_item | decimal |
| total_bulanan | decimal (auto) |

### S7.5 Pembelian Bulanan
| Field | Tipe Data |
|---|---|
| produk | string |
| estimasi_terjual | integer |
| harga_beli | decimal |
| total_biaya | decimal (auto) |

---

## S8 – Rencana Keuangan

### S8.1 Rencana Penjualan
| Field | Tipe Data |
|---|---|
| bulan | string |
| volume | integer |
| harga | decimal |
| total | decimal (auto) |

### S8.2 Rencana Biaya
| Field | Tipe Data |
|---|---|
| biaya_tetap | decimal |
| biaya_tidak_tetap | decimal |
| total_biaya | decimal (auto) |

### S8.3 Rencana Keuntungan
| Field | Tipe Data |
|---|---|
| pendapatan | decimal |
| laba_kotor | decimal |
| laba_bersih | decimal |

### S8.4 Arus Kas
| Field | Tipe Data |
|---|---|
| bulan | string |
| kas_masuk | decimal |
| kas_keluar | decimal |
| saldo | decimal (auto) |

---

## S9 – Modal Awal & Pembiayaan

### S9.1 Modal Awal
| Field | Tipe Data |
|---|---|
| kebutuhan | string |
| nilai | decimal |

### S9.2 Sumber Modal
| Field | Tipe Data |
|---|---|
| sumber | string |
| nilai | decimal |
| jaminan | string |

### S9.3 Jadwal Pelunasan Pinjaman
| Field | Tipe Data |
|---|---|
| periode | string |
| cicilan_pokok | decimal |
| bunga | decimal |
| asuransi | decimal |
| sisa_pinjaman | decimal |

---

## S10 – Ringkasan Eksekutif
### Sub-Form: Narasi
| Field | Tipe Data |
|---|---|
| ringkasan_usaha | text |
| produk_pasar | text |
| proyeksi_keuangan | text |
| kebutuhan_pendanaan | text |

---

## Catatan Akhir untuk Development
- Semua tabel adalah **array of object**
- Semua perhitungan dilakukan **server-side**
- Field bertipe decimal disimpan **tanpa format mata uang**
- Validasi mengikuti ketentuan wajib pada buku SYB
- Tidak ada penambahan field di luar dokumen ini tanpa change request resmi

---

**Dokumen ini adalah versi FINAL (v2) dan menjadi baseline pengembangan modul Business Plan UMKM Riwani Globe.**

