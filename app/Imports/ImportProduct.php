<?php

namespace App\Imports;

use App\Classes\Common;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class ImportProduct implements OnEachRow, WithValidation, WithBatchInserts, WithChunkReading, ShouldQueue, WithHeadingRow
{
    /**
     * @param Row $row
     */
    public function onRow(Row $row)
    {
        $row = $row->toCollection();
        $types = Common::replaceEmptySpace($row['types']);
        $brand = Common::replaceEmptySpace($row['brand']);
        $model = Common::replaceEmptySpace($row['model']);
        $capacity = Common::replaceEmptySpace($row['capacity']);
        $status = Str::lower($row['status']);
        $product = ProductDetail::whereHas('product.type', function ($query) use ($types) {
            $query->where('slug', $types);
        })
            ->whereHas('product.typeBrand', function ($query) use ($brand) {
                $query->where('slug', $brand);
            })
            ->whereHas('product.brandModel', function ($query) use ($model) {
                $query->where('slug', $model);
            })
            ->whereHas('product.modelCapacity', function ($query) use ($capacity) {
                $query->where('slug', $capacity);
            })
            ->first();

        $custom_properties = $row->put('import_module', 'product');
        if ($product && in_array($status, ['sold', 'buy'])) {
            $product->update([
                'quantity' => $status == 'sold' ? $product->quantity - 1 : $product->quantity + 1
            ]);
            activity()
                ->performedOn(new Product())
                ->withProperties($custom_properties)
                ->log("Item with Product ID " . $row['product_id'] . " import success");
        } else {
            // log this product fail to import
            activity()
                ->performedOn(new Product())
                ->withProperties($custom_properties)
                ->log("Item with Product ID " . $row['product_id'] . " fail import because invalid data");
        }
    }
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer'],
            'types' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'capacity' => ['required', 'string'],
            'status' => ['required', 'string'],
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
