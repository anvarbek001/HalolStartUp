<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('email', 'adminstrator@gmail.com')->first();
        $party = $user->parties()->orderBy('id')->first();
        return [
            'party_id' => $party->id,
            'user_id' => $user->id,
            'qrcode_number' => random_int(12345678901000, 12345678909999),
            'scan_count' => random_int(10, 25)
        ];
    }
}
