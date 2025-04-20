<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'phone2' => $this->faker->text(255),
            'follow_date' => $this->faker->date(),
            'stage_id' => \App\Models\Stage::factory(),
            'contract_id' => \App\Models\Contract::factory(),
            'card_id' => \App\Models\Card::factory(),
        ];
    }
}
