<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InquiryReplyRequest;
use App\Http\Requests\Admin\InquiryStatusUpdateRequest;
use App\Mail\InquiryReplyMail;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminInquiryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Inquiry::class);

        $query = Inquiry::query()->latest();

        $status = $request->query('status');
        if (!empty($status)) {
            $query->where('status', $status);
        }

        $type = $request->query('type');
        if (!empty($type)) {
            $query->where('type', $type);
        }

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->paginate(20)->appends(request()->query());

        $statusOptions = [
            Inquiry::STATUS_NEW,
            Inquiry::STATUS_IN_PROGRESS,
            Inquiry::STATUS_REPLIED,
            Inquiry::STATUS_ARCHIVED,
        ];

        $typeOptions = [
            Inquiry::TYPE_GENERAL,
            Inquiry::TYPE_PRODUCT,
            Inquiry::TYPE_SERVICE,
        ];

        return view('admin.inquiries.index', compact('inquiries', 'status', 'type', 'search', 'statusOptions', 'typeOptions'));
    }
    

    public function show(Inquiry $inquiry)
    {
        $this->authorize('view', $inquiry);

        $inquiry->load(['product', 'service']);

        return view('admin.inquiries.show', compact('inquiry'));
    }

    
    public function updateStatus(InquiryStatusUpdateRequest $request, Inquiry $inquiry)
    {
        $data = $request->validated();

        $inquiry->update([
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.inquiries.show', $inquiry)->with('success', 'Inquiry status updated.');
    }

public function reply(InquiryReplyRequest $request, Inquiry $inquiry)
{
    $data = $request->validated();

    $sendEmail = (bool) ($data['send_email'] ?? false);

    $updateData = [
        'reply_subject' => $data['reply_subject'] ?? null,
        'reply_message' => $data['reply_message'],
        'reply_channel' => $sendEmail ? 'email' : 'internal',
        'replied_at' => now(),
        'replied_by' => $request->user()->id,
        'status' => Inquiry::STATUS_REPLIED,
        'reply_sent' => false,
        'reply_error' => null,
    ];

    // احفظ الرد أولًا
    $inquiry->update($updateData);

    // حدّث الكائن حتى يحمل القيم الجديدة
    $inquiry->refresh();

    if ($sendEmail) {
        try {
            // إرسال الرد إلى الزائر
            Mail::to($inquiry->email)->send(new InquiryReplyMail($inquiry));

            $inquiry->update([
                'reply_sent' => true,
                'reply_error' => null,
            ]);

            Log::info('InquiryReplyMail sent to visitor and admin copy for inquiry #' . $inquiry->id);
        } catch (\Throwable $e) {
            $inquiry->update([
                'reply_sent' => false,
                'reply_error' => $e->getMessage(),
            ]);

            Log::error('Failed to send InquiryReplyMail for inquiry #' . $inquiry->id . ': ' . $e->getMessage());

            return redirect()
                ->route('admin.inquiries.show', $inquiry)
                ->with('error', 'Reply saved, but email could not be sent.');
        }
    }

    return redirect()
        ->route('admin.inquiries.show', $inquiry)
        ->with('success', $sendEmail ? 'Reply saved and email sent successfully.' : 'Reply saved successfully.');
}

public function bulkDelete(Request $request)
{
    $ids = $request->input('selected_inquiries', []);

    if (empty($ids)) {
        return redirect()
            ->route('admin.inquiries.index')
            ->with('error', 'Please select at least one inquiry.');
    }

    Inquiry::whereIn('id', $ids)->delete();

    return redirect()
        ->route('admin.inquiries.index')
        ->with('success', 'Selected inquiries deleted successfully.');
}

    public function destroy(Inquiry $inquiry)
    {
        $this->authorize('delete', $inquiry);

        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}

