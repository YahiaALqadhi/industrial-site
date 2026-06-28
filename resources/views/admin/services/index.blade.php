@extends('admin.layout')

@section('title', 'Services')
@section('page_title', 'Services')
@section('page_subtitle', 'Manage service pages, sorting, and visibility')

@section('content')
<div class="space-y-6">
    <form method="GET" action="{{ route('admin.services.index') }}"
          class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="section-kicker">Service Filters</div>
                <h1 class="mt-3 text-2xl font-black text-slate-950">Services management</h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                    Manage service cards displayed on the public services page, including images, ordering, and visibility.
                </p>
            </div>

            <a href="{{ route('admin.services.create') }}" class="btn btn-primary whitespace-nowrap">
                <span>+</span>
                <span>New Service</span>
            </a>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-12 md:items-end">
            <div class="md:col-span-6">
                <label class="text-sm font-black text-slate-800">Search</label>
                <input class="field mt-2" name="q" value="{{ $search }}" placeholder="Search title or slug">
            </div>

            <div class="md:col-span-3">
                <label class="text-sm font-black text-slate-800">Status</label>
                <select class="field mt-2" name="is_active">
                    <option value="">All statuses</option>
                    <option value="1" @selected((string) $isActive === '1')>Active</option>
                    <option value="0" @selected((string) $isActive === '0')>Disabled</option>
                </select>
            </div>

            <div class="flex gap-2 md:col-span-3">
                <button class="btn btn-primary w-full" type="submit">Apply</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline w-full">Reset</a>
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
        <div class="border-b border-slate-200 px-6 py-5">
            <div class="text-lg font-black text-slate-950">Services list</div>
            <div class="mt-1 text-sm text-slate-500">Control title, image, ordering, and visibility.</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-black">Service</th>
                        <th class="px-6 py-4 text-left font-black">Sort</th>
                        <th class="px-6 py-4 text-left font-black">Status</th>
                        <th class="px-6 py-4 text-right font-black">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($services as $service)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-20 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                                        @if ($service->image)
                                            <img src="{{ asset('storage/'.$service->image) }}" class="h-full w-full object-cover" alt="{{ $service->title }}">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center px-2 text-center text-[10px] font-bold text-slate-400">
                                                No image
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="max-w-md truncate font-black text-slate-950">{{ $service->title }}</div>

                                        <code class="mt-1 inline-flex max-w-md truncate rounded-lg bg-slate-100 px-2 py-1 text-[11px] font-bold text-slate-600">
                                            /{{ $service->slug }}
                                        </code>

                                        @if(!empty($service->short_desc))
                                            <div class="mt-1 max-w-md truncate text-xs text-slate-500">
                                                {{ $service->short_desc }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 font-black text-slate-700">
                                {{ $service->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($service->is_active)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-500">
                                        Disabled
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="inline-flex items-center justify-center rounded-xl bg-[#015ea4]/10 px-4 py-2 text-sm font-black text-[#015ea4] transition hover:bg-[#015ea4] hover:text-white">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="inline-flex items-center justify-center rounded-xl bg-[#711726]/10 px-4 py-2 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="text-lg font-black text-slate-950">No services found</div>
                                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                        Create your first service to show it on the website.
                                    </p>

                                    <a href="{{ route('admin.services.create') }}" class="mt-5 inline-flex btn btn-primary">
                                        New Service
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection