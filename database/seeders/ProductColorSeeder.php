<?php

namespace Database\Seeders;

use App\Models\ProductColor;
use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Green', 'hex_code' => '#00FF00'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Cyan', 'hex_code' => '#00FFFF'],
            ['name' => 'Magenta', 'hex_code' => '#FF00FF'],
            ['name' => 'Gray', 'hex_code' => '#999999'],
            ['name' => 'Orange', 'hex_code' => '#FF9900'],
            ['name' => 'Purple', 'hex_code' => '#9900FF'],
            ['name' => 'Brown', 'hex_code' => '#993300'],
            ['name' => 'Pink', 'hex_code' => '#FF99CC'],
            ['name' => 'Teal', 'hex_code' => '#009999'],
            ['name' => 'Lime', 'hex_code' => '#99FF00'],
        ];

        foreach ($colors as $color) {
            ProductColor::create($color);
        }
    }
}