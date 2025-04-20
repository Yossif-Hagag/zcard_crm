<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'flat_number' => $this->faker->text(255),
            'floor' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
        ];
    }
}
