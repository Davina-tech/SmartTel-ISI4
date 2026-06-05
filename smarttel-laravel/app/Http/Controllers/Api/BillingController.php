<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::with('customer')
            ->paginate(15);

        return response()->json($billings);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,customer_id'],
            'monthly_charges' => ['required', 'numeric', 'min:0'],
            'total_charges' => ['required', 'numeric', 'min:0'],
        ]);

        $billing = Billing::create($data);

        return response()->json($billing, Response::HTTP_CREATED);
    }

    public function show(Billing $billing)
    {
        $billing->load('customer');

        return response()->json([
            'billing' => $billing,
            'annual_charges' => $billing->annual_charges,
            'is_high_value' => $billing->isHighValueCustomer(),
        ]);
    }

    public function update(Request $request, Billing $billing)
    {
        $data = $request->validate([
            'monthly_charges' => ['sometimes', 'numeric', 'min:0'],
            'total_charges' => ['sometimes', 'numeric', 'min:0'],
        ]);

        $billing->update($data);

        return response()->json($billing);
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
