<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $external_url
 */
class ProductCategory extends Model
{
    use HasFactory;

    /**
     * Get the product types for the category.
     */
    public function productTypes(): MorphToMany
    {
        return $this->morphToMany(ProductType::class, 'type_assignable', 'type_assignments')
            ->withPivot('my_bonus_field');
    }

    /**
     * Scope to filter categories by matching product types.
     *
     * @param Builder $query
     * @param array $typeIds Product type IDs to match
     * @return Builder
     */
    public function scopeWithMatchingTypes(Builder $query, array $typeIds): Builder
    {
        return $query->whereHas('productTypes', function (Builder $subQuery) use ($typeIds) {
            $subQuery->whereIn('product_types.id', $typeIds);
        });
    }
}