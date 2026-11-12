<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => fake()->name(),
            'username'       => fake()->unique()->userName(),
            'password'       => static::$password ??= Hash::make('password'),
            'role'           => 'petugas',
            'job'            => 'Petugas Lapangan',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * State untuk Admin
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'job'  => 'Administrator',
        ]);
    }
}
