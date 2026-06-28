@extends('admin.layout')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')
@section('page_subtitle', 'Update product details, media, gallery, and features')

@section('content')
<form
    method="POST"
    action="{{ route('admin.products.update', $product) }}"
    enctype="multipart/form-data"
    class="grid gap-6 lg:grid-cols-12"
    x-data='productEditForm(@json($product->features->pluck("text")->values()))'
>
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Product Details</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Core information</h2>
            </div>

            <div class="grid gap-5 p-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Name</label>
                    <input class="field mt-2" name="name" value="{{ old('name', $product->name) }}" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Category</label>
                    <select class="field mt-2" name="category_id" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Slug</label>
                    <input class="field mt-2" name="slug" value="{{ old('slug', $product->slug) }}">
                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Short description</label>
                    <input class="field mt-2" name="short_desc" value="{{ old('short_desc', $product->short_desc) }}">
                    <x-input-error :messages="$errors->get('short_desc')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Full description</label>
                    <textarea
    class="field mt-2"
    name="description"
    rows="7"
    data-lenis-prevent
>{{ old('description', $product->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                    <input
                        id="is_active"
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="h-5 w-5 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]"
                        @checked(old('is_active', $product->is_active))
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
                                <input class="field" :name="`features[${i}]`" x-model="row.text">
                            </div>

                            <div class="md:col-span-1 md:text-right">
                                <button
                                    type="button"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#711726]/10 text-lg font-black text-[#711726] transition hover:bg-[#711726] hover:text-white"
                                    @click="removeFeature(i)"
                                >
                                    ×
                                </button>
                            </div>
                        </div>
                    </template>

                    <div x-show="features.length === 0" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-600">
                        No features added yet.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Cover Image</div>

                <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                    <template x-if="coverPreview">
                        <img :src="coverPreview" class="h-56 w-full object-cover" alt="Cover preview">
                    </template>

                    <div x-show="!coverPreview">
                        @if ($product->cover_image)
                            <img src="{{ asset('storage/'.$product->cover_image) }}" class="h-56 w-full object-cover" alt="Cover">
                        @else
                            <div class="flex h-56 items-center justify-center text-sm text-slate-400">
                                No cover uploaded
                            </div>
                        @endif
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
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Brochure PDF</div>

                <input class="field mt-5" type="file" name="brochure_pdf" accept="application/pdf">
                <x-input-error :messages="$errors->get('brochure_pdf')" class="mt-2 text-sm text-[#711726]" />

                @if ($product->brochure_pdf)
                    <a href="{{ asset('storage/'.$product->brochure_pdf) }}" target="_blank" rel="noopener" class="mt-4 inline-flex text-sm font-black text-[#015ea4]">
                        View current brochure →
                    </a>
                @else
                    <p class="mt-4 text-sm text-slate-500">No brochure uploaded.</p>
                @endif
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Gallery</div>

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

                <div class="mt-5 grid grid-cols-2 gap-3">
                    @forelse ($product->images as $img)
                        <label class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                            <img class="h-24 w-full object-cover" src="{{ asset('storage/'.$img->path) }}" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 to-transparent"></div>

                            <div class="absolute left-2 top-2">
                                <input type="checkbox" name="delete_gallery[]" value="{{ $img->id }}" class="h-5 w-5 rounded border-white text-[#711726] focus:ring-[#711726]">
                            </div>

                            <div class="absolute bottom-2 left-2 text-xs font-black text-white">
                                Mark delete
                            </div>
                        </label>
                    @empty
                        <div class="col-span-2 rounded-2xl bg-slate-50 p-4 text-sm text-slate-500">
                            No gallery images uploaded.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Actions</div>

                <div class="mt-5 grid gap-3">
                    <button class="btn btn-primary w-full" type="submit">
                        Save Changes
                    </button>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline w-full">
                        Back
                    </a>

                    <button
                        type="submit"
                        form="deleteProductForm"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-[#711726]/10 px-5 py-3 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white"
                        onclick="return confirm('Delete this product?');"
                    >
                        Delete Product
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="deleteProductForm" method="POST" action="{{ route('admin.products.destroy', $product) }}" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function productEditForm(initialFeatures) {
        return {
            coverPreview: null,
            galleryPreviews: [],
            features: (initialFeatures || []).map((text) => ({
                id: Date.now() + Math.random(),
                text,
            })),

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