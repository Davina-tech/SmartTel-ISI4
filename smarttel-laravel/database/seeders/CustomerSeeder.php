<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/customers.txt');

        // Lire toutes les lignes du fichier
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            [$id, $gender, $senior, $partner, $dependents] = explode(',', trim($line));

            Customer::create([
                'customerID'    => $id,
                'gender'        => $gender,
                'SeniorCitizen' => (bool)$senior,
                'Partner'       => (bool)$partner,
                'Dependents'    => (bool)$dependents,
            ]);
        }
    }
}

