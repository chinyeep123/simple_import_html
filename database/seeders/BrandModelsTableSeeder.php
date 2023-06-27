<?php

namespace Database\Seeders;

use App\Models\BrandModel;
use App\Models\TypeBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BrandModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        BrandModel::truncate();
        Schema::enableForeignKeyConstraints();
        $brand = TypeBrand::where('slug', 'apple')->first();
        if ($brand) {
            $models = config('setting.seeder.brands');
            foreach ($models as $model) {
                BrandModel::create([
                    'type_brand_id' => $brand->getKey(),
                    'name' => $model,
                ]);
            }
        }
    }
}
