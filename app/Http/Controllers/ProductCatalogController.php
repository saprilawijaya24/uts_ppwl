<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCatalogController extends Controller
{
    /**
     * Menampilkan katalog produk
     */
    public function index(): View
    {
        // Ambil semua produk dengan kategori
        $products = Product::with('category')->get();
        
        // Stats untuk katalog
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalStock = Product::sum('stok');

        return view('product-catalog.index', compact(
            'products', 
            'totalProducts',
            'totalCategories',
            'totalStock'
        ));
    }
}