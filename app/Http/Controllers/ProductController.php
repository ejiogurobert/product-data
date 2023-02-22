<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ResponseJsonTrait;

class ProductController extends Controller
{
    use ResponseJsonTrait;
    public function getProduct(Request $request)
    {
        $fetchData = Product::select('sku', 'name', 'price', 'category');

        $category = ($request->category) ?? null;
        $price_less_than = ($request->price_less_than) ?? null;

        $fetchData->when($category, function ($dbCategory, $category) {
            return $dbCategory->where('category', $category);
        });

        $fetchData->when($price_less_than, function ($dbPrice, $price_less_than) {
            return $dbPrice->where('price->original', $price_less_than);
        });

        return $this->responseJson('fetched data successfully', $this->checkPagination($fetchData, $request->per_page), 200);
    }

    public function checkPagination($query, int $page)
    {
        return ($page) ? $query->paginate($page) : $query->paginate(5);
    }
}
