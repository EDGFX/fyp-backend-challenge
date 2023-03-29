<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Open CSV file containing product data
        $csvData = fopen(base_path('database/csv/products.csv'), 'r');

        // Skip first row (header row) of the CSV file
        $prodRow = true;
        // Loop through each row of the CSV file
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            // Skip the first row of the CSV file
            if (!$prodRow) {
                // Create a new Product record with data from the CSV file
                Product::create([
                    'cat' => $data['0'],
                    'product' => $data['1'],
                    'price' => $data['2'],
                    'sale' => $data['3']
                ]);
            }
            $prodRow = false;
        }
        // Close the CSV file
        fclose($csvData);
    }
}
