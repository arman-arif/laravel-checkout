<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('home', compact('products'));
    }

    public function dash()
    {
        if (request()->ajax()) {
            $products = Product::latest()->newQuery();
            return datatables()
                ->of($products)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return "<img src='{$row->image}' width='50' alt='' class='mx-auto img-thumbnail'>";
                })
                ->editColumn('price', function ($row) {
                    return '$' . number_format($row->price, 2);
                })
                ->addColumn('action', function ($row) {
                    $buyNow = route('buy-now', $row->id);
                    return "<a href=\"{$buyNow}\" class=\"btn btn-warning btn-sm\">Buy Now</a>";
                })
                ->rawColumns(['image', 'action'])
                ->make();
        }
        return view('dashboard');
    }
}
