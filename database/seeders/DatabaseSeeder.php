<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UsersSeeder::class,
        ]);

        \App\Models\Inventory\Product::factory()->count(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Wikla Pandu',
        //     'email' => 'admin@admin.com',
        //     'password' => \Illuminate\Support\Facades\Hash::make('kuk!r4kur4kur4'),
        // ]);
    }
}
