<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Consultant;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\Supplement;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // 1. Count Entities
        $totalCustomers = Customer::count();
        $totalConsultants = Consultant::count();
        $totalCouriers = Courier::count();
        $totalArticles = Article::count();
        // Count Supplements with stock > 0
        $totalActiveSupplements = Supplement::where('stock', '>', 0)->count();

        // 2. Calculate Revenue
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        $dailyRevenue = Orders::where('payment_status', 'paid')
                             ->whereDate('created_at', $today)
                             ->sum('total_amount');

        $monthlyRevenue = Orders::where('payment_status', 'paid')
                               ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                               ->sum('total_amount');

        $yearlyRevenue = Orders::where('payment_status', 'paid')
                              ->whereBetween('created_at', [$startOfYear, $endOfYear])
                              ->sum('total_amount');

        return [
            // --- User & Personnel Statistics ---
            Stat::make('Total Customers', $totalCustomers)
                ->description('All registered users')
                ->descriptionIcon('heroicon-o-user-group') // More generic user group icon
                ->color('info'), // A neutral, informative color

            Stat::make('Total Consultants', $totalConsultants)
                ->description('Health and fitness experts')
                ->descriptionIcon('heroicon-o-users') // Icon for individuals/experts
                ->color('primary'), // Primary action color

            Stat::make('Total Couriers', $totalCouriers)
                ->description('Active delivery partners')
                ->descriptionIcon('heroicon-o-truck')
                ->color('warning'), // Warning color for operational aspects

            // ---
            // --- Content & Product Statistics ---
            Stat::make('Total Active Supplements', $totalActiveSupplements)
                ->description('Products currently in stock')
                ->descriptionIcon('heroicon-o-cube')
                ->color('success'), // Good, positive for available stock

            Stat::make('Total Articles', $totalArticles)
                ->description('Published educational content')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('secondary'), // Secondary for content

            // ---
            // --- Revenue Statistics ---
            Stat::make('Today\'s Revenue', 'Rp ' . number_format($dailyRevenue, 0, ',', '.'))
                ->description('Paid orders from today')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'), // Success for revenue

            Stat::make('Monthly Revenue', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                ->description('Paid orders for this month')
                ->descriptionIcon('heroicon-o-banknotes') // Using banknotes for monthly to vary
                ->color('success'),

            Stat::make('Annual Revenue', 'Rp ' . number_format($yearlyRevenue, 0, ',', '.'))
                ->description('Paid orders for this year')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('success'),
        ];
    }
}
