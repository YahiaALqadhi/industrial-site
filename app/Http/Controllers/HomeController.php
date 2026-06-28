<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('front.home', compact('featuredCategories', 'services'));
    }
}
