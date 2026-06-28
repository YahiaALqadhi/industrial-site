<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactInquiryRequest;
use App\Http\Requests\ProductInquiryRequest;
use App\Mail\NewInquiryMail;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function contact(ContactInquiryRequest $request)
    {
        $inquiry = Inquiry::create([
            'type' => Inquiry::TYPE_GENERAL,
            'product_id' => null,
            'service_id' => null,
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'company' => $request->validated('company'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
            'status' => Inquiry::STATUS_NEW,
        ]);

        // Always send admin notification
        try {
            Mail::to(config('mail.from.address'))->send(new NewInquiryMail($inquiry));
            $inquiry->update(['notify_sent' => true, 'notify_error' => null]);
            Log::info('NewInquiryMail sent to admin for inquiry #' . $inquiry->id);
        } catch (\Throwable $e) {
            $inquiry->update(['notify_sent' => false, 'notify_error' => $e->getMessage()]);
            Log::error('Failed to send NewInquiryMail to admin for inquiry #' . $inquiry->id . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent successfully.');
    }

    public function product(ProductInquiryRequest $request, string $slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $inquiry = Inquiry::create([
            'type' => Inquiry::TYPE_PRODUCT,
            'product_id' => $product->id,
            'service_id' => null,
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'company' => $request->validated('company'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
            'status' => Inquiry::STATUS_NEW,
        ]);

        // Always send admin notification
        try {
            Mail::to(config('mail.from.address'))->send(new NewInquiryMail($inquiry));
            $inquiry->update(['notify_sent' => true, 'notify_error' => null]);
            Log::info('NewInquiryMail sent to admin for product inquiry #' . $inquiry->id);
        } catch (\Throwable $e) {
            $inquiry->update(['notify_sent' => false, 'notify_error' => $e->getMessage()]);
            Log::error('Failed to send NewInquiryMail to admin for product inquiry #' . $inquiry->id . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Your inquiry has been submitted successfully.');
    }
}
