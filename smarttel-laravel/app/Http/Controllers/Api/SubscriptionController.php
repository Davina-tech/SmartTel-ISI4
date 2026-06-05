<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('customer')
            ->paginate(15);

        return response()->json($subscriptions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,customer_id'],
            'tenure' => ['required', 'integer', 'min:0'],
            'contract' => ['required', 'in:Month-to-month,One year,Two year'],
            'paperless_billing' => ['required', 'in:Yes,No'],
            'payment_method' => ['required', 'in:Electronic check,Mailed check,Bank transfer,Credit card'],
        ]);

        $subscription = Subscription::create($data);

        return response()->json($subscription, Response::HTTP_CREATED);
    }

    public function show(Subscription $subscription)
    {
        $subscription->load('customer');

        return response()->json([
            'subscription' => $subscription,
            'tenure_category' => $subscription->tenure_category,
            'is_long_term_contract' => $subscription->isLongTermContract(),
            'is_electronic_payment' => $subscription->isElectronicPayment(),
        ]);
    }

    public function update(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'tenure' => ['sometimes', 'integer', 'min:0'],
            'contract' => ['sometimes', 'in:Month-to-month,One year,Two year'],
            'paperless_billing' => ['sometimes', 'in:Yes,No'],
            'payment_method' => ['sometimes', 'in:Electronic check,Mailed check,Bank transfer,Credit card'],
        ]);

        $subscription->update($data);

        return response()->json($subscription);
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function monthlyContract()
    {
        $subscriptions = Subscription::monthlyContract()
            ->with('customer')
            ->paginate(15);

        return response()->json($subscriptions);
    }

    public function longTermContract()
    {
        $subscriptions = Subscription::longTermContract()
            ->with('customer')
            ->paginate(15);

        return response()->json($subscriptions);
    }

    public function paperBilling()
    {
        $subscriptions = Subscription::paperBilling()
            ->with('customer')
            ->paginate(15);

        return response()->json($subscriptions);
    }
}
