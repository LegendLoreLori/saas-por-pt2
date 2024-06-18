<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>1,
            'title' => fake()->sentence(3),
            'description'=> fake()->paragraph(4),
            'salary'=> fake()->numberBetween(40000, 110000),
            'company'=> fake()->company(),
            'address'=> fake()->streetAddress(),
            'city'=> fake()->city(),
            'phone'=> fake()->phoneNumber(),
            'email'=> fake()->safeEmail(),
            'requirements'=> fake()->paragraph(),
            'benefits'=> fake()->paragraph(1)
        ];
    }
}
