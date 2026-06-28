@extends('admin.layout')

@section('title', 'Categories')
@section('page_title', 'Categories')
@section('page_subtitle', 'Manage your catalog tree, ordering, and visibility')

@section('content')
<div class="space-y-6">
    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="section-kicker">Catalog Structure</div>
                <h1 class="mt-3 text-2xl font-black text-slate-950">Categories management</h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                    Create and maintain top-level categories, subcategories, ordering, and visibility across the website catalog.
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <span>+</span>
                <span>New Category</span>
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
        <div class="border-b border-slate-200 px-6 py-5">
            <div class="text-lg font-black text-slate-950">All categories</div>
            <div class="mt-1 text-sm text-slate-500">Review names, parents, slugs, sorting order, and publication status.</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-black">Name</th>
                        <th class="px-6 py-4 text-left font-black">Parent</th>
                        <th class="px-6 py-4 text-left font-black">Slug</th>
                        <th class="px-6 py-4 text-left font-black">Order</th>
                        <th class="px-6 py-4 text-left font-black">Status</th>
                        <th class="px-6 py-4 text-right font-black">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-950">{{ $category->name }}</div>

                                @if ($category->description)
                                    <div class="mt-1 max-w-md truncate text-xs text-slate-500">
                                        {{ $category->description }}
                                    </div>
                                @else
                                    <div class="mt-1 text-xs text-slate-400">No description</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($category->parent)
                                    <span class="inline-flex rounded-full bg-[#015ea4]/10 px-3 py-1 text-xs font-black text-[#015ea4]">
                                        {{ $category->parent->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400">Top level</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <code class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700">
                                    {{ $category->slug }}
                                </code>
                            </td>

                            <td class="px-6 py-4 font-bold text-slate-700">
                                {{ $category->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($category->is_active)
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
                                    <a
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        class="inline-flex items-center justify-center rounded-xl bg-[#015ea4]/10 px-4 py-2 text-sm font-black text-[#015ea4] transition hover:bg-[#015ea4] hover:text-white"
                                    >
                                        Edit
                                    </a>

                                    @if ($category->children()->exists())
                                        <span
                                            class="inline-flex items-center justify-center rounded-xl bg-[#711726]/10 px-4 py-2 text-sm font-black text-[#711726]/70"
                                            title="Cannot delete: category has subcategories"
                                        >
                                            Locked
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="inline-flex items-center justify-center rounded-xl bg-[#711726]/10 px-4 py-2 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white"
                                                type="submit"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="text-lg font-black text-slate-950">No categories found</div>
                                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                        Start by creating your first catalog category.
                                    </p>

                                    <a href="{{ route('admin.categories.create') }}" class="mt-5 inline-flex btn btn-primary">
                                        New Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection