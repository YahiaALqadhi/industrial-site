<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // الصفحة الرئيسية
        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // About
        $xml .= '<url>';
        $xml .= '<loc>' . route('about') . '</loc>';
        $xml .= '</url>';

        // Services
        $xml .= '<url>';
        $xml .= '<loc>' . route('services') . '</loc>';
        $xml .= '</url>';

        // Contact
        $xml .= '<url>';
        $xml .= '<loc>' . route('contact') . '</loc>';
        $xml .= '</url>';

        // Products
        $xml .= '<url>';
        $xml .= '<loc>' . route('products.index') . '</loc>';
        $xml .= '</url>';

        // Categories
        foreach (Category::all() as $category) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('products.category', $category->slug) . '</loc>';
            $xml .= '</url>';
        }

        // Products
        foreach (Product::all() as $product) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('products.show', $product->slug) . '</loc>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}