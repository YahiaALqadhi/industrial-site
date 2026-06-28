<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class AdminTestEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin']);
    }

    public function index()
    {
        $mailConfig = [
            'default' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'username' => config('mail.mailers.smtp.username'),
            'from_address' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
        ];

        return view('admin.test-email.index', compact('mailConfig'));
    }

    public function send(Request $request)
    {
        try {
            Mail::to(config('mail.from.address'))->send(new TestMail());
            $message = 'Test email sent successfully to ' . config('mail.from.address');
            \Log::info('Test email sent successfully from admin panel');
            return back()->with('success', $message);
        } catch (\Throwable $e) {
            $message = 'Test email failed: ' . $e->getMessage();
            \Log::error('Test email failed from admin panel: ' . $e->getMessage());
            return back()->with('error', $message);
        }
    }
}
