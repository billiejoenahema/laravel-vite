<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
final class CustomerFactory extends Factory
{
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
            'gender' => Gender::randomValue(),
            'birth_date' => $this->faker->date('Y-m-d', 'yesterday'),
            'postal_code' => $this->faker->postcode(),
            'pref' => $this->faker->numberBetween(1, 47),
            'city' => $this->faker->city(),
            'street' => $this->faker->streetAddress(),
            'avatar' => 'https://picsum.photos/200',
        ];
    }
}
