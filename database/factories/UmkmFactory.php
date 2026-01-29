<?php

namespace Database\Factories;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Umkm>
 */
class UmkmFactory extends Factory
{
    protected $model = Umkm::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random village to ensure hierarchy consistency
        // Fallback to null if no data seeded yet (handle gracefully? or fail?)
        // Assuming seeding is done.
        $village = \Laravolt\Indonesia\Models\Village::inRandomOrder()->first();
        // If no village found (empty DB), we might error out or default to null.
        // We'll assume DB is populated.

        $district = $village ? $village->district : null;
        $city = $district ? $district->city : null;
        $province = $city ? $city->province : null;

        return [
            'umkm_code' => 'UMKM' . $this->faker->unique()->numberBetween(10000, 99999),
            'nama_usaha' => $this->faker->company,
            'jenis_usaha' => $this->faker->randomElement(['Jasa', 'Dagang', 'Manufaktur']),
            'sektor_usaha' => $this->faker->word,
            'tahun_berdiri' => $this->faker->year,
            'alamat_usaha' => $this->faker->address,
            'provinsi_id' => $province?->code,
            'kabupaten_id' => $city?->code,
            'kecamatan_id' => $district?->code,
            'kelurahan_id' => $village?->code,
            'kode_pos' => $this->faker->postcode,
            'status_umkm' => $this->faker->randomElement(['DRAFT', 'REGISTERED', 'ACTIVE', 'INACTIVE']),
            'source_input' => 'MANUAL',
            'nama_pemilik' => $this->faker->name,
            'nik_pemilik' => $this->faker->numerify('################'),
            'no_hp' => $this->faker->numerify('08##########'),
            'email' => $this->faker->email,
            'alamat_pemilik' => $this->faker->address,
            'bentuk_badan_usaha' => $this->faker->randomElement(['Perorangan', 'CV', 'PT']),
            'npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            'nib' => $this->faker->numerify('#############'),
            'izin_usaha' => $this->faker->bothify('IUMK-????-####'),
            'status_legalitas' => $this->faker->randomElement(['BELUM', 'LENGKAP']),
            'created_by' => User::first()->id ?? 1,
        ];
    }
}
