<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAdmin', $request->user());

        $totalCategories = Category::query()->count();
        $totalProducts = Product::query()->count();
        $totalServices = Service::query()->count();
        $totalInquiries = Inquiry::query()->count();

        $newInquiriesCount = Inquiry::query()->where('status', Inquiry::STATUS_NEW)->count();

        $recentInquiries = Inquiry::query()
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalServices',
            'totalInquiries',
            'newInquiriesCount',
            'recentInquiries'
        ));
    }
}
