<?php

namespace Database\Seeders;

use App\Classes\Common;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Type;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        ProductDetail::truncate();
        Schema::enableForeignKeyConstraints();

        $samples = config('setting.seeder.products');
        foreach ($samples as $sample) {
            $type = Type::join('type_brands', 'type_brands.type_id', '=', 'types.id')
                ->join('brand_models', 'brand_models.type_brand_id', 'type_brands.id')
                ->join('model_capacities', 'model_capacities.brand_model_id', 'brand_models.id')
                ->where('types.slug', Common::replaceEmptySpace($sample['type']))
                ->where('type_brands.slug', Common::replaceEmptySpace($sample['brand']))
                ->where('brand_models.slug', Common::replaceEmptySpace($sample['model']))
                ->where('model_capacities.slug', Common::replaceEmptySpace($sample['capacity']))
                ->select(['types.id as type_id', 'type_brands.id as type_brand_id', 'brand_models.id as brand_model_id', 'model_capacities.id as model_capacity_id'])
                ->first();

            if ($type) {
                $product = Product::firstOrCreate([
                    'type_id' => $type->type_id,
                    'type_brand_id' => $type->type_brand_id,
                    'brand_model_id' => $type->brand_model_id,
                    'model_capacity_id' => $type->model_capacity_id,
                ]);
                $product->details()->create([
                    'quantity' => $sample['quantity'],
                ]);
            }
        }
    }
}
