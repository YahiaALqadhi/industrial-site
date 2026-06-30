@extends('front.layout')

@section('title', $category->name)

@section('meta_description', $category->description ?: 'Explore ' . $category->name . ' industrial products, subcategories, and sourcing solutions.')

@section('meta_image', $category->image ? asset('storage/'.$category->image) : asset('assets/images/og-image.png.jpg'))

@section('canonical', route('products.category', $category->slug))

@section('content')
<section class="bg-white">
    <div class="container-max py-20 lg:py-24">
        <nav data-reveal class="text-sm font-semibold text-slate-500">
            <a class="hover:text-slate-900" href="{{ route('home') }}">Home</a>
            <span class="mx-2">/</span>
            <a class="hover:text-slate-900" href="{{ route('products.index') }}">Products</a>
            @foreach ($breadcrumbs as $crumb)
                <span class="mx-2">/</span>
                <a class="hover:text-slate-900" href="{{ route('products.category', $crumb->slug) }}">
                    {{ $crumb->name }}
                </a>
            @endforeach
        </nav>

        <div class="mt-6 max-w-4xl">
            <h1 data-reveal class="text-4xl font-black leading-tight tracking-[-0.04em] text-slate-950 md:text-6xl">
                {{ $category->name }}
            </h1>

            <p data-reveal class="mt-4 max-w-2xl text-lg leading-relaxed text-slate-600">
                {{ $category->description ?: 'Browse subcategories and products, then submit your inquiry with technical details.' }}
            </p>
        </div>
    </div>
</section>

<section class="section relative overflow-hidden bg-slate-50">
    <div class="absolute -right-32 top-24 h-96 w-96 rounded-full bg-[#015ea4]/8 blur-3xl" data-parallax="80"></div>
    <div class="absolute -left-32 bottom-20 h-96 w-96 rounded-full bg-[#711726]/6 blur-3xl" data-parallax="60"></div>

    <div class="container-max relative">
        @if ($subcategories->count())
            <div>
                <div data-reveal class="section-kicker">SUBCATEGORIES</div>
                <h2 data-reveal class="mt-3 section-title">Refine your selection</h2>

                <div class="mt-8 grid items-stretch gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($subcategories as $sub)
                        <a
                            data-reveal
                            href="{{ route('products.category', $sub->slug) }}"
                            class="group magnetic-card relative flex h-full flex-col overflow-hidden rounded-[1.7rem] border border-slate-200 bg-white shadow-lg shadow-slate-900/5 transition-all duration-500 hover:-translate-y-3 hover:scale-[1.02] hover:border-[#015ea4]/35 hover:shadow-2xl hover:shadow-[#015ea4]/15"
                            data-mouse-depth="4"
                        >
                            <div class="relative overflow-hidden">
                                @if ($sub->image)
                                    <img class="h-52 w-full object-cover transition duration-700 group-hover:scale-110" src="{{ asset('storage/'.$sub->image) }}" alt="{{ $sub->name }}" data-parallax="30">
                                @else
                                    <div class="h-52 bg-gradient-to-br from-[#015ea4]/80 to-slate-950"></div>
                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent transition duration-500 group-hover:from-[#015ea4]/85 group-hover:via-[#015ea4]/25"></div>
                            </div>

                            <div class="flex flex-1 flex-col p-6">
                                <h3 class="text-lg font-black leading-snug text-slate-950 transition duration-300 group-hover:text-[#015ea4]">
                                    {{ $sub->name }}
                                </h3>

                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">
                                    {{ $sub->description ?: 'Explore related product groups, technical options, and sourcing support under this subcategory.' }}
                                </p>

                                <div class="mt-auto pt-6 text-sm font-black text-[#015ea4]">
                                    Open subcategory →
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="my-14 border-t border-slate-200"></div>
            </div>
        @endif

        <div>
            <div data-reveal class="section-kicker">PRODUCTS</div>
            <h2 data-reveal class="mt-3 section-title">Available products</h2>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($products as $product)
                    <a
                        data-reveal
                        href="{{ route('products.show', $product->slug) }}"
                        class="group magnetic-card relative flex h-full flex-col overflow-hidden rounded-[1.7rem] border border-slate-200 bg-white shadow-lg shadow-slate-900/5 transition-all duration-500 hover:-translate-y-3 hover:scale-[1.02] hover:border-[#015ea4]/35 hover:shadow-2xl hover:shadow-[#015ea4]/15"
                        data-mouse-depth="4"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                class="h-56 w-full object-cover transition duration-700 group-hover:scale-110"
                                src="{{ $product->cover_image ? asset('storage/'.$product->cover_image) : asset('assets/images/products/default.jpg') }}"
                                alt="{{ $product->name }}"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-70 transition duration-500 group-hover:opacity-90"></div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="text-lg font-black text-slate-950 transition duration-300 group-hover:text-[#015ea4]">
                                {{ $product->name }}
                            </h3>

                            @if ($product->short_desc)
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">
                                    {{ $product->short_desc }}
                                </p>
                            @endif

                            <div class="mt-auto pt-6 text-sm font-black text-[#015ea4]">
                                View details →
                            </div>
                        </div>
                    </a>
                @empty
                    <div data-reveal class="col-span-full rounded-[2rem] border border-slate-200 bg-white p-10 text-center text-slate-500 shadow-lg">
                        No products available yet.
                    </div>
                @endforelse
            </div>

            <div data-reveal class="mt-10">
                {{ $products->links() }}
            </div>
        </div>

        <div data-reveal class="mt-14 relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950 p-8 text-white shadow-2xl shadow-slate-900/20">
            <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#015ea4]/35 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-[#711726]/28 blur-3xl"></div>

            <div class="relative grid gap-6 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-8">
                    <div class="text-sm font-black uppercase tracking-[0.22em] text-white/60">Need help?</div>
                    <p class="mt-3 text-white/75">
                        Share your technical requirements and timeline. We will guide you to the right solution.
                    </p>
                </div>

                <div class="lg:col-span-4 lg:text-right">
                    <a href="{{ route('contact') }}" class="btn bg-white text-[#015ea4] hover:bg-[#015ea4] hover:text-white">
                        Contact Sales
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
    "@type": "CollectionPage",
    "name": "{{ $category->name }}",
    "description": "{{ $category->description ?: 'Industrial products and solutions in ' . $category->name }}",
    "url": "{{ route('products.category', $category->slug) }}"
}
</script>
@endpush

@endsection