<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Billing;
use App\Models\Churn;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SplFileObject;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Chemin du fichier CSV
        $csvPath = database_path('seeders/data/teleco_churn.csv');

        if (!file_exists($csvPath)) {
            $this->command->warn("Fichier CSV non trouvé: {$csvPath}");
            return;
        }

        $file = new SplFileObject($csvPath);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);

        // En-têtes
        $headers = null;
        $count = 0;
        $errors = 0;

        foreach ($file as $index => $row) {
            // Première ligne = headers
            if ($index === 0) {
                $headers = $row;
                continue;
            }

            if (empty($row[0])) continue;

            try {
                $data = array_combine($headers, $row);

                // Créer le client
                $customer = Customer::create([
                    'customer_id' => trim($data['customerID']),
                    'gender' => trim($data['gender']),
                    'senior_citizen' => (bool) intval($data['SeniorCitizen']),
                    'partner' => trim($data['Partner']),
                    'dependents' => trim($data['Dependents']),
                ]);

                // Créer la facturation
                Billing::create([
                    'customer_id' => $customer->customer_id,
                    'monthly_charges' => (float) $data['MonthlyCharges'],
                    'total_charges' => (float) $data['TotalCharges'],
                ]);

                // Créer les services
                Service::create([
                    'customer_id' => $customer->customer_id,
                    'phone_service' => trim($data['PhoneService']),
                    'multiple_lines' => trim($data['MultipleLines']),
                    'internet_service' => trim($data['InternetService']),
                    'online_security' => trim($data['OnlineSecurity']),
                    'online_backup' => trim($data['OnlineBackup']),
                    'device_protection' => trim($data['DeviceProtection']),
                    'tech_support' => trim($data['TechSupport']),
                    'streaming_tv' => trim($data['StreamingTV']),
                    'streaming_movies' => trim($data['StreamingMovies']),
                ]);

                // Créer la souscription
                Subscription::create([
                    'customer_id' => $customer->customer_id,
                    'tenure' => (int) $data['tenure'],
                    'contract' => trim($data['Contract']),
                    'paperless_billing' => trim($data['PaperlessBilling']),
                    'payment_method' => trim($data['PaymentMethod']),
                ]);

                // Créer le statut churn
                Churn::create([
                    'customer_id' => $customer->customer_id,
                    'churn_status' => trim($data['Churn']),
                ]);

                $count++;
            } catch (\Exception $e) {
                $errors++;
                $this->command->error("Erreur ligne " . ($index + 1) . ": " . $e->getMessage());
            }
        }

        $this->command->info("✓ {$count} clients importés avec succès");
        if ($errors > 0) {
            $this->command->warn("⚠ {$errors} erreurs détectées");
        }
    }
}
