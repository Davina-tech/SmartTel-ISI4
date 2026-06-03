<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Service;
use App\Models\Billing;
use App\Models\Churn;
use Illuminate\Support\Facades\DB;

class TelcoChurnSeeder extends Seeder
{
    public function run()
    {
        // Chemin vers votre fichier CSV
        $csvFile = database_path('seeders/data/telco_churn.csv');
        
        if (!file_exists($csvFile)) {
            echo "❌ Fichier CSV non trouvé: " . $csvFile . "\n";
            echo "Veuillez placer le fichier CSV dans: database/seeders/data/telco_churn.csv\n";
            return;
        }
        
        $file = fopen($csvFile, 'r');
        $header = fgetcsv($file); // Lire l'en-tête
        
        echo "📥 Importation du fichier CSV...\n";
        $count = 0;
        
        DB::beginTransaction();
        
        try {
            while (($row = fgetcsv($file)) !== false) {
                $data = array_combine($header, $row);
                
                // Nettoyer les valeurs vides
                foreach ($data as $key => $value) {
                    if ($value === '' || $value === ' ') {
                        $data[$key] = null;
                    }
                }
                
                // 1. Créer le Customer
                $customer = Customer::updateOrCreate(
                    ['customer_id' => $data['customerID']],
                    [
                        'gender' => $data['gender'] ?? null,
                        'senior_citizen' => $data['SeniorCitizen'] ?? 0,
                        'partner' => $data['Partner'] ?? null,
                        'dependents' => $data['Dependents'] ?? null,
                    ]
                );
                
                // 2. Créer le Subscription
                if (isset($data['tenure']) && $data['tenure'] !== null) {
                    Subscription::updateOrCreate(
                        ['customer_id' => $customer->customer_id],
                        [
                            'tenure' => (int)$data['tenure'],
                            'contract' => $data['Contract'] ?? null,
                            'paperless_billing' => $data['PaperlessBilling'] ?? null,
                            'payment_method' => $data['PaymentMethod'] ?? null,
                        ]
                    );
                }
                
                // 3. Créer les Services
                Service::updateOrCreate(
                    ['customer_id' => $customer->customer_id],
                    [
                        'phone_service' => $data['PhoneService'] ?? 'No',
                        'multiple_lines' => $data['MultipleLines'] ?? 'No',
                        'internet_service' => $data['InternetService'] ?? 'No',
                        'online_security' => $data['OnlineSecurity'] ?? 'No',
                        'online_backup' => $data['OnlineBackup'] ?? 'No',
                        'device_protection' => $data['DeviceProtection'] ?? 'No',
                        'tech_support' => $data['TechSupport'] ?? 'No',
                        'streaming_tv' => $data['StreamingTV'] ?? 'No',
                        'streaming_movies' => $data['StreamingMovies'] ?? 'No',
                    ]
                );
                
                // 4. Créer le Billing
                if (isset($data['MonthlyCharges']) && $data['MonthlyCharges'] !== null) {
                    Billing::updateOrCreate(
                        ['customer_id' => $customer->customer_id],
                        [
                            'monthly_charges' => (float)$data['MonthlyCharges'],
                            'total_charges' => $data['TotalCharges'] !== null ? (float)$data['TotalCharges'] : 0,
                        ]
                    );
                }
                
                // 5. Créer le Churn
                if (isset($data['Churn'])) {
                    Churn::updateOrCreate(
                        ['customer_id' => $customer->customer_id],
                        ['churn_status' => $data['Churn']]
                    );
                }
                
                $count++;
                
                if ($count % 100 == 0) {
                    echo "✅ Importé: $count clients...\n";
                }
            }
            
            DB::commit();
            echo "🎉 Importation terminée avec succès !\n";
            echo "Total clients importés: $count\n";
            
        } catch (\Exception $e) {
            DB::rollback();
            echo "❌ Erreur: " . $e->getMessage() . "\n";
            echo "Ligne problématique: " . json_encode($row ?? []) . "\n";
        }
        
        fclose($file);
    }
}
