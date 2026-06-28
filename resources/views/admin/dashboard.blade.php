@extends('admin.layout')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of catalog activity and incoming inquiries')

@section('content')
@php
    $cards = [
        ['label' => 'Categories', 'value' => $totalCategories, 'desc' => 'Catalog groups and nested structure.', 'route' => route('admin.categories.index')],
        ['label' => 'Products', 'value' => $totalProducts, 'desc' => 'Active product records and media.', 'route' => route('admin.products.index')],
        ['label' => 'Services', 'value' => $totalServices, 'desc' => 'Service offerings and workflows.', 'route' => route('admin.services.index')],
        ['label' => 'Inquiries', 'value' => $totalInquiries, 'desc' => 'All customer messages and requests.', 'route' => route('admin.inquiries.index')],
        ['label' => 'New', 'value' => $newInquiriesCount, 'desc' => 'Awaiting initial review.', 'route' => route('admin.inquiries.index'), 'danger' => true],
    ];
@endphp

<div class="space-y-6">
    <div class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="section-kicker">Admin Overview</div>
                <h1 class="mt-3 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                    Website control center
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                    Monitor catalog content, manage customer inquiries, and keep products, services, and settings up to date.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline">View Inquiries</a>
            </div>
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ($cards as $card)
            <a href="{{ $card['route'] }}"
               class="group rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-lg shadow-slate-900/5 transition-all duration-300 hover:-translate-y-2 hover:border-[#015ea4]/30 hover:shadow-2xl hover:shadow-[#015ea4]/10">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-xs font-black uppercase tracking-wider text-slate-500">
                            {{ $card['label'] }}
                        </div>

                        <div class="mt-3 text-4xl font-black {{ ($card['danger'] ?? false) ? 'text-[#711726]' : 'text-[#015ea4]' }}">
                            {{ number_format($card['value']) }}
                        </div>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#015ea4]/10 text-[#015ea4] transition group-hover:scale-110">
                        →
                    </div>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-slate-600">
                    {{ $card['desc'] }}
                </p>
            </a>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-12">
        <div class="xl:col-span-8">
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
                <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="text-lg font-black text-slate-950">Recent inquiries</div>
                        <div class="mt-1 text-sm text-slate-500">Latest messages received from website forms.</div>
                    </div>

                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-primary">View all</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left font-black">Customer</th>
                                <th class="px-6 py-4 text-left font-black">Type</th>
                                <th class="px-6 py-4 text-left font-black">Status</th>
                                <th class="px-6 py-4 text-left font-black">Received</th>
                                <th class="px-6 py-4 text-right font-black">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentInquiries as $inquiry)
                                @php
                                    $statusStyles = [
                                        'new' => ['bg' => 'rgba(113,23,38,.10)', 'color' => '#711726', 'label' => 'New'],
                                        'in_progress' => ['bg' => 'rgba(1,94,164,.10)', 'color' => '#015EA4', 'label' => 'In progress'],
                                        'replied' => ['bg' => 'rgba(34,197,94,.12)', 'color' => '#16a34a', 'label' => 'Replied'],
                                        'archived' => ['bg' => 'rgba(100,116,139,.12)', 'color' => '#64748b', 'label' => 'Archived'],
                                    ];

                                    $st = $statusStyles[$inquiry->status] ?? [
                                        'bg' => 'rgba(100,116,139,.12)',
                                        'color' => '#64748b',
                                        'label' => $inquiry->status,
                                    ];
                                @endphp

                                <tr class="transition hover:bg-slate-50/80">
                                    <td class="px-6 py-4">
                                        <div class="font-black text-slate-950">{{ $inquiry->name }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $inquiry->email }}</div>
                                    </td>

                                    <td class="px-6 py-4 font-medium text-slate-700">{{ $inquiry->type }}</td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
    @style([
        "background: {$st['bg']}",
        "color: {$st['color']}",
    ])
>
    {{ $st['label'] }}
</span>
                                    </td>

                                    <td class="px-6 py-4 text-slate-600">
                                        {{ optional($inquiry->created_at)->timezone('Asia/Aden')->format('Y-m-d H:i') }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                           class="inline-flex rounded-xl px-4 py-2 text-sm font-black text-[#015ea4] transition hover:bg-[#015ea4]/10">
                                            Open
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-14 text-center">
                                        <div class="mx-auto max-w-sm">
                                            <div class="text-lg font-black text-slate-950">No inquiries yet</div>
                                            <p class="mt-2 text-sm text-slate-500">
                                                New customer messages will appear here once visitors submit inquiry forms.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="xl:col-span-4">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Quick actions</div>

                <div class="mt-5 grid gap-3">
                    <a href="{{ route('admin.categories.create') }}" class="admin-quick-action">Add Category <span>→</span></a>
                    <a href="{{ route('admin.products.create') }}" class="admin-quick-action">Add Product <span>→</span></a>
                    <a href="{{ route('admin.services.create') }}" class="admin-quick-action">Add Service <span>→</span></a>
                    <a href="{{ route('admin.settings.edit') }}" class="admin-quick-action">Website Settings <span>→</span></a>
                </div>
            </div>

            <div class="mt-6 rounded-[2rem] border border-[#711726]/15 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="text-xs font-black uppercase tracking-[0.18em] text-[#711726]">Priority</div>

                <div class="mt-4">
                    <div class="text-4xl font-black text-[#711726]">
                        {{ number_format($newInquiriesCount) }}
                    </div>

                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        New inquiries are waiting for initial review.
                    </p>

                    <a href="{{ route('admin.inquiries.index') }}" class="mt-5 inline-flex text-sm font-black text-[#015ea4]">
                        Review now →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection