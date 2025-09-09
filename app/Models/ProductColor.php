<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $hex_code
 */
class ProductColor extends Model
{
    use HasFactory;

    /**
     * Get the products that belong to this color.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}