@extends('front.layout')

@section('title', 'Home')

@section('meta_description', 'Professional industrial sourcing company in China supplying engineering equipment, automation systems, industrial materials, OEM manufacturing, procurement, inspection, and global export solutions.')

@section('meta_image', asset('assets/images/logo.png'))

@section('canonical', url('/'))

@section('content')
@php
    $advantages = [
        ['title' => 'Responsive handling', 'text' => 'Fast acknowledgment, clear timelines, and structured follow-ups across all inquiries.', 'icon' => 'M12 6v6l4 2 M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['title' => 'Compliance mindset', 'text' => 'Documentation-ready sourcing aligned with industrial requirements and project standards.', 'icon' => 'M9 12l2 2 4-4 M12 22C7.029 20 4 16 4 11V5l8-3 8 3v6c0 5-3.029 9-8 11z'],
        ['title' => 'Clear documentation', 'text' => 'We structure product data and deliverable lists to reduce ambiguity and delays.', 'icon' => 'M4 19V7a2 2 0 012-2h12a2 2 0 012 2v12 M7 9h10M7 13h6M7 17h10'],
        ['title' => 'Delivery coordination', 'text' => 'Support for loading, shipment scheduling, and export documentation workflows.', 'icon' => 'M3 7h18M6 7l1 14h10l1-14 M10 11v6M14 11v6'],
    ];

    $process = [
        ['title' => 'Requirement clarification', 'text' => 'We organize product specifications, missing details, application needs, and project expectations before sourcing.'],
        ['title' => 'Supplier coordination', 'text' => 'We support communication, quotation comparison, documentation alignment, and technical follow-up.'],
        ['title' => 'Delivery follow-through', 'text' => 'We keep packing, shipment, export documents, and delivery coordination visible and traceable.'],
    ];
@endphp

<section class="hero bg-white">
    <div class="container-max min-h-[82vh] py-20">
        <div class="grid min-h-[72vh] grid-cols-1 items-center gap-12 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <div data-reveal class="section-kicker">
                    INDUSTRIAL SOURCING PARTNER
                </div>

                <h1 data-reveal class="mt-5 max-w-4xl text-4xl font-black leading-[1.02] tracking-[-0.055em] text-slate-950 md:text-6xl">
                    NINGBO PASAFEITE IMPORT AND EXPORT CO, LTD
                </h1>

                <p data-reveal class="mt-6 max-w-2xl text-lg leading-relaxed text-slate-600">
                    Trading and technical consulting services for industrial and engineering equipment, automation products, sourcing coordination, documentation, and shipment follow-up.
                </p>

                <div data-reveal class="mt-9 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('products.index') }}" class="btn btn-primary magnetic-card">
                        Explore Products
                    </a>

                    <a href="{{ route('contact') }}" class="btn btn-outline magnetic-card">
                        Request Consultation
                    </a>
                </div>

                <div data-reveal class="mt-10 grid max-w-2xl grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="card lift p-5">
                        <div class="text-3xl font-black text-[#015ea4]">7+</div>
                        <div class="mt-1 text-xs font-bold uppercase tracking-wide text-slate-500">Core Categories</div>
                    </div>

                    <div class="card lift p-5">
                        <div class="text-3xl font-black text-[#015ea4]">B2B</div>
                        <div class="mt-1 text-xs font-bold uppercase tracking-wide text-slate-500">Industrial Sourcing</div>
                    </div>

                    <div class="card lift p-5">
                        <div class="text-3xl font-black text-[#015ea4]">360°</div>
                        <div class="mt-1 text-xs font-bold uppercase tracking-wide text-slate-500">Inquiry to Shipment</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div data-reveal class="perspective-wrap relative">
                    <div
                        class="magnetic-card gpu-layer relative h-[460px] overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl shadow-slate-900/10"
                        data-mouse-depth="10"
                    >
                        <canvas
                            data-industrial-scene
                            class="pointer-events-none absolute inset-0 h-full w-full"
                            aria-hidden="true"
                        ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-white">
    <div class="container-max">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <div data-reveal class="section-kicker">OUR APPROACH</div>

                <h2 data-reveal class="mt-3 section-title">
                    A practical process for industrial purchasing and project support.
                </h2>

                <p data-reveal class="mt-5 leading-relaxed text-slate-600">
                    Industrial procurement requires more than a quotation. We help clarify requirements, coordinate with suppliers, organize technical details, and support delivery planning through a structured workflow.
                </p>

                <div class="mt-7 grid gap-4">
                    @foreach ($process as $item)
                        <div data-reveal class="card lift p-5">
                            <div class="font-black text-slate-950">{{ $item['title'] }}</div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                {{ $item['text'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div data-reveal class="mt-8">
                    <a href="{{ route('about') }}" class="btn btn-primary magnetic-card">
                        Learn About Us
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div data-reveal class="perspective-wrap relative">
                    <div class="magnetic-card gpu-layer relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-4 shadow-2xl shadow-slate-900/10" data-mouse-depth="11">
                        <img
    src="{{ asset('assets/images/about/hero.jpg') }}"
    class="h-[460px] w-full rounded-[1.5rem] object-cover"
    alt="Industrial facility"
    data-parallax="40"
    loading="lazy"
    decoding="async"
>

                        <div class="absolute inset-x-8 bottom-8 rounded-3xl border border-white/40 bg-white/90 p-5 shadow-xl backdrop-blur-xl">
                            <div class="text-sm font-black text-[#015ea4]">Structured Industrial Support</div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                Clear requirements, supplier coordination, documentation, and shipment visibility.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-slate-50">
    <div class="container-max">
        <div class="mx-auto max-w-2xl text-center">
            <div data-reveal class="section-kicker">WHY CHOOSE US</div>
            <h2 data-reveal class="mt-3 section-title">Precision, communication, and accountability.</h2>
            <p data-reveal class="mt-4 text-slate-700">
                A modern industrial partner should provide more than a price list. Your team needs clarity, documentation, and dependable follow-through.
            </p>
        </div>

        <div class="mt-10 grid-4">
            @foreach ($advantages as $item)
                <div data-reveal class="card lift magnetic-card p-7" data-mouse-depth="3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#015ea4]/10">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="#015EA4" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <div class="mt-4 font-black text-slate-950">{{ $item['title'] }}</div>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section bg-white">
    <div class="container-max">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div>
                <div data-reveal class="section-kicker">FEATURED CATEGORIES</div>
                <h2 data-reveal class="mt-3 section-title">Explore our industrial portfolio.</h2>
                <p data-reveal class="mt-4 max-w-2xl text-slate-600">
                    Browse key product groups including engineering solutions, automation, materials, packaging, and customized sourcing.
                </p>
            </div>

            <a data-reveal href="{{ route('products.index') }}" class="hidden sm:inline-flex btn btn-primary magnetic-card whitespace-nowrap">
                View All Products
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredCategories as $category)
                <a
                    data-reveal
                    href="{{ route('products.category', $category->slug) }}"
                    class="group magnetic-card relative flex h-full flex-col overflow-hidden rounded-[1.7rem] border border-slate-200 bg-white shadow-lg shadow-slate-900/5 transition-all duration-500 hover:-translate-y-3 hover:scale-[1.025] hover:border-[#015ea4]/40 hover:shadow-2xl hover:shadow-[#015ea4]/20"
                    data-mouse-depth="4"
                >
                    <div class="relative overflow-hidden">
                        <img
    class="h-60 w-full object-cover transition duration-700 group-hover:scale-110"
    src="{{ $category->image ? asset('storage/'.$category->image) : asset('assets/images/default.jpg') }}"
    alt="{{ $category->name }}"
    loading="lazy"
    decoding="async"
>

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/25 to-transparent transition duration-500 group-hover:from-[#015ea4]/50 group-hover:via-[#015ea4]/25"></div>
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-lg font-black leading-snug text-slate-950 transition duration-300 group-hover:text-[#015ea4]">
                            {{ $category->name }}
                        </h3>

                        <div class="mt-auto pt-5">
                            <span class="inline-flex items-center gap-2 text-sm font-black text-[#015ea4]">
                                Explore category
                                <span class="transition group-hover:translate-x-1">→</span>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div data-reveal class="mt-8 sm:hidden">
            <a href="{{ route('products.index') }}" class="btn btn-primary w-full">
                View All Products
            </a>
        </div>
    </div>
</section>

<section class="section bg-slate-50">
    <div class="container-max">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div>
                <div data-reveal class="section-kicker">SERVICE WORKFLOW</div>
                <h2 data-reveal class="mt-3 section-title">From inquiry to shipment, every step stays organized.</h2>
                <p data-reveal class="mt-4 max-w-2xl text-slate-600">
                    Our service process connects technical requirements, sourcing coordination, commercial follow-up, and delivery planning.
                </p>
            </div>

            <a data-reveal href="{{ route('services') }}" class="hidden sm:inline-flex btn btn-primary magnetic-card whitespace-nowrap">
                All Services
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $service)
                <div
                    data-reveal
                    class="group magnetic-card relative flex h-full flex-col overflow-hidden rounded-[1.7rem] border border-slate-200 bg-white shadow-lg shadow-slate-900/5 transition-all duration-500 hover:-translate-y-3 hover:scale-[1.02] hover:border-[#015ea4]/35 hover:shadow-2xl hover:shadow-[#015ea4]/15"
                    data-mouse-depth="3"
                >
                    <img
    class="h-56 w-full object-cover transition duration-700 group-hover:scale-110"
    src="{{ $service->image ? asset('storage/'.$service->image) : asset('assets/images/products_hero.jpg') }}"
    alt="{{ $service->title }}"
    loading="lazy"
    decoding="async"
>

                    <div class="flex flex-1 flex-col p-7">
                        <h3 class="text-lg font-black text-slate-950 transition group-hover:text-[#015ea4]">
                            {{ $service->title }}
                        </h3>

                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            {{ $service->short_desc }}
                        </p>

                        <a href="{{ route('services') }}" class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-black text-[#015ea4]">
                            Explore service
                            <span class="transition group-hover:translate-x-1">→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div data-reveal class="mt-8 sm:hidden">
            <a href="{{ route('services') }}" class="btn btn-primary w-full">
                All Services
            </a>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container-max py-16">
        <div data-reveal class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950 p-10 text-white shadow-2xl shadow-slate-900/20 md:p-12">
            <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#015ea4]/35 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-[#711726]/28 blur-3xl"></div>

            <div class="relative grid gap-8 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-8">
                    <div class="text-sm font-black uppercase tracking-[0.22em] text-white/60">
                        READY TO START?
                    </div>
                    <div class="mt-3 text-2xl font-black leading-tight md:text-4xl">
                        Share your requirement and we will help organize the next step.
                    </div>
                    <p class="mt-4 max-w-2xl leading-relaxed text-white/75">
                        Send product details, technical requirements, target quantity, and timeline. Our team will review the scope and respond with a clear path forward.
                    </p>
                </div>

                <div class="lg:col-span-4 lg:text-right">
                    <a href="{{ route('contact') }}" class="btn magnetic-card bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white whitespace-nowrap">
                        Start an Inquiry
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection