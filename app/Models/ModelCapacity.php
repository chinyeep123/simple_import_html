<?php

namespace App\Models;

use App\Classes\Common;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class ModelCapacity extends Model
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
        'brand_model_id',
        'name',
        'slug',
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
    protected static $logName = 'brand_model';

    /**
     * Function used to customize activity log description
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Brand Model has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'brand_model_id',
                'name',
                'slug',
                'status',
            ]);
        // Chain fluent methods for configuration options
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Common::replaceEmptySpace($model->name);
        });
    }

    /**
     * Get relationship belongsTo.
     */
    public function brandModel()
    {
        return $this->belongsTo(BrandModel::class);
    }
}
