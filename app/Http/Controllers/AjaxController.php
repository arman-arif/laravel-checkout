<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getProducts()
    {
        return Product::latest()->paginate();
    }

    public function getProduct(Product $product)
    {
        return $product;
    }
}
