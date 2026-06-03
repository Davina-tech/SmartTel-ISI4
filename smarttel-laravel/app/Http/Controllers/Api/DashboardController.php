<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Churn;
use App\Models\Customer;
use App\Models\Billing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Récupérer les statistiques globales du dashboard
     */
    public function statistics()
    {
        $totalCustomers = Customer::count();
        $totalBillings = Billing::sum('total_charges');
        $churnedCount = Churn::where('churn_status', 'Yes')->count();
        $activeCount = Churn::where('churn_status', 'No')->count();
        $churnRate = $totalCustomers > 0 ? round(($churnedCount / $totalCustomers) * 100, 2) : 0;

        return response()->json([
            'total_customers' => $totalCustomers,
            'total_revenue' => $totalBillings,
            'churned_count' => $churnedCount,
            'active_count' => $activeCount,
            'churn_rate' => $churnRate,
        ]);
    }

    /**
     * Récupérer tous les clients avec leurs données
     */
    public function allCustomers(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        
        $customers = Customer::with([
            'churn',
            'billings' => function ($q) { $q->latest()->limit(1); },
            'services',
            'subscriptions' => function ($q) { $q->latest()->limit(1); }
        ])->paginate($perPage);

        return response()->json($customers);
    }

    /**
     * Récupérer les statistiques par genre
     */
    public function genderStatistics()
    {
        $byGender = Customer::selectRaw('gender, COUNT(*) as count, COUNT(CASE WHEN churns.churn_status = "Yes" THEN 1 END) as churned')
            ->leftJoin('churns', 'customers.customer_id', '=', 'churns.customer_id')
            ->groupBy('gender')
            ->get();

        return response()->json($byGender);
    }

    /**
     * Récupérer les revenus mensuels moyens
     */
    public function revenueStats()
    {
        $averageRevenue = Billing::avg('monthly_charges');
        $totalRevenue = Billing::sum('monthly_charges');
        $maxRevenue = Billing::max('monthly_charges');
        $minRevenue = Billing::min('monthly_charges');

        return response()->json([
            'average_revenue' => round($averageRevenue, 2),
            'total_revenue' => round($totalRevenue, 2),
            'max_revenue' => round($maxRevenue, 2),
            'min_revenue' => round($minRevenue, 2),
        ]);
    }

    /**
     * Récupérer les clients à risque de churn
     */
    public function riskCustomers()
    {
        $riskCustomers = Churn::where('churn_status', 'Yes')
            ->with(['customer' => function ($query) {
                $query->with('billings');
            }])
            ->limit(20)
            ->get();

        return response()->json($riskCustomers);
    }
    
}
