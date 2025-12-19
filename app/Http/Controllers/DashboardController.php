<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function index(): View
    {
        $products = Product::all();
        return view('dashboard', ['products' => $products]);
    }
}
