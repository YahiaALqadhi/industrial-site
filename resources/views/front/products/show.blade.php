@extends('front.layout')

@section('title', $product->name)

@section('meta_description', $product->short_desc ?: \Illuminate\Support\Str::limit(strip_tags($product->description ?: 'Industrial product details, specifications, features, brochure, and sourcing inquiry support.'), 155))

@section('meta_image', $product->cover_image ? asset('storage/'.$product->cover_image) : asset('assets/images/products/default.jpg'))

@section('canonical', route('products.show', $product->slug))

@section('content')
@php
    $gallery = $product->images;

    $initial = $product->cover_image
        ? asset('storage/' . $product->cover_image)
        : ($gallery->first() ? asset('storage/' . $gallery->first()->path) : asset('assets/images/products/default.jpg'));

    $thumbs = [];

    if ($product->cover_image) {
        $thumbs[] = asset('storage/' . $product->cover_image);
    }

    foreach ($gallery as $img) {
        $thumbs[] = asset('storage/' . $img->path);
    }

    if (count($thumbs) === 0) {
        $thumbs = [asset('assets/images/products/default.jpg')];
    }
@endphp

<section class="relative overflow-hidden bg-white">
    <div class="absolute inset-0">
        <img
            class="h-full w-full object-cover opacity-40"
            src="{{ $product->cover_image ? asset('storage/'.$product->cover_image) : asset('assets/images/products/default.jpg') }}"
            alt="{{ $product->name }}"
            data-parallax="70"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-[#061421]/95 via-[#015ea4]/65 to-transparent"></div>
    </div>

    <div class="relative container-max py-20 lg:py-24">
        <nav data-reveal class="text-sm font-semibold text-white/80">
            <a class="transition hover:text-white" href="{{ route('home') }}">Home</a>
            <span class="mx-2">/</span>
            <a class="transition hover:text-white" href="{{ route('products.index') }}">Products</a>

            @foreach ($breadcrumbs as $crumb)
                <span class="mx-2">/</span>
                <a class="transition hover:text-white" href="{{ route('products.category', $crumb->slug) }}">
                    {{ $crumb->name }}
                </a>
            @endforeach

            <span class="mx-2">/</span>
            <span class="text-white">{{ $product->name }}</span>
        </nav>

        <div class="mt-6 max-w-3xl">
            <!-- <div data-reveal class="inline-flex items-center gap-3 rounded-full border border-white/25 bg-white/15 px-4 py-2 text-white backdrop-blur">
                <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" class="h-9 w-9 rounded-xl bg-white object-contain p-1">
                <span class="text-xs font-black uppercase tracking-[0.22em]">Product Details</span>
            </div> -->

            <h1 data-reveal class="mt-6 text-4xl font-black leading-tight tracking-[-0.04em] text-white md:text-6xl">
                {{ $product->name }}
            </h1>

            <p data-reveal class="mt-5 max-w-2xl text-lg leading-relaxed text-white/80">
                {{ $product->short_desc ?: 'Review product details, available features, and submit an inquiry for specifications, pricing, and delivery coordination.' }}
            </p>

            <div data-reveal class="mt-8 flex flex-col gap-4 sm:flex-row">
                <a href="#inquiry" class="btn bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white">
                    Start Inquiry
                </a>

                @if ($product->brochure_pdf)
                    <a class="btn btn-outline" href="{{ asset('storage/' . $product->brochure_pdf) }}" target="_blank" rel="noopener">
                        Download Brochure
                    </a>
                @else
                    <a class="btn btn-outline" href="{{ route('contact') }}">
                        Request Brochure
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="section relative overflow-hidden bg-slate-50">
    <div class="absolute -right-32 top-24 h-96 w-96 rounded-full bg-[#015ea4]/8 blur-3xl" data-parallax="80"></div>
    <div class="absolute -left-32 bottom-20 h-96 w-96 rounded-full bg-[#711726]/6 blur-3xl" data-parallax="60"></div>

    <div class="container-max relative">
        <div class="grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-6" x-data="{ active: '{{ $initial }}' }">
                <div data-reveal class="magnetic-card overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-3 shadow-2xl shadow-slate-900/10" data-mouse-depth="5">
                    <img :src="active" class="h-[430px] w-full rounded-[1.5rem] object-cover" alt="{{ $product->name }}">
                </div>

                <div data-reveal class="mt-4 grid grid-cols-4 gap-3">
                    @foreach ($thumbs as $src)
                        <button
                            type="button"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-1 transition duration-300 hover:-translate-y-1 hover:border-[#015ea4]/40 hover:shadow-lg"
                            @click="active = '{{ $src }}'"
                        >
                            <img src="{{ $src }}" class="h-20 w-full rounded-xl object-cover" alt="Thumbnail">
                        </button>
                    @endforeach
                </div>

                <div data-reveal class="mt-6 rounded-[2rem] border border-slate-200 bg-white p-7 shadow-lg shadow-slate-900/5">
                    <div class="section-kicker">DOCUMENTATION SUPPORT</div>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Upon request, we can support available datasheets, packing details, lead-time guidance, compatibility notes, and delivery coordination.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div data-reveal class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/5">
                    <div class="section-kicker">OVERVIEW</div>

                    <div class="mt-5 whitespace-pre-line leading-relaxed text-slate-600">
                        {{ $product->description ?: 'This product page provides a structured overview for professional inquiries. Use the features list and inquiry form to share technical requirements, target capacity, standards, and delivery timeline.' }}
                    </div>

                    <div class="mt-8 border-t border-slate-200 pt-7">
                        <div class="section-kicker">KEY FEATURES</div>

                        <ul class="mt-5 grid gap-3 text-sm text-slate-700">
                            @forelse ($product->features as $feature)
                                <li class="flex gap-3 rounded-2xl bg-slate-50 p-4">
                                    <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-[#000000]"></span>
                                    <span>{{ $feature->text }}</span>
                                </li>
                            @empty
                                <li class="flex gap-3 rounded-2xl bg-slate-50 p-4">
                                    <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-[#711726]"></span>
                                    <span>Provide your requirements and we will confirm specifications, compatibility, and deliverables.</span>
                                </li>
                                <li class="flex gap-3 rounded-2xl bg-slate-50 p-4">
                                    <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-[#711726]"></span>
                                    <span>Request lead time, packing configuration, and recommended spare parts guidance.</span>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        @if ($product->brochure_pdf)
                            <a class="btn btn-primary" href="{{ asset('storage/' . $product->brochure_pdf) }}" target="_blank" rel="noopener">
                                Download Brochure
                            </a>
                        @else
                            <a class="btn btn-primary" href="{{ route('contact') }}">
                                Request Brochure
                            </a>
                        @endif

                        <a class="btn btn-outline" href="#inquiry">
                            Start Inquiry
                        </a>
                    </div>
                </div>

                <div id="inquiry" data-reveal class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/5">
                    <div class="section-kicker">PRODUCT INQUIRY</div>

                    <h2 class="mt-3 text-2xl font-black text-slate-950">
                        Request specifications and commercial terms.
                    </h2>

                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Include required standards, capacity, utilities, quantity, and delivery destination to help us respond accurately.
                    </p>

                    <form class="mt-8 grid gap-4" method="POST" action="{{ route('inquiry.product', $product->slug) }}">
                        @csrf

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-bold text-slate-800">Name</label>
                                <input name="name" value="{{ old('name') }}" class="field mt-1" required>
                                @error('name')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-800">Email</label>
                                <input name="email" type="email" value="{{ old('email') }}" class="field mt-1" required>
                                @error('email')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-bold text-slate-800">Phone</label>
                                <input name="phone" value="{{ old('phone') }}" class="field mt-1">
                                @error('phone')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-800">Company</label>
                                <input name="company" value="{{ old('company') }}" class="field mt-1">
                                @error('company')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-800">Subject</label>
                            <input name="subject" value="{{ old('subject', 'Product inquiry: ' . $product->name) }}" class="field mt-1">
                            @error('subject')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-800">Message</label>
                            <textarea name="message" rows="6" class="field mt-1" required>{{ old('message') }}</textarea>
                            @error('message')<div class="mt-1 text-sm text-[#711726]">{{ $message }}</div>@enderror
                        </div>

                        <div class="pt-2">
                            <button class="btn btn-primary w-full sm:w-auto" type="submit">
                                Submit Inquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div data-reveal class="mt-14 relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950 p-8 text-white shadow-2xl shadow-slate-900/20">
            <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#015ea4]/35 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-[#711726]/28 blur-3xl"></div>

            <div class="relative grid gap-6 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-8">
                    <div class="text-sm font-black uppercase tracking-[0.22em] text-white/60">
                        Not exactly what you need?
                    </div>
                    <p class="mt-3 text-white/75">
                        Send photos, drawings, capacity, standards, and target delivery date. We will help clarify the suitable product direction.
                    </p>
                </div>

                <div class="lg:col-span-4 lg:text-right">
                    <a href="{{ route('contact') }}" class="btn bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white">
                        Ask for Sourcing Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ $product->short_desc ?: \Illuminate\Support\Str::limit(strip_tags($product->description ?: 'Industrial product available for sourcing inquiry.'), 180) }}",
    "image": "{{ $product->cover_image ? asset('storage/'.$product->cover_image) : asset('assets/images/products/default.jpg') }}",
    "url": "{{ route('products.show', $product->slug) }}",
    "brand": {
        "@type": "Brand",
        "name": "{{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }}"
    }
}
</script>
@endpush

@endsection