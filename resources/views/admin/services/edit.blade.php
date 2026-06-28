@extends('admin.layout')

@section('title', 'Edit Service')
@section('page_title', 'Edit Service')
@section('page_subtitle', 'Update service content, sorting, and visibility')

@section('content')
<form
    method="POST"
    action="{{ route('admin.services.update', $service) }}"
    enctype="multipart/form-data"
    class="grid gap-6 lg:grid-cols-12"
    x-data="{ preview: null }"
>
    @csrf
    @method('PUT')

    <div class="space-y-6 lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Service Details</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Update information</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Modify service title, content, and visibility settings.
                </p>
            </div>

            <div class="grid gap-5 p-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Title</label>
                    <input class="field mt-2" name="title" value="{{ old('title', $service->title) }}" required>
                    <x-input-error :messages="$errors->get('title')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Slug</label>
                    <input class="field mt-2" name="slug" value="{{ old('slug', $service->slug) }}" placeholder="auto-generated if empty">
                    <x-input-error :messages="$errors->get('slug')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Sort order</label>
                    <input type="number" min="0" class="field mt-2" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}">
                    <x-input-error :messages="$errors->get('sort_order')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Short description</label>
                    <input class="field mt-2" name="short_desc" value="{{ old('short_desc', $service->short_desc) }}">
                    <x-input-error :messages="$errors->get('short_desc')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Full description</label>
                    <textarea
    class="field mt-2"
    name="description"
    rows="7"
    data-lenis-prevent
>{{ old('description', $service->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2 flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                    <input
                        id="is_active"
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="h-5 w-5 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]"
                        @checked(old('is_active', $service->is_active))
                    >
                    <label for="is_active" class="text-sm font-black text-slate-800">
                        Active service
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 space-y-6">

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Image</div>
                <h3 class="mt-2 text-lg font-black text-slate-950">Service visual</h3>

                <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                    <template x-if="preview">
                        <img :src="preview" class="h-56 w-full object-cover" alt="Preview">
                    </template>

                    <div x-show="!preview">
                        @if ($service->image)
                            <img src="{{ asset('storage/'.$service->image) }}" class="h-56 w-full object-cover" alt="Service image">
                        @else
                            <div class="flex h-56 flex-col items-center justify-center px-6 text-center text-sm text-slate-400">
                                <div class="text-3xl">＋</div>
                                <div class="mt-2 font-semibold">No image uploaded</div>
                                <div class="mt-1 text-xs">Upload a service image.</div>
                            </div>
                        @endif
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
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Actions</div>

                <div class="mt-5 grid gap-3">
                    <button class="btn btn-primary w-full" type="submit">
                        Save Changes
                    </button>

                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline w-full">
                        Back
                    </a>

                    <button
                        type="submit"
                        form="deleteServiceForm"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-[#711726]/10 px-5 py-3 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white"
                        onclick="return confirm('Delete this service?');"
                    >
                        Delete Service
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>

<form id="deleteServiceForm" method="POST" action="{{ route('admin.services.destroy', $service) }}" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection