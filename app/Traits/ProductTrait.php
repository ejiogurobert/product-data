<?php

namespace App\Traits;

use App\Models\Product;
use App\Jobs\ProductJob;
use Illuminate\Support\Facades\Bus;

trait ProductTrait
{
    public function extractData($csvFile)
    {

        if (file_exists($csvFile)) {
            $data = file($csvFile);
            $csv = array_map('str_getcsv', $data);
            array_walk($csv, function (&$a) use ($csv) {

                $a = array_combine($csv[0], $a);
            });
            array_shift($csv);
            //chunking data
            $chunks = array_chunk($csv, 500);

            $batch = Bus::batch([])->dispatch();
            foreach ($chunks as $key => $chunk) {
                $batch->add(new ProductJob($chunk));
            }
        } else {
            echo 'This file is not available';
        }
    }

    public function discountCalculator($sku, $category, $price)
    {
        $discount = null;
        if ($sku == 000003) {
            $discountedPrice = 0.15 * $price;
            $newPrice = $price - $discountedPrice;
            $discount = '15%';
        } elseif ($category == 'boots' || ($sku == 000003 && $category == 'boots')) {
            $discountedPrice = 0.3 * $price;
            $newPrice = $price - $discountedPrice;
            $discount = '30%';
        } else {
            $newPrice = $price;
        }
        return [
            'discount' => $discount,
            'newPrice' => $newPrice
        ];
    }
}
