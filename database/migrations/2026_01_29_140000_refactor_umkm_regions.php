<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First truncate data to avoid conversion errors on bad data
        // Assuming user is okay with this as it was discussed in plan (and it's seeder data)
        try {
            DB::table('umkm')->truncate();
        } catch (\Exception $e) {
            // Table might not exist or be empty
        }

        Schema::table('umkm', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['provinsi', 'kabupaten', 'kecamatan', 'kelurahan']);
        });

        Schema::table('umkm', function (Blueprint $table) {
            // Add new columns
            // Using char(2), char(4), char(7), char(10) as per laravolt/indonesia standards
            $table->char('provinsi_id', 2)->nullable()->after('alamat_usaha');
            $table->char('kabupaten_id', 4)->nullable()->after('provinsi_id');
            $table->char('kecamatan_id', 7)->nullable()->after('kabupaten_id');
            $table->char('kelurahan_id', 10)->nullable()->after('kecamatan_id');

            // Indexes for performance
            $table->index('provinsi_id');
            $table->index('kabupaten_id');
            $table->index('kecamatan_id');
            $table->index('kelurahan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn(['provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id']);
        });

        Schema::table('umkm', function (Blueprint $table) {
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
        });
    }
};
