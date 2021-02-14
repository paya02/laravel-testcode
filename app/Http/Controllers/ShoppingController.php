<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    private $product;

    public function __construct(
        Product $product
    )
    {
        $this->product = $product;
    }

    /**
     * 商品一覧
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = $this->product->all();

        return view('shoppings.index', compact('products'));
    }
}
