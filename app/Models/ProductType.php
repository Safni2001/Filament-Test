<?php

namespace App\Models;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property int|null $api_unique_number
 * @property string|null $street_name
 * @property string|null $suburb
 * @property string|null $postcode
 * @property string|null $state
 */
class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'api_unique_number',
        'street_name',
        'suburb',
        'postcode',
        'state',
    ];

    /**
     * Get the product categories that own the type.
     */
    public function productCategories(): MorphToMany
    {
        return $this->morphedByMany(ProductCategory::class, 'type_assignable', 'type_assignments', 'product_type_id', 'type_assignable_id')
            ->withPivot('my_bonus_field')
            ->withTimestamps();
    }

    /**
     * Get the products that own the type.
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'type_assignable', 'type_assignments', 'product_type_id', 'type_assignable_id')
            ->withPivot('my_bonus_field')
            ->withTimestamps();
    }
}