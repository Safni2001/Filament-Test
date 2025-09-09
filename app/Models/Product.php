<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property int|null $product_category_id
 * @property int|null $product_color_id
 * @property string $description
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Get the category that owns the product.
     */
    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Get the color that owns the product.
     */
    public function productColor(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class);
    }

    /**
     * Get the product types for the product.
     */
    public function productTypes(): MorphToMany
    {
        return $this->morphToMany(ProductType::class, 'type_assignable', 'type_assignments', 'type_assignable_id', 'product_type_id')
            ->withPivot('my_bonus_field')
            ->withTimestamps();
    }
}