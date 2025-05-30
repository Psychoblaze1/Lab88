<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Component>
 */
class ComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'asset_id' => \App\Models\Asset::inRandomOrder()->first()->id,
            'name' => $this->faker->numerify('COMP: ' . $this->faker->word() . ' ###'),
        ];
    }
}
