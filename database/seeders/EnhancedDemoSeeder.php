<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Enhanced demo seeder for comprehensive sample data
 * 
 * Creates realistic product management data including:
 * - Categories with descriptions
 * - Colors with proper hex codes
 * - Product types with API integration data
 * - Products with full relationships
 * - Admin user account
 */
class EnhancedDemoSeeder extends Seeder
{
    /**
     * Run the database seeds
     */
    public function run(): void
    {
        $this->createAdminUser();
        $this->createProductCategories();
        $this->createProductColors();
        $this->createProductTypes();
        $this->createProducts();
        $this->assignPolymorphicRelationships();
    }

    /**
     * Create admin user for testing
     */
    private function createAdminUser(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }

    /**
     * Create comprehensive product categories
     */
    private function createProductCategories(): void
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Clothing', 'description' => 'Fashion and apparel items'],
            ['name' => 'Books', 'description' => 'Books and educational materials'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and gardening'],
            ['name' => 'Sports & Outdoors', 'description' => 'Athletic and outdoor equipment'],
            ['name' => 'Health & Beauty', 'description' => 'Health and beauty products'],
            ['name' => 'Automotive', 'description' => 'Car parts and accessories'],
            ['name' => 'Toys & Games', 'description' => 'Children toys and board games'],
            ['name' => 'Office Supplies', 'description' => 'Business and office equipment'],
            ['name' => 'Food & Beverages', 'description' => 'Food items and drinks'],
        ];

        foreach ($categories as $category) {
            ProductCategory::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }

    /**
     * Create product colors with hex codes
     */
    private function createProductColors(): void
    {
        $colors = [
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Green', 'hex_code' => '#00FF00'],
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Purple', 'hex_code' => '#800080'],
            ['name' => 'Orange', 'hex_code' => '#FFA500'],
            ['name' => 'Pink', 'hex_code' => '#FFC0CB'],
            ['name' => 'Brown', 'hex_code' => '#A52A2A'],
            ['name' => 'Gray', 'hex_code' => '#808080'],
            ['name' => 'Navy', 'hex_code' => '#000080'],
            ['name' => 'Turquoise', 'hex_code' => '#40E0D0'],
            ['name' => 'Maroon', 'hex_code' => '#800000'],
            ['name' => 'Gold', 'hex_code' => '#FFD700'],
        ];

        foreach ($colors as $color) {
            ProductColor::firstOrCreate(
                ['name' => $color['name']],
                ['hex_code' => $color['hex_code']]
            );
        }
    }

    /**
     * Create product types with sample API data
     */
    private function createProductTypes(): void
    {
        $types = [
            [
                'name' => 'Physical Product',
                'api_unique_number' => 1001,
                'street_name' => '123 Main Street',
                'suburb' => 'Melbourne',
                'postcode' => '3000',
                'state' => 'VIC'
            ],
            [
                'name' => 'Digital Product',
                'api_unique_number' => 1002,
                'street_name' => '456 Collins Street',
                'suburb' => 'Melbourne',
                'postcode' => '3000',
                'state' => 'VIC'
            ],
            [
                'name' => 'Service',
                'api_unique_number' => 1003,
                'street_name' => '789 Flinders Street',
                'suburb' => 'Melbourne',
                'postcode' => '3000',
                'state' => 'VIC'
            ],
            [
                'name' => 'Bundle',
                'api_unique_number' => 1004,
                'street_name' => '321 Bourke Street',
                'suburb' => 'Melbourne',
                'postcode' => '3000',
                'state' => 'VIC'
            ],
            [
                'name' => 'Subscription',
                'api_unique_number' => 1005,
                'street_name' => '654 Swanston Street',
                'suburb' => 'Melbourne',
                'postcode' => '3000',
                'state' => 'VIC'
            ],
            [
                'name' => 'Limited Edition',
                'api_unique_number' => 1006,
                'street_name' => '987 Chapel Street',
                'suburb' => 'South Yarra',
                'postcode' => '3141',
                'state' => 'VIC'
            ],
            [
                'name' => 'Custom Made',
                'api_unique_number' => 1007,
                'street_name' => '147 Bridge Road',
                'suburb' => 'Richmond',
                'postcode' => '3121',
                'state' => 'VIC'
            ],
            [
                'name' => 'Wholesale',
                'api_unique_number' => 1008,
                'street_name' => '258 Lygon Street',
                'suburb' => 'Carlton',
                'postcode' => '3053',
                'state' => 'VIC'
            ],
        ];

        foreach ($types as $type) {
            ProductType::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }

    /**
     * Create diverse products with relationships
     */
    private function createProducts(): void
    {
        $categories = ProductCategory::all();
        $colors = ProductColor::all();

        $products = [
            ['name' => 'Smartphone Pro Max', 'description' => 'Latest flagship smartphone with advanced features', 'category' => 'Electronics', 'color' => 'Black'],
            ['name' => 'Wireless Headphones', 'description' => 'Premium noise-cancelling wireless headphones', 'category' => 'Electronics', 'color' => 'White'],
            ['name' => 'Gaming Laptop', 'description' => 'High-performance gaming laptop with RTX graphics', 'category' => 'Electronics', 'color' => 'Red'],
            ['name' => 'Designer T-Shirt', 'description' => 'Premium cotton designer t-shirt', 'category' => 'Clothing', 'color' => 'Blue'],
            ['name' => 'Running Shoes', 'description' => 'Professional running shoes for athletes', 'category' => 'Sports & Outdoors', 'color' => 'Green'],
            ['name' => 'Programming Guide', 'description' => 'Complete guide to modern web development', 'category' => 'Books', 'color' => 'Yellow'],
            ['name' => 'Coffee Maker', 'description' => 'Automatic drip coffee maker with timer', 'category' => 'Home & Garden', 'color' => 'Black'],
            ['name' => 'Vitamin Supplements', 'description' => 'Daily multivitamin supplements for health', 'category' => 'Health & Beauty', 'color' => 'Orange'],
            ['name' => 'Car Phone Mount', 'description' => 'Universal smartphone mount for vehicles', 'category' => 'Automotive', 'color' => 'Gray'],
            ['name' => 'Board Game Collection', 'description' => 'Classic family board game collection', 'category' => 'Toys & Games', 'color' => 'Purple'],
            ['name' => 'Ergonomic Chair', 'description' => 'Professional ergonomic office chair', 'category' => 'Office Supplies', 'color' => 'Black'],
            ['name' => 'Organic Tea Set', 'description' => 'Premium organic tea collection', 'category' => 'Food & Beverages', 'color' => 'Green'],
            ['name' => 'Smartwatch Series 5', 'description' => 'Advanced fitness tracking smartwatch', 'category' => 'Electronics', 'color' => 'Pink'],
            ['name' => 'Winter Jacket', 'description' => 'Waterproof winter jacket for extreme weather', 'category' => 'Clothing', 'color' => 'Navy'],
            ['name' => 'Yoga Mat Pro', 'description' => 'Non-slip premium yoga mat', 'category' => 'Sports & Outdoors', 'color' => 'Purple'],
            ['name' => 'Garden Tool Set', 'description' => 'Complete gardening tool collection', 'category' => 'Home & Garden', 'color' => 'Brown'],
            ['name' => 'Skincare Kit', 'description' => 'Complete daily skincare routine kit', 'category' => 'Health & Beauty', 'color' => 'Pink'],
            ['name' => 'Car Dash Cam', 'description' => 'HD dashboard camera with night vision', 'category' => 'Automotive', 'color' => 'Black'],
            ['name' => 'LEGO Architecture Set', 'description' => 'Famous building replica LEGO set', 'category' => 'Toys & Games', 'color' => 'White'],
            ['name' => 'Wireless Printer', 'description' => 'All-in-one wireless printer scanner', 'category' => 'Office Supplies', 'color' => 'White'],
            ['name' => 'Craft Beer Selection', 'description' => 'Curated craft beer tasting pack', 'category' => 'Food & Beverages', 'color' => 'Gold'],
            ['name' => 'Tablet Pro 12"', 'description' => 'Professional tablet for creative work', 'category' => 'Electronics', 'color' => 'Gray'],
            ['name' => 'Formal Dress Shirt', 'description' => 'Premium cotton formal dress shirt', 'category' => 'Clothing', 'color' => 'White'],
            ['name' => 'Camping Tent 4-Person', 'description' => 'Waterproof family camping tent', 'category' => 'Sports & Outdoors', 'color' => 'Green'],
            ['name' => 'Electric Kettle', 'description' => 'Fast-boiling electric kettle with temperature control', 'category' => 'Home & Garden', 'color' => 'Turquoise'],
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            $color = $colors->where('name', $productData['color'])->first();

            if ($category && $color) {
                Product::firstOrCreate(
                    ['name' => $productData['name']],
                    [
                        'description' => $productData['description'],
                        'product_category_id' => $category->id,
                        'product_color_id' => $color->id,
                    ]
                );
            }
        }
    }

    /**
     * Assign polymorphic relationships between products/categories and types
     */
    private function assignPolymorphicRelationships(): void
    {
        $products = Product::all();
        $categories = ProductCategory::all();
        $types = ProductType::all();

        // Assign random types to products
        foreach ($products as $product) {
            $randomTypes = $types->random(rand(1, 3));
            foreach ($randomTypes as $type) {
                $product->productTypes()->syncWithoutDetaching([
                    $type->id => ['my_bonus_field' => 'Product-' . rand(100, 999)]
                ]);
            }
        }

        // Assign random types to categories
        foreach ($categories as $category) {
            $randomTypes = $types->random(rand(1, 2));
            foreach ($randomTypes as $type) {
                $category->productTypes()->syncWithoutDetaching([
                    $type->id => ['my_bonus_field' => 'Category-' . rand(100, 999)]
                ]);
            }
        }
    }
}
