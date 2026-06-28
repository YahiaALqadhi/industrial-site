@extends('admin.layout')

@section('title', 'System Health')
@section('page_title', 'System Health Check')
@section('page_subtitle', 'Monitor database, storage, mail, and cache status')

@section('content')

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-5 rounded-2xl px-4 py-3 text-sm"
             style="background:rgba(34,197,94,.10); color:#16a34a;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-2xl px-4 py-3 text-sm"
             style="background:rgba(239,68,68,.10); color:#dc2626;">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-6">

        @foreach($health as $component => $status)

            @php
                $isOk = $status['status'] === 'ok';
                $isWarning = $status['status'] === 'warning';

                $bg = $isOk
                    ? 'rgba(34,197,94,.10)'
                    : ($isWarning ? 'rgba(245,158,11,.10)' : 'rgba(239,68,68,.10)');

                $color = $isOk
                    ? '#16a34a'
                    : ($isWarning ? '#d97706' : '#dc2626');
            @endphp

            <div class="rounded-2xl border bg-white shadow-sm"
                 style="border-color: rgba(0,0,0,0.08)">

                {{-- HEADER --}}
                <div class="p-5 border-b flex items-center justify-between"
                     style="border-color: rgba(0,0,0,0.08)">

                    <div class="font-semibold text-slate-900">
                        {{ ucfirst($component) }}
                    </div>

                    <div
    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold"
    @style([
        "background: {$bg}",
        "color: {$color}",
    ])
>
                        {{ strtoupper($status['status']) }}
                    </div>
                </div>

                {{-- MESSAGE --}}
                <div class="px-5 pt-3 pb-4 text-sm text-slate-600">
                    {{ $status['message'] }}
                </div>

                {{-- DETAILS --}}
                @if(!empty($status['details']))
                    <div class="px-5 pb-5">
                        <div class="rounded-xl bg-slate-50 p-4 text-xs font-mono text-slate-700 space-y-1">

                            @foreach($status['details'] as $key => $value)
                                <div>
                                    <span class="font-semibold text-slate-900">{{ $key }}:</span>
                                    {{ is_bool($value) ? ($value ? 'true' : 'false') : $value }}
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif

            </div>

        @endforeach

    </div>

    {{-- ACTIONS --}}
    <div class="mt-8 flex flex-wrap gap-4">

        <form method="POST" action="{{ route('admin.system-health.test-mail') }}">
            @csrf
            <button
                class="btn btn-primary"
                type="submit"
                onclick="return confirm('Send test email?');"
            >
                Test Mail
            </button>
        </form>

        <form method="POST" action="{{ route('admin.system-health.clear-cache') }}">
            @csrf
            <button
                class="btn btn-outline"
                type="submit"
                onclick="return confirm('Clear all caches?');"
            >
                Clear Cache
            </button>
        </form>

    </div>

@endsection