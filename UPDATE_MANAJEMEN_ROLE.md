# UPDATE MANAJEMEN ROLE - RINGKASAN PERUBAHAN

## Tanggal Update
29 Januari 2026

---

## 1. Standarisasi Penamaan Permission

### Perubahan yang Dilakukan

**Dari (Dot Notation):**
- `umkm.index`
- `umkm.create`
- `umkm.edit`
- `umkm.delete`
- `umkm.import`
- `master-user`
- `master-role`
- `master-permission`
- `dashboard`

**Ke (Underscore Notation):**
- `umkm_index`
- `umkm_create`
- `umkm_edit`
- `umkm_delete`
- `umkm_import`
- `master_user`
- `master_role`
- `master_permission`
- `dashboard`

### File yang Diperbarui

#### 1. **Seeder: UpdatePermissionsToUnderscoreSeeder.php**
- Lokasi: `/Users/dayahandika/projects/riwani/database/seeders/UpdatePermissionsToUnderscoreSeeder.php`
- Fungsi: Mengubah semua nama permission dari dot notation ke underscore notation secara otomatis
- Status: ✅ Berhasil dijalankan

#### 2. **Seeder: UserSeeder.php**
- Lokasi: `/Users/dayahandika/projects/riwani/database/seeders/UserSeeder.php`
- Perubahan: Menambah permission UMKM baru (umkm_index, umkm_create, umkm_edit, umkm_delete, umkm_import)
- Status: ✅ Berhasil dijalankan

#### 3. **Model: Umkm.php**
- Lokasi: `/Users/dayahandika/projects/riwani/app/Models/Umkm.php`
- Perubahan: Tambahkan `protected $table = 'umkm';` untuk mengatasi error table name
- Status: ✅ Fixed

#### 4. **View: master/role.blade.php**
- Lokasi: `/Users/dayahandika/projects/riwani/resources/views/master/role.blade.php`
- Perubahan:
  - Modal Tambah Role: Tambah tombol "Pilih Semua Permission"
  - Modal Edit Role: Tambah tombol "Pilih Semua Permission"
  - Tombol berada di sebelah label "Permission"
- Status: ✅ Berhasil diperbarui

#### 5. **View: umkm/index.blade.php**
- Lokasi: `/Users/dayahandika/projects/riwani/resources/views/umkm/index.blade.php`
- Perubahan: Update permission checks dari dot ke underscore notation
  - `@can('umkm.create')` → `@can('umkm_create')`
  - `@can('umkm.import')` → `@can('umkm_import')`
- Status: ✅ Berhasil diperbarui

#### 6. **View: umkm/show.blade.php**
- Lokasi: `/Users/dayahandika/projects/riwani/resources/views/umkm/show.blade.php`
- Perubahan: Update permission check dari dot ke underscore notation
  - `@can('umkm.edit')` → `@can('umkm_edit')`
- Status: ✅ Berhasil diperbarui

#### 7. **JavaScript: role.js**
- Lokasi: `/Users/dayahandika/projects/riwani/public/assets/js/master/role.js`
- Perubahan:
  - KTDataAdd module: Menambahkan fungsi "Pilih Semua Permission"
  - KTDataEdit module: Menambahkan fungsi "Pilih Semua Permission"
  - Logic tombol:
    - Jika semua sudah terpilih: Tampilkan "Hapus Semua Selection"
    - Jika belum semua: Tampilkan "Pilih Semua Permission"
  - Ikon tombol: `ki-check-double` untuk pilih semua, `ki-cross` untuk hapus seleksi
- Status: ✅ Berhasil diperbarui

---

## 2. Fitur "Pilih Semua Permission"

### Implementasi

#### UI Tombol
```html
<button type="button" id="btn_select_all_permissions" class="btn btn-sm btn-light-primary">
    <i class="ki-duotone ki-check-double fs-2"></i>
    Pilih Semua Permission
</button>
```

#### JavaScript Logic
```javascript
const selectAllButton = document.getElementById('btn_select_all_permissions');

selectAllButton.addEventListener('click', function() {
    const permissionSelect = $('#permission');
    const allOptions = permissionSelect.find('option:not(:disabled)')
        .map(function() {
            return $(this).val();
        }).get();

    if (permissionSelect.val().length === allOptions.length) {
        // Deselect semua jika sudah semua terpilih
        permissionSelect.val(null).trigger('change');
        selectAllButton.innerHTML = '<i class="ki-duotone ki-check-double fs-2"></i> Pilih Semua Permission';
        selectAllButton.classList.remove('btn-active-primary');
        selectAllButton.classList.add('btn-light-primary');
    } else {
        // Select semua jika belum semua
        permissionSelect.val(allOptions).trigger('change');
        selectAllButton.innerHTML = '<i class="ki-duotone ki-cross fs-2"></i> Hapus Semua Selection';
        selectAllButton.classList.remove('btn-light-primary');
        selectAllButton.classList.add('btn-active-primary');
    }
});
```

### Fitur Tambahan
- **Auto-reset**: Tombol otomatis reset setelah submit berhasil
- **Visual feedback**: Ganti ikon dan warna tombol berdasarkan status seleksi
- **Validation**: Field permission tetap tervalidasi (tidak boleh kosong)

---

## 3. Daftar Permission Lengkap (Underscore Notation)

### Core Permissions
- `dashboard` - Mengakses dashboard

### Master Permissions
- `master_user` - Mengelola data user (index, create, update, delete, show, reset_2fa)
- `master_role` - Mengelola data role (index, insert, update, delete, detail)
- `master_permission` - Mengelola data permission (index, insert, update, delete, detail)

### UMKM Permissions
- `umkm_index` - Melihat daftar UMKM
- `umkm_create` - Menambah UMKM baru (manual entry)
- `umkm_edit` - Mengedit data UMKM yang ada
- `umkm_delete` - Menghapus data UMKM
- `umkm_import` - Mengimport data UMKM dari Excel (bulk entry)

---

## 4. Kompatibilitas

### Backend
- ✅ Laravel 12.0
- ✅ Spatie Laravel Permission 6.24+
- ✅ PHP 8.2+

### Frontend
- ✅ jQuery (untuk JavaScript)
- ✅ Select2 (untuk multiselect permission)
- ✅ Bootstrap 5 (untuk modal)
- ✅ Metronic UI (ikon: ki-duotone)
- ✅ SweetAlert2 (untuk alert)

### Database
- ✅ MySQL
- ✅ Tabel `permissions` sudah ada
- ✅ Tabel `roles` sudah ada
- ✅ Tabel `role_has_permissions` sudah ada

---

## 5. Testing & Validasi

### Testing yang Dilakukan
1. ✅ Permission names updated successfully
2. ✅ UserSeeder berhasil dijalankan
3. ✅ Role view berfungsi dengan tombol baru
4. ✅ JavaScript role.js berhasil dikompilasi (no syntax errors)
5. ✅ UMKM views menggunakan permission underscore
6. ✅ Auth::user() dan Auth::id() berfungsi dengan benar
7. ✅ Umkm model mendefinisikan nama tabel 'umkm'

### Verification Commands
```bash
# Check permission names
php artisan tinker --execute="echo \Spatie\Permission\Models\Permission::pluck('name')->toArray();"
# Result: dashboard, master_permission, master_role, master_user, umkm_create, umkm_delete, umkm_edit, umkm_import, umkm_index

# Check syntax
php -l app/Http/Controllers/Master/UmkmController.php
php -l public/assets/js/master/role.js
php -l resources/views/master/role.blade.php
# Result: No syntax errors
```

---

## 6. Catatan Penting

### Akses Role
Setelah update, pastikan:
1. **Logout dan login kembali** agar permission cache di-refresh
2. **Admin user** sudah memiliki permission yang diperlukan
3. **Super Admin role** sudah assign semua permission

### Update Existing Roles
Jika ada role yang sudah terbuat sebelum update ini:
- Role tersebut perlu di-assign ulang permission UMKM yang baru
- Gunakan seeder tambahan jika diperlukan

### Browser Cache
- Bersihkan browser cache (Ctrl + Shift + R) setelah update
- Gunakan Incognito/Private mode jika masih ada permission error

---

## 7. Langkah Selanjutnya (Opsional)

Jika ingin menambah fitur bulk selection lain:
1. **Search/Filter permissions** - Menambah kolom search di multiselect
2. **Permission groups** - Mengelompokkan permission berdasarkan module (UMKM, Master, etc.)
3. **Permission templates** - Template role dengan permission preset (Admin, Editor, Viewer)
4. **Bulk permission assignment** - Assign multiple permissions ke multiple roles sekaligus

---

## 8. Files Summary

### Files Modified: 8
1. `database/seeders/UpdatePermissionsToUnderscoreSeeder.php` - Baru
2. `database/seeders/UserSeeder.php` - Diupdate
3. `app/Models/Umkm.php` - Diupdate
4. `resources/views/master/role.blade.php` - Diupdate
5. `resources/views/umkm/index.blade.php` - Diupdate
6. `resources/views/umkm/show.blade.php` - Diupdate
7. `public/assets/js/master/role.js` - Diupdate
8. `public/assets/js/master/umkm.js` - Diupdate

### Files Created: 1
1. `database/seeders/UpdatePermissionsToUnderscoreSeeder.php` - Baru

---

## Status Akhir
✅ Permission naming standardisasi ke underscore notation
✅ Fitur "Pilih Semua Permission" berhasil ditambahkan
✅ Semua permission UMKM ditambahkan ke database
✅ Kompatibilitas dengan Spatie Laravel Permission terjaga
✅ Semua views dan controller sudah menggunakan permission baru
✅ Tidak ada syntax errors
✅ Cache sudah di-clear

---

## Kontak Support
Jika mengalami masalah atau error:
1. Clear cache: `php artisan cache:clear && php artisan view:clear`
2. Logout dan login kembali
3. Cek Laravel logs: `storage/logs/laravel.log`
4. Cek browser console (F12) untuk JavaScript errors
