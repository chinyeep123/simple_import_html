<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\TypeBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TypeBrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        TypeBrand::truncate();
        Schema::enableForeignKeyConstraints();

        $type = Type::where('slug', 'smartphone')->first();
        if ($type) {
            TypeBrand::create([
                'type_id' => $type->getKey(),
                'name' => 'Apple',
            ]);
        }
    }
}
