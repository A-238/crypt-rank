<?php

namespace Database\Factories;

use App\Models\DigitalCurrency;
use Illuminate\Database\Eloquent\Factories\Factory;

class DigitalCurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DigitalCurrency::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'symbol' => strtoupper($this->faker->unique()->word),
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(8, 0, 99999999.99999999),
            'market_cap' => $this->faker->randomFloat(8, 0, 99999999.99999999),
        ];
    }
}
