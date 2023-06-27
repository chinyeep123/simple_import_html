<?php

namespace Database\Seeders;

use App\Models\BrandModel;
use App\Models\ModelCapacity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ModelCapacitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ModelCapacity::truncate();
        Schema::enableForeignKeyConstraints();
        $models = BrandModel::get();
        $capacity_arr = config('setting.seeder.model_capacities');
        foreach ($models as $model) {
            $model->capacities()->createMany($capacity_arr[$model->slug]);
        }
    }
}
