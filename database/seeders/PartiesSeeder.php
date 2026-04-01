<?php

namespace Database\Seeders;

use App\Models\Party;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'adminstrator@gmail.com')->first();
        Party::create([
            'user_id' => $user->id,
            'brand_id' => $user->brand->id,
            'name' => 'Test1',
            'rating' => 5,
            'description' => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.",
            'order' => 1,
            'image' => 'brandImages/1774509827_11. Закат.jpg',
            'status' => 'active',
            'price' => 15000
        ]);
    }
}
