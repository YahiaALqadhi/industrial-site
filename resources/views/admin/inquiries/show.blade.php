@extends('admin.layout')

@section('title', 'Inquiry')
@section('page_title', 'Inquiry Details')
@section('page_subtitle', 'Review message content, update status, and reply to customer')

@section('content')
@php
    $statusStyles = [
        'new' => ['bg' => 'rgba(113,23,38,.10)', 'color' => '#711726', 'label' => 'New'],
        'in_progress' => ['bg' => 'rgba(1,94,164,.10)', 'color' => '#015EA4', 'label' => 'In progress'],
        'replied' => ['bg' => 'rgba(34,197,94,.12)', 'color' => '#16a34a', 'label' => 'Replied'],
        'archived' => ['bg' => 'rgba(100,116,139,.12)', 'color' => '#64748b', 'label' => 'Archived'],
    ];

    $currentStatus = $statusStyles[$inquiry->status] ?? [
        'bg' => 'rgba(100,116,139,.12)',
        'color' => '#64748b',
        'label' => $inquiry->status,
    ];
@endphp

<div class="grid gap-6 lg:grid-cols-12">
    <div class="space-y-6 lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="section-kicker">Message</div>
                        <h2 class="mt-2 text-2xl font-black text-slate-950">
                            {{ $inquiry->subject ?: 'No subject' }}
                        </h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Received {{ optional($inquiry->created_at)->timezone('Asia/Aden')->format('Y-m-d H:i') }}
                        </p>
                    </div>

                    <span
                        class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-black"
                        @style([
                            "background: {$currentStatus['bg']}",
                            "color: {$currentStatus['color']}",
                        ])
                    >
                        {{ $currentStatus['label'] }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="text-xs font-black uppercase tracking-wider text-slate-500">Customer</div>
                        <div class="mt-2 font-black text-slate-950">{{ $inquiry->name }}</div>

                        <a href="mailto:{{ $inquiry->email }}" class="mt-1 block text-sm font-bold text-[#015ea4]">
                            {{ $inquiry->email }}
                        </a>

                        @if ($inquiry->phone)
                            <a href="tel:{{ preg_replace('/\s+/', '', $inquiry->phone) }}" class="mt-1 block text-sm text-slate-600">
                                {{ $inquiry->phone }}
                            </a>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="text-xs font-black uppercase tracking-wider text-slate-500">Inquiry info</div>

                        <div class="mt-2 text-sm text-slate-600">
                            <span class="font-black text-slate-900">Company:</span>
                            {{ $inquiry->company ?: '—' }}
                        </div>

                        <div class="mt-2 text-sm text-slate-600">
                            <span class="font-black text-slate-900">Type:</span>
                            {{ $inquiry->type }}
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="text-xs font-black uppercase tracking-wider text-slate-500">Message content</div>
                    <div class="mt-3 whitespace-pre-line rounded-2xl border border-slate-200 bg-white p-5 text-sm leading-relaxed text-slate-700">
                        {{ $inquiry->message }}
                    </div>
                </div>

                @if ($inquiry->product || $inquiry->service)
                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        @if ($inquiry->product)
                            <div class="rounded-2xl border border-[#015ea4]/15 bg-[#015ea4]/5 p-5">
                                <div class="text-xs font-black uppercase tracking-wider text-[#015ea4]">Product context</div>
                                <div class="mt-2 font-black text-slate-950">{{ $inquiry->product->name }}</div>
                                <code class="mt-2 inline-flex rounded-lg bg-white px-2 py-1 text-xs font-bold text-slate-600">
                                    {{ $inquiry->product->slug }}
                                </code>
                            </div>
                        @endif

                        @if ($inquiry->service)
                            <div class="rounded-2xl border border-[#015ea4]/15 bg-[#015ea4]/5 p-5">
                                <div class="text-xs font-black uppercase tracking-wider text-[#015ea4]">Service context</div>
                                <div class="mt-2 font-black text-slate-950">{{ $inquiry->service->title }}</div>
                                <code class="mt-2 inline-flex rounded-lg bg-white px-2 py-1 text-xs font-bold text-slate-600">
                                    {{ $inquiry->service->slug }}
                                </code>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @can('reply', $inquiry)
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="section-kicker">Reply</div>
                    <h2 class="mt-2 text-xl font-black text-slate-950">
                        Reply to customer
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Saving a reply can update the inquiry status to replied and optionally send an email.
                    </p>
                </div>

                <div class="p-6">
                    @if ($inquiry->reply_message)
                        <div class="mb-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <div class="text-xs font-black uppercase tracking-wider text-[#711726]">Last reply</div>
                            <div class="mt-2 font-black text-slate-950">
                                {{ $inquiry->reply_subject ?: 'Re: Your inquiry' }}
                            </div>
                            <div class="mt-3 whitespace-pre-line text-sm leading-relaxed text-slate-700">
                                {{ $inquiry->reply_message }}
                            </div>

                            <div class="mt-4 text-xs text-slate-500">
                                Replied at: {{ optional($inquiry->replied_at)->format('Y-m-d H:i') ?? '—' }}
                                @if ($inquiry->repliedBy)
                                    <span class="mx-1">•</span>
                                    By: {{ $inquiry->repliedBy->name }}
                                @endif
                            </div>
                        </div>
                    @endif

                    <form class="grid gap-4" method="POST" action="{{ route('admin.inquiries.reply', $inquiry) }}" x-data="{ loading: false }" @submit="loading = true">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="text-sm font-black text-slate-800">Subject</label>
                            <input
                                class="field mt-2"
                                name="reply_subject"
                                value="{{ old('reply_subject', $inquiry->reply_subject ?: ('Re: '.($inquiry->subject ?: $inquiry->type.' inquiry'))) }}"
                                placeholder="Re: Your inquiry"
                            >
                            <x-input-error :messages="$errors->get('reply_subject')" class="mt-2 text-sm text-[#711726]" />
                        </div>

                        <div>
                            <label class="text-sm font-black text-slate-800">Reply message</label>
                            <textarea
    class="field mt-2"
    name="reply_message"
    rows="7"
    dir="auto"
    required
>{{ old('reply_message') }}</textarea>
                            <x-input-error :messages="$errors->get('reply_message')" class="mt-2 text-sm text-[#711726]" />
                        </div>

                        <label class="inline-flex items-center gap-3 text-sm font-black text-slate-700">
                            <input type="checkbox" name="send_email" value="1" class="h-5 w-5 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]" @checked(old('send_email', true))>
                            <span>Send email to customer</span>
                        </label>

                        <div>
                            <button class="btn btn-primary" type="submit" :disabled="loading">
                                <span x-show="!loading">Save reply</span>
                                <span x-show="loading" style="display:none">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endcan
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Update Status</div>

                <form class="mt-5 grid gap-4" method="POST" action="{{ route('admin.inquiries.updateStatus', $inquiry) }}">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-sm font-black text-slate-800">Status</label>
                        <select class="field mt-2" name="status" required>
                            @foreach ([\App\Models\Inquiry::STATUS_NEW, \App\Models\Inquiry::STATUS_IN_PROGRESS, \App\Models\Inquiry::STATUS_REPLIED, \App\Models\Inquiry::STATUS_ARCHIVED] as $st)
                                <option value="{{ $st }}" @selected(old('status', $inquiry->status) === $st)>
                                    {{ $statusStyles[$st]['label'] ?? $st }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <button class="btn btn-primary w-full" type="submit">
                        Save status
                    </button>
                </form>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Quick Actions</div>

                <div class="mt-5 grid gap-3">
                    <a href="mailto:{{ $inquiry->email }}" class="admin-quick-action">
                        Email customer <span>→</span>
                    </a>

                    @if ($inquiry->phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $inquiry->phone) }}" class="admin-quick-action">
                            Call customer <span>→</span>
                        </a>
                    @endif

                    <a href="{{ route('admin.inquiries.index') }}" class="admin-quick-action">
                        Back to list <span>→</span>
                    </a>
                </div>
            </div>

            @can('delete', $inquiry)
                <div class="rounded-[2rem] border border-[#711726]/15 bg-white p-6 shadow-xl shadow-slate-900/5">
                    <div class="text-xs font-black uppercase tracking-wider text-[#711726]">Danger zone</div>
                    <p class="mt-3 text-sm text-slate-600">
                        Delete this inquiry permanently from the system.
                    </p>

                    <form class="mt-5" method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Delete this inquiry?');">
                        @csrf
                        @method('DELETE')

                        <button class="inline-flex w-full items-center justify-center rounded-xl bg-[#711726]/10 px-5 py-3 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white" type="submit">
                            Delete inquiry
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </div>
</div>
@endsection