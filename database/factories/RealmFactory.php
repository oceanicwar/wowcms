<?php

namespace Database\Factories;

use App\Enums\Emulators;
use App\Models\AuthDatabase;
use App\Models\Realm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Realm>
 */
class RealmFactory extends Factory
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
            'emulator' => Emulators::AZEROTHCORE,
            'auth_database_id' => AuthDatabase::factory(),
            'realmlist_id' => 1,
        ];
    }
}
