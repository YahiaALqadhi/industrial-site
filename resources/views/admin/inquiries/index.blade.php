@extends('admin.layout')

@section('title', 'Inquiries')
@section('page_title', 'Inquiries')
@section('page_subtitle', 'Track incoming requests, filter by status/type, and update progress')

@section('content')
@php
    $statusStyles = [
        'new' => ['bg' => 'rgba(113,23,38,.10)', 'color' => '#711726', 'label' => 'New'],
        'in_progress' => ['bg' => 'rgba(1,94,164,.10)', 'color' => '#015EA4', 'label' => 'In progress'],
        'replied' => ['bg' => 'rgba(34,197,94,.12)', 'color' => '#16a34a', 'label' => 'Replied'],
        'archived' => ['bg' => 'rgba(100,116,139,.12)', 'color' => '#64748b', 'label' => 'Archived'],
    ];
@endphp

<div class="space-y-6" x-data="inquiriesBulkActions()">
    <form method="GET" action="{{ route('admin.inquiries.index') }}"
          class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="section-kicker">Inquiry Filters</div>
                <h1 class="mt-3 text-2xl font-black text-slate-950">Inquiries management</h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                    Search customer requests, filter by type/status, open details, or bulk delete unnecessary messages.
                </p>
            </div>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-5">
                <label class="text-sm font-black text-slate-800">Search</label>
                <input class="field mt-2" name="q" value="{{ $search }}" placeholder="Search by name, email, or subject">
            </div>

            <div class="lg:col-span-3">
                <label class="text-sm font-black text-slate-800">Status</label>
                <select class="field mt-2" name="status">
                    <option value="">All statuses</option>
                    @foreach ($statusOptions as $opt)
                        <option value="{{ $opt }}" @selected((string) $status === (string) $opt)>
                            {{ $statusStyles[$opt]['label'] ?? $opt }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2">
                <label class="text-sm font-black text-slate-800">Type</label>
                <select class="field mt-2" name="type">
                    <option value="">All types</option>
                    @foreach ($typeOptions as $opt)
                        <option value="{{ $opt }}" @selected((string) $type === (string) $opt)>
                            {{ $opt }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 lg:col-span-2">
                <button class="btn btn-primary w-full" type="submit">Apply</button>
                <a class="btn btn-outline w-full" href="{{ route('admin.inquiries.index') }}">Reset</a>
            </div>
        </div>
    </form>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.inquiries.bulkDelete') }}" onsubmit="return confirm('Are you sure you want to delete the selected inquiries?');">
        @csrf
        @method('DELETE')
    </form>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="text-lg font-black text-slate-950">Inquiry list</div>
                <div class="mt-1 text-sm text-slate-500">
                    Select inquiries, open details, or remove unnecessary messages.
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-black text-slate-700">
                    <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]" x-model="selectAll" @change="toggleAll()">
                    <span>Select all</span>
                </label>

                <button
                    type="submit"
                    form="bulk-delete-form"
                    class="inline-flex items-center justify-center rounded-xl bg-[#711726] px-4 py-2.5 text-sm font-black text-white transition hover:bg-[#5f121f] disabled:cursor-not-allowed disabled:opacity-40"
                    :disabled="selectedCount === 0"
                >
                    Delete selected
                    <span x-show="selectedCount > 0" class="ml-1" x-text="'(' + selectedCount + ')'"></span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="w-12 px-6 py-4 text-left">
                            <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]" x-model="selectAll" @change="toggleAll()">
                        </th>
                        <th class="px-6 py-4 text-left font-black">From</th>
                        <th class="px-6 py-4 text-left font-black">Type</th>
                        <th class="px-6 py-4 text-left font-black">Subject</th>
                        <th class="px-6 py-4 text-left font-black">Status</th>
                        <th class="px-6 py-4 text-left font-black">Received</th>
                        <th class="px-6 py-4 text-right font-black">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($inquiries as $inquiry)
                        @php
                            $st = $statusStyles[$inquiry->status] ?? [
                                'bg' => 'rgba(100,116,139,.12)',
                                'color' => '#64748b',
                                'label' => $inquiry->status,
                            ];
                        @endphp

                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4">
                                <input
                                    type="checkbox"
                                    name="selected_inquiries[]"
                                    value="{{ $inquiry->id }}"
                                    form="bulk-delete-form"
                                    class="row-checkbox h-4 w-4 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]"
                                    x-model="selected"
                                    @change="syncSelectAll()"
                                >
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-black text-slate-950">{{ $inquiry->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $inquiry->email }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-700">
                                    {{ $inquiry->type }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-700">
                                <div class="max-w-md truncate font-medium">
                                    {{ $inquiry->subject ?: '—' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span
    class="inline-flex rounded-full px-3 py-1 text-xs font-black"
    @style([
        "background: {$st['bg']}",
        "color: {$st['color']}",
    ])
>
    {{ $st['label'] }}
</span>
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-600">
                                {{ optional($inquiry->created_at)->timezone('Asia/Aden')->format('Y-m-d H:i') }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                       class="inline-flex rounded-xl bg-[#015ea4]/10 px-4 py-2 text-sm font-black text-[#015ea4] transition hover:bg-[#015ea4] hover:text-white">
                                        Open
                                    </a>

                                    <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Are you sure you want to delete this inquiry?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="inline-flex rounded-xl bg-[#711726]/10 px-4 py-2 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="text-lg font-black text-slate-950">No inquiries found</div>
                                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                        Try changing the filters, or wait for new messages from the website forms.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $inquiries->links() }}
        </div>
    </div>
</div>

<script>
    function inquiriesBulkActions() {
        return {
            selected: [],
            selectAll: false,

            get selectedCount() {
                return this.selected.length;
            },

            toggleAll() {
                const checkboxes = [...document.querySelectorAll('.row-checkbox')];

                this.selected = this.selectAll
                    ? checkboxes.map((checkbox) => checkbox.value)
                    : [];
            },

            syncSelectAll() {
                const checkboxes = [...document.querySelectorAll('.row-checkbox')];
                this.selectAll = checkboxes.length > 0 && this.selected.length === checkboxes.length;
            },
        };
    }
</script>
@endsection