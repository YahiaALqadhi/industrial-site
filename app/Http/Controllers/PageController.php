<?php

namespace App\Http\Controllers;

use App\Models\Service;

class PageController extends Controller
{
    public function about()
    {
        return view('front.about');
    }

    public function services()
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('front.services', compact('services'));
    }

    public function contact()
    {
        return view('front.contact');
    }
}
