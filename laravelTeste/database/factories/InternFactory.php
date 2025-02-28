<?php

namespace Database\Factories;

use App\Enums\Interns\Gender;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intern>
 */
class InternFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->name(),
            'gender' => fake()->randomElement(Gender::cases())->value,
            'birth' => fake()->date(),
            'cpf' => fake()->unique()->numerify('###########')
        ];
    }

    public function phones():HasMany
    {
        return $this->hasMany(Phone::class);
    }

}
