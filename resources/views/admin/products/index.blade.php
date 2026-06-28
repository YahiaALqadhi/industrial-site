@extends('admin.layout')

@section('title', 'Products')
@section('page_title', 'Products')
@section('page_subtitle', 'Manage products, media, brochures, and technical features')

@section('content')
<div class="space-y-6">
    <form method="GET" action="{{ route('admin.products.index') }}"
          class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="section-kicker">Product Filters</div>
                <h1 class="mt-3 text-2xl font-black text-slate-950">Products management</h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                    Search, filter, update, and manage product records, cover images, brochures, and technical details.
                </p>
            </div>

            <a href="{{ route('admin.products.create') }}" class="btn btn-primary whitespace-nowrap">
                <span>+</span>
                <span>New Product</span>
            </a>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-12 md:items-end">
            <div class="md:col-span-6">
                <label class="text-sm font-black text-slate-800">Search</label>
                <input class="field mt-2" name="q" value="{{ $search }}" placeholder="Search product name or slug">
            </div>

            <div class="md:col-span-4">
                <label class="text-sm font-black text-slate-800">Category</label>
                <select class="field mt-2" name="category_id">
                    <option value="">All categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected((string)$categoryId === (string)$cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-2">
                <button class="btn btn-primary w-full" type="submit">Apply</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline w-full">Reset</a>
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-lg font-black text-slate-950">All products</div>
                <div class="mt-1 text-sm text-slate-500">
                    Total: <span class="font-black text-slate-900">{{ $products->total() }}</span> products
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-black">Product</th>
                        <th class="px-6 py-4 text-left font-black">Category</th>
                        <th class="px-6 py-4 text-left font-black">Status</th>
                        <th class="px-6 py-4 text-left font-black">Updated</th>
                        <th class="px-6 py-4 text-right font-black">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-16 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                                        @if ($product->cover_image)
                                            <img src="{{ asset('storage/'.$product->cover_image) }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                                        @else
                                            <div class="flex h-full items-center justify-center px-2 text-center text-[11px] font-bold text-slate-400">
                                                No image
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="max-w-xs truncate font-black text-slate-950">
                                            {{ $product->name }}
                                        </div>
                                        <code class="mt-1 inline-flex max-w-xs truncate rounded-lg bg-slate-100 px-2 py-1 text-[11px] font-bold text-slate-600">
                                            {{ $product->slug }}
                                        </code>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if($product->category)
                                    <span class="inline-flex rounded-full bg-[#015ea4]/10 px-3 py-1 text-xs font-black text-[#015ea4]">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($product->is_active)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-500">
                                        Disabled
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-600">
                                {{ optional($product->updated_at)->format('Y-m-d') }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="inline-flex items-center justify-center rounded-xl bg-[#015ea4]/10 px-4 py-2 text-sm font-black text-[#015ea4] transition hover:bg-[#015ea4] hover:text-white">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
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
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="text-lg font-black text-slate-950">No products found</div>
                                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                        Add your first product or adjust the current filters.
                                    </p>

                                    <a href="{{ route('admin.products.create') }}" class="mt-5 inline-flex btn btn-primary">
                                        New Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection