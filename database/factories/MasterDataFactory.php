<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasterData>
 */
class MasterDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $proses = ['injection', 'assembling', 'delivery'];
        $status = ['active', 'inactive'];
        
        return [
            'kode_part' => 'PT-' . $this->faker->unique()->numberBetween(1000, 9999),
            'nama_part' => $this->faker->words(3, true) . ' Part',
            'proses' => $this->faker->randomElement($proses),
            'status' => $this->faker->randomElement($status),
        ];
    }
}

