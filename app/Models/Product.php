<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory,
        LogsActivity,
        CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'type_brand_id',
        'brand_model_id',
        'status',
    ];


    /**
     * Log all $fillable attributes
     *
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * Save activity log only if attribute changed
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * Prevent save logs items that have no changed attribute
     *
     * @var bool
     */
    protected static $submitEmptyLogs = false;

    /**
     * Custom name activity log
     *
     * @var string
     */
    protected static $logName = 'product';

    /**
     * Function used to customize activity log description
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Product has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'type_id',
                'type_brand_id',
                'brand_model_id',
                'status',
            ]);
        // Chain fluent methods for configuration options
    }

    /**
     * Get relationship belongsTo.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get relationship belongsTo.
     */
    public function typeBrand()
    {
        return $this->belongsTo(TypeBrand::class);
    }

    /**
     * Get relationship belongsTo.
     */
    public function brandModel()
    {
        return $this->belongsTo(BrandModel::class);
    }

    /**
     * Get relationship belongsTo.
     */
    public function modelCapacity()
    {
        return $this->belongsTo(ModelCapacity::class);
    }

    /**
     * Get relationship hasMany.
     */
    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }
}
