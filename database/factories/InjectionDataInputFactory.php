<?php

namespace Database\Factories;

use App\Models\MasterData;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InjectionDataInput>
 */
class InjectionDataInputFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_part' => MasterData::factory(),
            'qty_hasil' => $this->faker->numberBetween(10, 500),
            'tanggal_input' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'operator_id' => User::factory(),
        ];
    }
}

