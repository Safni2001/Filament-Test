<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Dashboard widget displaying key model statistics
 * 
 * Shows counts for Products, Categories, Types, Colors, and Users
 * with trend indicators and descriptive labels
 */
class ModelStatsWidget extends StatsOverviewWidget
{
    /**
     * Widget sort order on dashboard
     */
    protected static ?int $sort = 1;

    /**
     * Polling interval in seconds (5 minutes)
     */
    protected ?string $pollingInterval = '300s';

    /**
     * Get the stats to display
     * 
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Active products in catalog')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success')
                ->chart($this->getProductTrendData()),

            Stat::make('Product Categories', ProductCategory::count())
                ->description('Category classifications')
                ->descriptionIcon('heroicon-m-tag')
                ->color('info'),

            Stat::make('Product Types', ProductType::count())
                ->description('Type definitions')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('warning'),

            Stat::make('Product Colors', ProductColor::count())
                ->description('Available color options')
                ->descriptionIcon('heroicon-m-swatch')
                ->color('danger'),

            Stat::make('System Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Records', $this->getTotalRecords())
                ->description('All model records combined')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('gray'),
        ];
    }

    /**
     * Get product trend data for chart
     * 
     * @return array<int>
     */
    private function getProductTrendData(): array
    {
        // Simple trend data - can be enhanced with actual date-based queries
        return [
            Product::where('created_at', '>=', now()->subDays(30))->count(),
            Product::where('created_at', '>=', now()->subDays(25))->count(),
            Product::where('created_at', '>=', now()->subDays(20))->count(),
            Product::where('created_at', '>=', now()->subDays(15))->count(),
            Product::where('created_at', '>=', now()->subDays(10))->count(),
            Product::where('created_at', '>=', now()->subDays(5))->count(),
            Product::count(),
        ];
    }

    /**
     * Calculate total records across all main models
     * 
     * @return int
     */
    private function getTotalRecords(): int
    {
        return Product::count() + 
               ProductCategory::count() + 
               ProductType::count() + 
               ProductColor::count() + 
               User::count();
    }
}
