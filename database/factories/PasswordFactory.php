<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Password>
 */
class PasswordFactory extends Factory
{
    protected $model = \App\Models\Password::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'password' => 'secret-password',
            'expires_at' => Carbon::now()->addHours(2),
            'visit_limit' => $this->faker->numberBetween(1, 5),
            'visit_count' => 0,
        ];
    }
}
