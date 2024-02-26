<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->nik(),
            'no_kk' => $this->faker->unique()->nik(),
            'nama' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTime(),
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
            'agama' => $this->faker->randomElement(['Islam','Kristen','Katolik','Hindu','Budha']),
            'pendidikan' => $this->faker->randomElement(['Tidak / Belum Sekolah','Belum Tamat SD/Sederajat','Tamat SD / Sederajat']),
            'pekerjaan' => $this->faker->randomElement(['Wiraswasta','Lainnya','Dokter']),
            'gol_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'kode_wilayah_ktp' => '35.15.15.2009',
            'alamat_ktp' => $this->faker->streetAddress(),
            'no_telp' => $this->faker->unique()->phoneNumber(),
            'ktp_desa' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['warga','tinggal ditempat lain karena bekerja/bersekolah','meninggal','pindah']),
            

        ];
    }
}
