<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Principal>
 */
class PrincipalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'nip' => $this->faker->text,
            'address' => $this->faker->text,
            'email' => $this->faker->email,
            'accounting_email' => $this->faker->email,
            'website' => $this->faker->url,
            'password' => $this->faker->password,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
