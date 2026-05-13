<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nomor_registrasi' => 'REG' . fake()->unique()->numerify('######'),
            'asal_sekolah' => fake()->company() . ' School',
            'nisn' => fake()->unique()->numerify('##########'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'siswa',
            'remember_token' => Str::random(10),
            'is_active' => false,
        ];
    }
}
