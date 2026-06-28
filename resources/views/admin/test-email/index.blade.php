@extends('admin.layout')

@section('title', 'Test Email')
@section('page_title', 'Email Configuration Test')
@section('page_subtitle', 'Verify Gmail SMTP settings and send test emails')

@section('content')
<div class="grid gap-6 lg:grid-cols-12">
    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5 lg:col-span-8">
        <div class="border-b border-slate-200 px-6 py-5">
            <div class="section-kicker">Mail Configuration</div>
            <h2 class="mt-2 text-xl font-black text-slate-950">Current SMTP settings</h2>
            <p class="mt-1 text-sm text-slate-500">
                Values are loaded from .env. Password is hidden for security.
            </p>
        </div>

        <div class="grid gap-4 p-6 md:grid-cols-2">
            @foreach ([
                'Default Mailer' => $mailConfig['default'],
                'Host' => $mailConfig['host'],
                'Port' => $mailConfig['port'],
                'Encryption' => $mailConfig['encryption'],
                'Username' => $mailConfig['username'],
                'From Address' => $mailConfig['from_address'],
                'From Name' => $mailConfig['from_name'],
            ] as $label => $value)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase tracking-wider text-slate-400">{{ $label }}</div>
                    <div class="mt-2 break-all font-mono text-sm font-bold text-slate-900">{{ $value ?: '—' }}</div>
                </div>
            @endforeach
        </div>

        <div class="px-6 pb-6">
            @if ($mailConfig['encryption'] !== 'tls' || $mailConfig['port'] != '587')
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
                    <div class="text-sm font-black text-red-600">Configuration issue</div>
                    <div class="mt-1 text-sm text-red-700">
                        For Gmail SMTP with port 587, encryption should be <b>tls</b>.
                        Current: {{ $mailConfig['encryption'] }} on port {{ $mailConfig['port'] }}.
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                    <div class="text-sm font-black text-emerald-600">Configuration OK</div>
                    <div class="mt-1 text-sm text-emerald-700">
                        Gmail SMTP settings are configured for port 587 with TLS encryption.
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Send Test</div>
                <h3 class="mt-2 text-lg font-black text-slate-950">Test delivery</h3>

                <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase tracking-wider text-slate-400">Recipient</div>
                    <div class="mt-2 break-all font-mono text-sm font-bold text-slate-900">
                        {{ $mailConfig['from_address'] }}
                    </div>
                </div>

                <form class="mt-5" method="POST" action="{{ route('admin.test-email.send') }}" onsubmit="return confirm('Send test email?');">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full">
                        Send Test Email
                    </button>
                </form>
            </div>

            <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline w-full">
                Back to Settings
            </a>
        </div>
    </div>
</div>
@endsection