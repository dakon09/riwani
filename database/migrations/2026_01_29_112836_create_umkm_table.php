<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('umkm_code', 20)->unique();
            $table->string('nama_usaha');
            $table->enum('jenis_usaha', ['Jasa', 'Dagang', 'Manufaktur']);
            $table->string('sektor_usaha');
            $table->year('tahun_berdiri')->nullable();
            $table->text('alamat_usaha');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->enum('status_umkm', ['DRAFT', 'REGISTERED', 'ACTIVE', 'INACTIVE'])->default('DRAFT');
            $table->enum('source_input', ['MANUAL', 'IMPORT'])->default('MANUAL');

            $table->string('nama_pemilik');
            $table->string('nik_pemilik', 16)->nullable();
            $table->string('no_hp', 15);
            $table->string('email')->nullable();
            $table->text('alamat_pemilik')->nullable();

            $table->enum('bentuk_badan_usaha', ['Perorangan', 'CV', 'PT'])->default('Perorangan');
            $table->string('npwp', 20)->nullable();
            $table->string('nib', 20)->nullable();
            $table->string('izin_usaha')->nullable();
            $table->enum('status_legalitas', ['LENGKAP', 'BELUM'])->default('BELUM');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['nama_usaha', 'no_hp']);
            $table->index('status_umkm');
            $table->index('source_input');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
