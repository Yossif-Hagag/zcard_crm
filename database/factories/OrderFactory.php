<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->text(255),
            'customer_phone' => $this->faker->text(255),
            'customer_address' => $this->faker->text(255),
            'cost' => $this->faker->randomNumber(0),
            'order_date' => $this->faker->date(),
            'delivery_date' => $this->faker->date(),
            'card_name' => [],
            'status_id' => \App\Models\Status::factory(),
            'lead_id' => \App\Models\Lead::factory(),
        ];
    }
}
