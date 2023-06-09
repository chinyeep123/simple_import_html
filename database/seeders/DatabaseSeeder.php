<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);
        $this->call(TypesTableSeeder::class);
        $this->call(TypeBrandsTableSeeder::class);
        $this->call(BrandModelsTableSeeder::class);
        $this->call(ModelCapacitiesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
    }
}
