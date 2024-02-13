<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'pendidikan' => $this->faker->randomElement(['Tidak Sekolah','SD', 'SMP', 'SMA', 'S-1']),
            'pekerjaan' => $this->faker->randomElement(['Guru', 'PNS', 'Wirausaha', 'Buruh', 'Dokter']),
            'gol_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'kode_wilayah_ktp' => '35.15.15.2009',
            'alamat_ktp' => $this->faker->streetAddress(),
            'no_telp' => $this->faker->unique()->phoneNumber(),
            'ktp_desa' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['warga','tinggal ditempat lain karena bekerja/bersekolah','meninggal','pindah']),
            

        ];
    }
}
