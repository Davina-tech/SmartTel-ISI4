<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('customer')
            ->paginate(15);

        return response()->json($services);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,customer_id'],
            'phone_service' => ['nullable', 'in:Yes,No'],
            'multiple_lines' => ['nullable', 'in:Yes,No'],
            'internet_service' => ['nullable', 'in:Yes,No,Fiber optic,DSL,Cable'],
            'online_security' => ['nullable', 'in:Yes,No'],
            'online_backup' => ['nullable', 'in:Yes,No'],
            'device_protection' => ['nullable', 'in:Yes,No'],
            'tech_support' => ['nullable', 'in:Yes,No'],
            'streaming_tv' => ['nullable', 'in:Yes,No'],
            'streaming_movies' => ['nullable', 'in:Yes,No'],
        ]);

        $service = Service::create($data);

        return response()->json($service, Response::HTTP_CREATED);
    }

    public function show(Service $service)
    {
        $service->load('customer');

        return response()->json([
            'service' => $service,
            'active_services' => $service->active_services,
            'services_count' => $service->services_count,
            'has_internet' => $service->hasInternetService(),
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'phone_service' => ['sometimes', 'in:Yes,No'],
            'multiple_lines' => ['sometimes', 'in:Yes,No'],
            'internet_service' => ['sometimes', 'in:Yes,No,Fiber optic,DSL,Cable'],
            'online_security' => ['sometimes', 'in:Yes,No'],
            'online_backup' => ['sometimes', 'in:Yes,No'],
            'device_protection' => ['sometimes', 'in:Yes,No'],
            'tech_support' => ['sometimes', 'in:Yes,No'],
            'streaming_tv' => ['sometimes', 'in:Yes,No'],
            'streaming_movies' => ['sometimes', 'in:Yes,No'],
        ]);

        $service->update($data);

        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function withInternet()
    {
        $services = Service::withInternet()
            ->with('customer')
            ->paginate(15);

        return response()->json($services);
    }
}
