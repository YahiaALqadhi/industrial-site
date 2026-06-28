@extends('admin.layout')

@section('title', 'New Category')
@section('page_title', 'New Category')
@section('page_subtitle', 'Create a new category node in the catalog tree')

@section('content')
<form
    method="POST"
    action="{{ route('admin.categories.store') }}"
    enctype="multipart/form-data"
    class="grid gap-6 lg:grid-cols-12"
>
    @csrf

    <div class="lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Category Details</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Basic information</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Define the category name, hierarchy, slug, and display order.
                </p>
            </div>

            <div class="grid gap-5 p-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Name</label>
                    <input class="field mt-2" name="name" value="{{ old('name') }}" required placeholder="Example: Industrial Automation">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Parent</label>
                    <select class="field mt-2" name="parent_id">
                        <option value="">Top level category</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('parent_id')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Slug</label>
                    <input class="field mt-2" name="slug" value="{{ old('slug') }}" placeholder="auto-generated from name">
                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Description</label>
                    <textarea
    class="field mt-2"
    name="description"
    rows="5"
    placeholder="Short description shown on category cards and detail pages."
    data-lenis-prevent
>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Sort order</label>
                    <input class="field mt-2" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    <x-input-error :messages="$errors->get('sort_order')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                    <input
                        id="is_active"
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="h-5 w-5 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]"
                        @checked(old('is_active', true))
                    >
                    <label for="is_active" class="text-sm font-black text-slate-800">
                        Active category
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-4">
        <div class="sticky top-24 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5" x-data="{ preview: null }">
            <div class="section-kicker">Category Image</div>
            <h3 class="mt-2 text-lg font-black text-slate-950">Visual preview</h3>

            <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                <template x-if="preview">
                    <img :src="preview" class="h-56 w-full object-cover" alt="Category preview">
                </template>

                <div x-show="!preview" class="flex h-56 flex-col items-center justify-center px-6 text-center text-sm text-slate-400">
                    <div class="text-3xl">＋</div>
                    <div class="mt-2 font-semibold">No image selected</div>
                    <div class="mt-1 text-xs">Upload an industrial image for better visual presentation.</div>
                </div>
            </div>

            <input
                class="field mt-5"
                type="file"
                name="image"
                accept="image/*"
                @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
            >
            <x-input-error :messages="$errors->get('image')" class="mt-2 text-sm text-[#711726]" />

            <p class="mt-3 text-xs leading-relaxed text-slate-500">
                Recommended: wide image, clear subject, consistent industrial style.
            </p>

            <div class="mt-6 grid gap-3">
                <button class="btn btn-primary w-full" type="submit">
                    Create Category
                </button>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline w-full">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>
@endsection