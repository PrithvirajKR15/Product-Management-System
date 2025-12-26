<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'attribute_key',
        'attribute_value',
    ];

    /**
     * Get the product that owns the product attribute.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
