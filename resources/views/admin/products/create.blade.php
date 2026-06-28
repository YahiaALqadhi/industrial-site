@extends('admin.layout')

@section('title', 'New Product')
@section('page_title', 'New Product')
@section('page_subtitle', 'Create a product record with media, brochure, and features')

@section('content')
<form
    method="POST"
    action="{{ route('admin.products.store') }}"
    enctype="multipart/form-data"
    class="grid gap-6 lg:grid-cols-12"
    x-data="productForm()"
>
    @csrf

    <div class="space-y-6 lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Product Details</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Core information</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Add product identity, category, descriptions, and visibility status.
                </p>
            </div>

            <div class="grid gap-5 p-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Name</label>
                    <input class="field mt-2" name="name" value="{{ old('name') }}" required placeholder="Product name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Category</label>
                    <select class="field mt-2" name="category_id" required>
                        <option value="" disabled @selected(old('category_id') === null)>Select category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Slug</label>
                    <input class="field mt-2" name="slug" value="{{ old('slug') }}" placeholder="auto-generated from name">
                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Short description</label>
                    <input class="field mt-2" name="short_desc" value="{{ old('short_desc') }}" placeholder="Brief product summary shown in cards">
                    <x-input-error :messages="$errors->get('short_desc')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Full description</label>
                    <textarea
    class="field mt-2"
    name="description"
    rows="7"
    placeholder="Detailed product overview, application, and sourcing notes"
    data-lenis-prevent
>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2 text-sm text-[#711726]" />
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
                    <label for="is_active" class="text-sm font-black text-slate-800">Active product</label>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-6 py-5">
                <div>
                    <div class="section-kicker">Technical Features</div>
                    <h2 class="mt-2 text-xl font-black text-slate-950">Feature lines</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Add key selling points, specifications, or technical notes.
                    </p>
                </div>

                <button type="button" class="btn btn-outline" @click="addFeature()">
                    Add feature
                </button>
            </div>

            <div class="p-6">
                <div class="grid gap-3">
                    <template x-for="(row, i) in features" :key="row.id">
                        <div class="grid items-center gap-3 md:grid-cols-12">
                            <div class="md:col-span-11">
                                <input
                                    class="field"
                                    :name="`features[${i}]`"
                                    x-model="row.text"
                                    placeholder="e.g. Stainless steel construction, IP65-rated components, etc."
                                >
                            </div>

                            <div class="md:col-span-1 md:text-right">
                                <button
                                    type="button"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#711726]/10 text-lg font-black text-[#711726] transition hover:bg-[#711726] hover:text-white"
                                    @click="removeFeature(i)"
                                    aria-label="Remove feature"
                                >
                                    ×
                                </button>
                            </div>
                        </div>
                    </template>

                    <div
                        x-show="features.length === 0"
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-600"
                    >
                        No features added yet. Add technical feature lines if needed.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Cover Image</div>
                <h3 class="mt-2 text-lg font-black text-slate-950">Main product visual</h3>

                <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                    <template x-if="coverPreview">
                        <img :src="coverPreview" class="h-56 w-full object-cover" alt="Cover preview">
                    </template>

                    <div x-show="!coverPreview" class="flex h-56 flex-col items-center justify-center px-6 text-center text-sm text-slate-400">
                        <div class="text-3xl">＋</div>
                        <div class="mt-2 font-semibold">No cover selected</div>
                        <div class="mt-1 text-xs">Upload a clean product image.</div>
                    </div>
                </div>

                <input
                    class="field mt-5"
                    type="file"
                    name="cover_image"
                    accept="image/*"
                    @change="coverPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                >
                <x-input-error :messages="$errors->get('cover_image')" class="mt-2 text-sm text-[#711726]" />

                <p class="mt-3 text-xs leading-relaxed text-slate-500">
                    Recommended: wide product image with clean background.
                </p>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Documents</div>

                <label class="mt-5 block text-sm font-black text-slate-800">Brochure PDF</label>
                <input class="field mt-2" type="file" name="brochure_pdf" accept="application/pdf">
                <x-input-error :messages="$errors->get('brochure_pdf')" class="mt-2 text-sm text-[#711726]" />

                <p class="mt-3 text-xs leading-relaxed text-slate-500">
                    Upload product datasheet, brochure, or technical PDF.
                </p>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Gallery Images</div>

                <input
                    class="field mt-5"
                    type="file"
                    name="gallery_images[]"
                    accept="image/*"
                    multiple
                    @change="setGalleryPreviews($event)"
                >
                <x-input-error :messages="$errors->get('gallery_images')" class="mt-2 text-sm text-[#711726]" />
                <x-input-error :messages="$errors->get('gallery_images.*')" class="mt-2 text-sm text-[#711726]" />

                <template x-if="galleryPreviews.length">
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <template x-for="(img, idx) in galleryPreviews" :key="idx">
                            <img :src="img" class="h-24 w-full rounded-2xl border border-slate-200 object-cover" alt="Gallery preview">
                        </template>
                    </div>
                </template>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Actions</div>

                <div class="mt-5 grid gap-3">
                    <button class="btn btn-primary w-full" type="submit">
                        Create Product
                    </button>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline w-full">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function productForm() {
        return {
            coverPreview: null,
            galleryPreviews: [],
            features: [],

            addFeature() {
                this.features.push({
                    id: Date.now() + Math.random(),
                    text: '',
                });
            },

            removeFeature(index) {
                this.features.splice(index, 1);
            },

            setGalleryPreviews(event) {
                const files = Array.from(event.target.files || []);
                this.galleryPreviews = files.map((file) => URL.createObjectURL(file));
            },
        };
    }
</script>
@endsection