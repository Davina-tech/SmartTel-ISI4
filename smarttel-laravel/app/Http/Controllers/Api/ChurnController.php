<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Churn;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChurnController extends Controller
{
    public function index()
    {
        $churns = Churn::with('customer')
            ->paginate(15);

        return response()->json($churns);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,customer_id'],
            'churn_status' => ['required', 'in:Yes,No'],
        ]);

        $churn = Churn::create($data);

        return response()->json($churn, Response::HTTP_CREATED);
    }

    public function show(Churn $churn)
    {
        $churn->load('customer');

        return response()->json([
            'churn' => $churn,
            'is_churned' => $churn->isChurned(),
            'formatted_status' => $churn->formatted_status,
        ]);
    }

    public function update(Request $request, Churn $churn)
    {
        $data = $request->validate([
            'churn_status' => ['sometimes', 'in:Yes,No'],
        ]);

        $churn->update($data);

        return response()->json($churn);
    }

    public function destroy(Churn $churn)
    {
        $churn->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function churned()
    {
        $churns = Churn::churned()
            ->with('customer')
            ->paginate(15);

        return response()->json($churns);
    }

    public function active()
    {
        $churns = Churn::active()
            ->with('customer')
            ->paginate(15);

        return response()->json($churns);
    }
}
