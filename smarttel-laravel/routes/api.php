<?php

use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\ChurnController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Customers
Route::apiResource('customers', CustomerController::class);

// Billings
Route::apiResource('billings', BillingController::class);

// Churns
Route::apiResource('churns', ChurnController::class);
Route::get('churns/filter/churned', [ChurnController::class, 'churned']);
Route::get('churns/filter/active', [ChurnController::class, 'active']);

// Services
Route::apiResource('services', ServiceController::class);
Route::get('services/filter/with-internet', [ServiceController::class, 'withInternet']);

// Subscriptions
Route::apiResource('subscriptions', SubscriptionController::class);
Route::get('subscriptions/filter/monthly-contract', [SubscriptionController::class, 'monthlyContract']);
Route::get('subscriptions/filter/long-term-contract', [SubscriptionController::class, 'longTermContract']);
Route::get('subscriptions/filter/paper-billing', [SubscriptionController::class, 'paperBilling']);

// Dashboard
Route::prefix('dashboard')->group(function () {
    Route::get('statistics', [DashboardController::class, 'statistics']);
    Route::get('customers', [DashboardController::class, 'allCustomers']);
    Route::get('gender-stats', [DashboardController::class, 'genderStatistics']);
    Route::get('revenue-stats', [DashboardController::class, 'revenueStats']);
    Route::get('risk-customers', [DashboardController::class, 'riskCustomers']);
    Route::get('/dashboard/statistics', [DashboardController::class, 'statistics']);
    Route::get('/dashboard/churn-seniors', [DashboardController::class, 'churnBySenior']);
});

