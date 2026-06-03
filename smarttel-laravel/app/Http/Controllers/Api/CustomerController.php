<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['billings', 'churn', 'services', 'subscription'])
            ->paginate(15);

        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'string', 'max:255', Rule::unique('customers', 'customer_id')],
            'gender' => ['nullable', 'string', 'max:50'],
            'senior_citizen' => ['sometimes', 'boolean'],
            'partner' => ['nullable', 'string', 'max:10'],
            'dependents' => ['nullable', 'string', 'max:10'],
        ]);

        $customer = Customer::create($data);

        return response()->json($customer, Response::HTTP_CREATED);
    }

    public function show(Customer $customer)
    {
        $customer->load(['billings', 'churn', 'services', 'subscription']);

        return response()->json([
            'customer' => $customer,
            'profile' => $customer->full_profile,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'gender' => ['nullable', 'string', 'max:50'],
            'senior_citizen' => ['sometimes', 'boolean'],
            'partner' => ['nullable', 'string', 'max:10'],
            'dependents' => ['nullable', 'string', 'max:10'],
        ]);

        $customer->update($data);

        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
