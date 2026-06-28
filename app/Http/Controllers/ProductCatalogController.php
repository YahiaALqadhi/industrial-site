<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductCatalogController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('front.products.index', compact('categories'));
    }

    public function category(string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $subcategories = Category::query()
            ->where('parent_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        $breadcrumbs = $this->breadcrumbs($category);

        return view('front.products.category', compact('category', 'subcategories', 'products', 'breadcrumbs'));
    }

    public function product(string $slug)
    {
        $product = Product::query()
            ->with(['category', 'images', 'features'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $breadcrumbs = $this->breadcrumbs($product->category);

        return view('front.products.show', compact('product', 'breadcrumbs'));
    }

    private function breadcrumbs(Category $category): array
    {
        $trail = [];
        $current = $category;

        while ($current) {
            $trail[] = $current;
            $current = $current->parent;
        }

        return array_reverse($trail);
    }
}
