@extends('admin.layout')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')
@section('page_subtitle', 'Update category information and catalog hierarchy')

@section('content')
@php
    $hasChildren = $category->children()->exists();
@endphp

<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="section-kicker">Category Details</div>
                    <h2 class="mt-2 text-xl font-black text-slate-950">Update information</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Edit category hierarchy, visibility, slug, and content shown on the website.
                    </p>
                </div>

                <div class="grid gap-5 p-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="text-sm font-black text-slate-800">Name</label>
                        <input class="field mt-2" name="name" value="{{ old('name', $category->name) }}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div>
                        <label class="text-sm font-black text-slate-800">Parent</label>
                        <select class="field mt-2" name="parent_id">
                            <option value="">Top level category</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-slate-500">You cannot set the category as its own parent.</p>
                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div>
                        <label class="text-sm font-black text-slate-800">Slug</label>
                        <input class="field mt-2" name="slug" value="{{ old('slug', $category->slug) }}">
                        <x-input-error :messages="$errors->get('slug')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-black text-slate-800">Description</label>
                       <textarea
    class="field mt-2"
    name="description"
    rows="5"
    data-lenis-prevent
>{{ old('description', $category->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div>
                        <label class="text-sm font-black text-slate-800">Sort order</label>
                        <input class="field mt-2" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                        <x-input-error :messages="$errors->get('sort_order')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <input
                            id="is_active"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="h-5 w-5 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]"
                            @checked(old('is_active', $category->is_active))
                        >
                        <label for="is_active" class="text-sm font-black text-slate-800">Active category</label>
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Back</a>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5" x-data="{ preview: null }">
            <div class="section-kicker">Category Image</div>
            <h3 class="mt-2 text-lg font-black text-slate-950">Visual preview</h3>

            <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                <template x-if="preview">
                    <img :src="preview" class="h-56 w-full object-cover" alt="Category preview">
                </template>

                <div x-show="!preview">
                    @if ($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" class="h-56 w-full object-cover" alt="Category image">
                    @else
                        <div class="flex h-56 flex-col items-center justify-center px-6 text-center text-sm text-slate-400">
                            <div class="text-3xl">＋</div>
                            <div class="mt-2 font-semibold">No image uploaded</div>
                        </div>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="mt-5">
                @csrf
                @method('PUT')

                <input type="hidden" name="name" value="{{ old('name', $category->name) }}">
                <input type="hidden" name="parent_id" value="{{ old('parent_id', $category->parent_id) }}">
                <input type="hidden" name="slug" value="{{ old('slug', $category->slug) }}">
                <input type="hidden" name="description" value="{{ old('description', $category->description) }}">
                <input type="hidden" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}">
                @if(old('is_active', $category->is_active))
                    <input type="hidden" name="is_active" value="1">
                @endif

                <input
                    class="field"
                    type="file"
                    name="image"
                    accept="image/*"
                    @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                >
                <x-input-error :messages="$errors->get('image')" class="mt-2 text-sm text-[#711726]" />

                <p class="mt-3 text-xs leading-relaxed text-slate-500">
                    Upload a clean category image. Wide industrial images work best.
                </p>

                <button class="btn btn-primary mt-5 w-full" type="submit">Update Image</button>
            </form>
        </div>

        <div class="rounded-[2rem] border border-[#711726]/15 bg-white p-6 shadow-xl shadow-slate-900/5">
            <div class="text-xs font-black uppercase tracking-[0.18em] text-[#711726]">Danger zone</div>

            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Deletion is blocked if the category has subcategories.
            </p>

            @if ($hasChildren)
                <div class="mt-5 rounded-2xl border border-[#711726]/15 bg-[#711726]/5 px-4 py-3 text-sm text-slate-700">
                    <span class="font-black text-[#711726]">Cannot delete:</span>
                    this category has subcategories.
                </div>

                <button class="mt-5 inline-flex w-full cursor-not-allowed items-center justify-center rounded-xl bg-[#711726]/10 px-5 py-3 text-sm font-black text-[#711726] opacity-50" type="button" disabled>
                    Delete Category
                </button>
            @else
                <form class="mt-5" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                    @csrf
                    @method('DELETE')

                    <button class="inline-flex w-full items-center justify-center rounded-xl bg-[#711726]/10 px-5 py-3 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white" type="submit">
                        Delete Category
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection