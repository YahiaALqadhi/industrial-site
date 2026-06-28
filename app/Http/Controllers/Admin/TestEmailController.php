<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class TestEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin']);
    }

    public function send(Request $request)
    {
        try {
            Mail::to(config('mail.from.address'))->send(new TestMail());
            \Log::info('Test email sent successfully to ' . config('mail.from.address'));
            return back()->with('success', 'Test email sent successfully to ' . config('mail.from.address'));
        } catch (\Throwable $e) {
            \Log::error('Test email failed: ' . $e->getMessage());
            return back()->with('error', 'Test email failed: ' . $e->getMessage());
        }
    }
}
