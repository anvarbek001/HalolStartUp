<?php

namespace Database\Seeders;

use App\Models\Viloyat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class ViloyatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $viloyats = [
            ['name' => "Andijon viloyati",     'order' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Buxoro viloyati",      'order' => '2', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Farg'ona viloyati",    'order' => '3', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Jizzax viloyati",      'order' => '4', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Namangan viloyati",    'order' => '5', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Navoiy viloyati",      'order' => '6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Qashqadaryo viloyati", 'order' => '7', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Qoraqalpog'iston",     'order' => '8', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Samarqand viloyati",   'order' => '9', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Sirdaryo viloyati",    'order' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Surxondaryo viloyati", 'order' => '11', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Toshkent shahri",      'order' => '12', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Toshkent viloyati",    'order' => '13', 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Xorazm viloyati",      'order' => '14', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('viloyats')->insertOrIgnore($viloyats);
    }
}
