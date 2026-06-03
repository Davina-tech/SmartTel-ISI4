<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Billing;
use App\Models\Churn;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_api_crud(): void
    {
        $payload = [
            'customer_id' => 'CUST-001',
            'gender' => 'Female',
            'senior_citizen' => true,
            'partner' => 'Yes',
            'dependents' => 'No',
        ];

        $this->postJson('/api/customers', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['customer_id' => 'CUST-001', 'gender' => 'Female']);

        $this->getJson('/api/customers')
            ->assertStatus(200)
            ->assertJsonStructure(['current_page', 'data', 'links']);

        $this->getJson('/api/customers/CUST-001')
            ->assertStatus(200)
            ->assertJsonPath('customer.customer_id', 'CUST-001')
            ->assertJsonPath('customer.partner', 'Yes');

        $this->patchJson('/api/customers/CUST-001', ['partner' => 'No'])
            ->assertStatus(200)
            ->assertJsonFragment(['partner' => 'No']);

        $this->deleteJson('/api/customers/CUST-001')
            ->assertStatus(204);
    }

    public function test_billings_api_crud(): void
    {
        Customer::create([
            'customer_id' => 'CUST-002',
            'gender' => 'Male',
            'senior_citizen' => false,
            'partner' => 'No',
            'dependents' => 'Yes',
        ]);

        $payload = [
            'customer_id' => 'CUST-002',
            'monthly_charges' => 120.50,
            'total_charges' => 360.75,
        ];

        $this->postJson('/api/billings', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['customer_id' => 'CUST-002', 'total_charges' => '360.75']);

        $this->getJson('/api/billings')
            ->assertStatus(200)
            ->assertJsonStructure(['current_page', 'data', 'links']);

        $billingId = Billing::first()->id;

        $this->getJson("/api/billings/{$billingId}")
            ->assertStatus(200)
            ->assertJsonPath('billing.customer_id', 'CUST-002');

        $this->patchJson("/api/billings/{$billingId}", ['total_charges' => 400.00])
            ->assertStatus(200)
            ->assertJsonFragment(['total_charges' => '400.00']);

        $this->deleteJson("/api/billings/{$billingId}")
            ->assertStatus(204);
    }

    public function test_churns_api_crud_and_filters(): void
    {
        Customer::create([
            'customer_id' => 'CUST-003',
            'gender' => 'Male',
            'senior_citizen' => false,
            'partner' => 'No',
            'dependents' => 'No',
        ]);

        $payload = [
            'customer_id' => 'CUST-003',
            'churn_status' => 'Yes',
        ];

        $this->postJson('/api/churns', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['customer_id' => 'CUST-003', 'churn_status' => 'Yes']);

        $this->getJson('/api/churns/filter/churned')
            ->assertStatus(200)
            ->assertJsonStructure(['current_page', 'data', 'links'])
            ->assertJsonPath('data.0.churn_status', 'Yes');

        $churnId = Churn::first()->id;

        $this->getJson("/api/churns/{$churnId}")
            ->assertStatus(200)
            ->assertJsonPath('churn.churn_status', 'Yes')
            ->assertJsonPath('is_churned', true);

        $this->patchJson("/api/churns/{$churnId}", ['churn_status' => 'No'])
            ->assertStatus(200)
            ->assertJsonFragment(['churn_status' => 'No']);

        $this->getJson('/api/churns/filter/active')
            ->assertStatus(200)
            ->assertJsonStructure(['current_page', 'data', 'links'])
            ->assertJsonPath('data.0.churn_status', 'No');

        $this->deleteJson("/api/churns/{$churnId}")
            ->assertStatus(204);
    }

    public function test_services_api_crud_and_with_internet_filter(): void
    {
        Customer::create([
            'customer_id' => 'CUST-004',
            'gender' => 'Female',
            'senior_citizen' => false,
            'partner' => 'Yes',
            'dependents' => 'Yes',
        ]);

        $payload = [
            'customer_id' => 'CUST-004',
            'phone_service' => 'Yes',
            'multiple_lines' => 'No',
            'internet_service' => 'Fiber optic',
            'online_security' => 'Yes',
            'online_backup' => 'No',
            'device_protection' => 'Yes',
            'tech_support' => 'No',
            'streaming_tv' => 'Yes',
            'streaming_movies' => 'No',
        ];

        $this->postJson('/api/services', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['customer_id' => 'CUST-004', 'internet_service' => 'Fiber optic']);

        $this->getJson('/api/services/filter/with-internet')
            ->assertStatus(200)
            ->assertJsonStructure(['current_page', 'data', 'links'])
            ->assertJsonPath('data.0.internet_service', 'Fiber optic');

        $serviceId = Service::first()->id;

        $this->getJson("/api/services/{$serviceId}")
            ->assertStatus(200)
            ->assertJsonPath('service.customer_id', 'CUST-004')
            ->assertJsonPath('has_internet', true);

        $this->patchJson("/api/services/{$serviceId}", ['multiple_lines' => 'Yes'])
            ->assertStatus(200)
            ->assertJsonFragment(['multiple_lines' => 'Yes']);

        $this->deleteJson("/api/services/{$serviceId}")
            ->assertStatus(204);
    }

    public function test_subscriptions_api_crud_and_filters(): void
    {
        Customer::create([
            'customer_id' => 'CUST-005',
            'gender' => 'Female',
            'senior_citizen' => false,
            'partner' => 'No',
            'dependents' => 'No',
        ]);

        $payload = [
            'customer_id' => 'CUST-005',
            'tenure' => 3,
            'contract' => 'Month-to-month',
            'paperless_billing' => 'Yes',
            'payment_method' => 'Electronic check',
        ];

        $this->postJson('/api/subscriptions', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['customer_id' => 'CUST-005', 'contract' => 'Month-to-month']);

        $this->getJson('/api/subscriptions/filter/monthly-contract')
            ->assertStatus(200)
            ->assertJsonStructure(['current_page', 'data', 'links'])
            ->assertJsonPath('data.0.contract', 'Month-to-month');

        Subscription::create([
            'customer_id' => 'CUST-005',
            'tenure' => 24,
            'contract' => 'Two year',
            'paperless_billing' => 'No',
            'payment_method' => 'Credit card',
        ]);

        $subscriptionId = Subscription::where('contract', 'Two year')->first()->id;

        $this->getJson('/api/subscriptions/filter/long-term-contract')
            ->assertStatus(200)
            ->assertJsonPath('data.0.contract', 'Two year');

        $this->getJson('/api/subscriptions/filter/paper-billing')
            ->assertStatus(200)
            ->assertJsonPath('data.0.paperless_billing', 'No');

        $this->getJson("/api/subscriptions/{$subscriptionId}")
            ->assertStatus(200)
            ->assertJsonPath('subscription.contract', 'Two year')
            ->assertJsonPath('is_long_term_contract', true);

        $this->patchJson("/api/subscriptions/{$subscriptionId}", ['paperless_billing' => 'Yes'])
            ->assertStatus(200)
            ->assertJsonFragment(['paperless_billing' => 'Yes']);

        $this->deleteJson("/api/subscriptions/{$subscriptionId}")
            ->assertStatus(204);
    }
}
