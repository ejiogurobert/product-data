<?php

namespace App\Jobs;

use Throwable;
use App\Models\Product;
use App\Traits\ProductTrait;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProductJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ProductTrait;

    private $csv;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csv)
    {
        $this->csv = $csv;
        // dd($this->csv);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->csv as $product) {
            $productDiscount = $this->discountCalculator($product['sku'], $product['category'], $product['price']);
            // dd($productDiscount);
            Product::firstOrCreate([
                "sku" => $product['sku'],
                "name" => $product['name'],
                "category" => $product['category'],
                "price" => [
                    "original" => $product['price'],
                    "final" => $productDiscount['newPrice'],
                    "discount_percentage" => $productDiscount['discount'],
                    "currency" => "EUR"
                ]
            ]);
        }
    }

    public function failed(Throwable $exception)
    {
        dd('failed job');
    }
}
