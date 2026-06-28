@php
    $topCategories = \App\Models\Category::query()
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->limit(7)
        ->get(['id', 'name', 'slug']);
@endphp

<header
    x-data="{
        mobileOpen: false,
        productsOpen: false,
        mobileProductsOpen: false,
        visible: true,
        scrolled: false,
        atTop: true,
        isHome: window.location.pathname === '/',
        lastScrollY: 0,

        handleScroll() {
            const y = window.pageYOffset || document.documentElement.scrollTop;
            const diff = y - this.lastScrollY;

            this.atTop = y < 24;
            this.scrolled = y > 60;

            if (this.mobileOpen || this.productsOpen || y < 120) {
                this.visible = true;
            } else if (diff > 8) {
                this.visible = false;
            } else if (diff < -6) {
                this.visible = true;
            }

            this.lastScrollY = y <= 0 ? 0 : y;
        }
    }"
    x-init="
        lastScrollY = window.pageYOffset || document.documentElement.scrollTop;
        handleScroll();
        window.addEventListener('scroll', () => handleScroll(), { passive: true });
    "
    class="fixed left-0 right-0 top-0 z-50 px-3 pt-3 transition-[transform,opacity] duration-500 ease-out"
    :style="visible
        ? 'transform: translateY(0); opacity:1;'
        : 'transform: translateY(-115%); opacity:0;'"
>
    <div class="container-max">
        <div
    class="site-header rounded-[1.75rem] border border-white/15 backdrop-blur-xl transition-all duration-300"
    :class="scrolled
        ? 'shadow-2xl shadow-slate-950/25 scale-[0.985]'
        : 'shadow-2xl shadow-[#004D80]/20 scale-100'"
>
            <div class="flex h-20 items-center justify-between gap-6 px-4 md:px-6">
                <a
                    href="{{ route('home') }}"
                    class="magnetic-card flex min-w-0 items-center gap-3 text-white"
                    aria-label="{{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }} home"
                >
                    <img
                        src="{{ asset('assets/images/logo.jpg') }}"
                        alt="{{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }} logo"
                        class="h-14 w-14 shrink-0 rounded-2xl bg-white object-contain p-1.5 shadow-lg"
                    >

                    <div class="min-w-0 leading-tight">
                        <div class="truncate text-lg font-extrabold tracking-wide">
                            {{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }}
                        </div>
                        
                    </div>
                </a>

                <nav class="hidden items-center gap-1 rounded-2xl bg-white/[0.07] p-1.5 ring-1 ring-white/10 backdrop-blur-xl lg:flex" aria-label="Primary navigation">
                    <a class="nav-link nav-link-pill {{ request()->routeIs('home') ? 'nav-link-active' : '' }}" href="{{ route('home') }}">Home</a>
                    <a class="nav-link nav-link-pill {{ request()->routeIs('about') ? 'nav-link-active' : '' }}" href="{{ route('about') }}">About</a>

                    <div class="relative" @mouseenter="productsOpen = true" @mouseleave="productsOpen = false">
                        <a
                            href="{{ route('products.index') }}"
                            class="nav-link nav-link-pill {{ request()->routeIs('products.*') ? 'nav-link-active' : '' }} inline-flex items-center gap-2"
                            aria-haspopup="true"
                            :aria-expanded="productsOpen ? 'true' : 'false'"
                        >
                            <span>Products</span>
                            <svg
                                class="h-4 w-4 transition-transform duration-200"
                                :class="productsOpen ? 'rotate-180' : ''"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                            </svg>
                        </a>

                        <div
                            x-show="productsOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="product-dropdown"
                            style="display:none"
                        >
                            <div class="product-dropdown-panel">
                                <div class="px-4 pb-2 pt-4">
                                    <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-slate-400">
                                        Product Categories
                                    </div>
                                </div>

                                <div class="grid gap-1 p-2 pt-0" aria-label="Product categories">
                                    @foreach ($topCategories as $category)
                                        <a href="{{ route('products.category', $category->slug) }}" class="product-dropdown-link magnetic-card">
                                            <span>{{ $category->name }}</span>
                                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endforeach
                                </div>

                                <div class="border-t p-3" style="border-color:rgba(0,0,0,.08)">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary magnetic-card w-full">
                                        View All Products
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="nav-link nav-link-pill {{ request()->routeIs('services') ? 'nav-link-active' : '' }}" href="{{ route('services') }}">Services</a>
                    <a class="nav-link nav-link-pill {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}" href="{{ route('contact') }}">Contact</a>

                    @auth
                        <a class="nav-link nav-link-pill" href="{{ route('dashboard') }}">Dashboard</a>
                    @endauth
                </nav>

                <div class="flex shrink-0 items-center gap-3">
                    <a href="{{ route('contact') }}" class="hidden lg:inline-flex header-cta magnetic-card">
                        Request Consultation
                    </a>

                    <button
                        type="button"
                        @click="mobileOpen = true"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/20 bg-white/10 text-white transition hover:bg-white/15 lg:hidden"
                        aria-label="Open mobile navigation menu"
                    >
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="mobileOpen" class="lg:hidden" style="display:none">
        <div class="fixed inset-0 z-[90] bg-black/60 backdrop-blur-sm" @click="mobileOpen = false"></div>

        <aside
            class="fixed right-0 top-0 z-[100] h-screen w-[88%] max-w-sm overflow-y-auto bg-white shadow-2xl"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            aria-label="Mobile navigation"
        >
            <div class="p-5 text-white site-header">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex min-w-0 items-center gap-3">
                        <img
                            src="{{ asset('assets/images/logo.jpg') }}"
                            alt="{{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }} logo"
                            class="h-12 w-12 shrink-0 rounded-xl bg-white object-contain p-1"
                        >
                        <div class="min-w-0">
                            <div class="truncate font-bold">{{ $settings['company_name'] ?? 'NINGBO PASAFEITE' }}</div>
                            <div class="truncate text-xs text-white/70">{{ $settings['company_tagline'] ?? 'IMPORT AND EXPORT CO, LTD' }}</div>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 text-2xl transition hover:bg-white/15"
                        @click="mobileOpen = false"
                        aria-label="Close mobile navigation menu"
                    >
                        ×
                    </button>
                </div>
            </div>

            <div class="p-5">
                <nav class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm" aria-label="Mobile primary navigation">
                    <a class="mobile-menu-row {{ request()->routeIs('home') ? 'mobile-menu-row-active' : '' }}" href="{{ route('home') }}">Home</a>
                    <a class="mobile-menu-row {{ request()->routeIs('about') ? 'mobile-menu-row-active' : '' }}" href="{{ route('about') }}">About</a>

                    <div class="border-t border-slate-200">
                        <div class="flex items-center">
                            <a href="{{ route('products.index') }}" class="mobile-menu-row flex-1 border-t-0 {{ request()->routeIs('products.*') ? 'mobile-menu-row-active' : '' }}">
                                Products
                            </a>

                            <button
                                type="button"
                                @click="mobileProductsOpen = !mobileProductsOpen"
                                class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl transition hover:bg-slate-100"
                                style="color:#004D80"
                                aria-label="Toggle product categories"
                                :aria-expanded="mobileProductsOpen ? 'true' : 'false'"
                            >
                                <svg class="h-5 w-5 transition-transform duration-200" :class="mobileProductsOpen ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                                </svg>
                            </button>
                        </div>

                        <div
                            x-show="mobileProductsOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="border-t border-slate-200 bg-slate-50 px-3 py-2"
                            style="display:none"
                        >
                            <div class="divide-y divide-slate-200">
                                @foreach ($topCategories as $category)
                                    <a
                                        href="{{ route('products.category', $category->slug) }}"
                                        class="flex items-center justify-between gap-3 px-3 py-3 text-sm font-semibold transition hover:bg-white"
                                        style="color:#004D80"
                                    >
                                        <span>{{ $category->name }}</span>
                                        <svg class="h-4 w-4 shrink-0 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a class="mobile-menu-row {{ request()->routeIs('services') ? 'mobile-menu-row-active' : '' }}" href="{{ route('services') }}">Services</a>
                    <a class="mobile-menu-row {{ request()->routeIs('contact') ? 'mobile-menu-row-active' : '' }}" href="{{ route('contact') }}">Contact</a>

                    @auth
                        <a class="mobile-menu-row" href="{{ route('dashboard') }}">Dashboard</a>
                    @endauth
                </nav>

                <a href="{{ route('contact') }}" class="btn btn-primary mt-5 w-full">
                    Request Consultation
                </a>
            </div>
        </aside>
    </div>
</header>

<div class="h-28"></div>