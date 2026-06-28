@extends('front.layout')

@section('title', 'Products')

@section('meta_description', 'Browse industrial product categories including engineering solutions, automation components, raw materials, packaging products, building materials, and customized B2B sourcing services.')

@section('meta_image', asset('assets/images/products_hero.jpg'))

@section('canonical', route('products.index'))

@section('content')
@php
    $images = [
        asset('assets/images/categories/cat1.jpg'),
        asset('assets/images/categories/cat2.jpg'),
        asset('assets/images/categories/cat3.jpg'),
        asset('assets/images/categories/cat4.jpg'),
        asset('assets/images/categories/cat5.jpg'),
        asset('assets/images/categories/cat6.jpg'),
        asset('assets/images/categories/cat7.jpg'),
        asset('assets/images/categories/cat8.jpg'),
    ];
@endphp

<section class="bg-white">
    <div class="container-max py-24 lg:py-28">
        <div class="max-w-4xl">
            <h1 data-reveal class="text-4xl font-black leading-tight tracking-[-0.04em] text-slate-950 md:text-6xl">
                Industrial categories built for faster sourcing decisions.
            </h1>

            <p data-reveal class="mt-5 max-w-2xl text-lg leading-relaxed text-slate-600">
                Browse organized solution areas, identify the right product direction, and send technical inquiries with confidence.
            </p>

            <div data-reveal class="mt-8 flex flex-col gap-4 sm:flex-row">
                <a href="#categories" class="btn btn-primary">
                    Browse Categories
                </a>
            </div>
        </div>
    </div>
</section>

<section id="categories" class="section relative overflow-hidden bg-slate-50">
    <div class="absolute -right-32 top-24 h-96 w-96 rounded-full bg-[#015ea4]/8 blur-3xl" data-parallax="80"></div>
    <div class="absolute -left-32 bottom-20 h-96 w-96 rounded-full bg-[#711726]/6 blur-3xl" data-parallax="60"></div>

    <div class="container-max relative">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div>
                <div data-reveal class="section-kicker">TOP CATEGORIES</div>
                <h2 data-reveal class="mt-3 section-title">Explore by solution area.</h2>
                <p data-reveal class="mt-4 max-w-2xl text-slate-600">
                    A cleaner category structure helps visitors move from discovery to inquiry with less friction.
                </p>
            </div>

            <a data-reveal href="{{ route('contact') }}" class="hidden sm:inline-flex btn btn-primary magnetic-card">
                Request Support
            </a>
        </div>

        <div class="mt-10 grid items-stretch gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($categories as $i => $category)
                <a
                    data-reveal
                    href="{{ route('products.category', $category->slug) }}"
                    class="group magnetic-card relative flex h-full flex-col overflow-hidden rounded-[1.7rem] border border-slate-200 bg-white shadow-lg shadow-slate-900/5 transition-all duration-500 hover:-translate-y-3 hover:scale-[1.025] hover:border-[#015ea4]/40 hover:shadow-2xl hover:shadow-[#015ea4]/20"
                    data-mouse-depth="4"
                >
                    <div class="relative overflow-hidden">
                        <img
                            class="h-60 w-full object-cover transition duration-700 group-hover:scale-110"
                            src="{{ $category->image ? asset('storage/'.$category->image) : $images[$i % count($images)] }}"
                            alt="{{ $category->name }}"
                            data-parallax="30"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/25 to-transparent transition duration-500 group-hover:from-[#015ea4]/50 group-hover:via-[#015ea4]/25"></div>

                        <div class="absolute left-5 top-5 rounded-full border border-white/30 bg-white/90 px-3 py-1 text-xs font-black uppercase tracking-wide text-[#015ea4] backdrop-blur">
                            Category
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-lg font-black leading-snug text-slate-950 transition duration-300 group-hover:text-[#015ea4]">
                            {{ $category->name }}
                        </h3>

                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">
                            {{ $category->description ?: 'View related product groups and sourcing options.' }}
                        </p>

                        <div class="mt-auto pt-6">
                            <div class="inline-flex items-center gap-2 text-sm font-black text-[#015ea4]">
                                Open category
                                <span class="transition group-hover:translate-x-1">→</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div data-reveal class="mt-14 grid gap-6 lg:grid-cols-12">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/5 lg:col-span-5">
                <div class="section-kicker">WHAT YOU CAN SEND</div>
                <h3 class="mt-3 text-2xl font-black text-slate-950">
                    Better inquiry details help us respond faster.
                </h3>
                <p class="mt-4 text-sm leading-relaxed text-slate-600">
                    Include quantity, destination, timeline, preferred standard, product photos, drawings, voltage, capacity, material grade, or operating conditions.
                </p>
            </div>

            <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950 p-8 text-white shadow-2xl shadow-slate-900/20 lg:col-span-7">
                <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#015ea4]/35 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-[#711726]/28 blur-3xl"></div>

                <div class="relative">
                    <div class="text-sm font-black uppercase tracking-[0.22em] text-white/60">
                        Need a sourcing recommendation?
                    </div>
                    <p class="mt-3 max-w-3xl text-white/75">
                        Share your standards, capacity, quantity, and target delivery timeline. We will guide you to the suitable category and clarify the minimum technical data needed.
                    </p>

                    <div class="mt-6">
                        <a href="{{ route('contact') }}" class="btn bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white">
                            Contact Sales Engineering
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection