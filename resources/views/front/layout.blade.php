<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $siteName = $settings['company_name'] ?? config('app.name', 'NPCO Limited');
        $pageTitle = trim($__env->yieldContent('title', $siteName));
        $seoTitle = $pageTitle === $siteName ? $siteName : $pageTitle . ' | ' . $siteName;

        $seoDescription = trim($__env->yieldContent(
            'meta_description',
            'NPCO Limited delivers industrial sourcing, engineering equipment, automation products, technical coordination, and reliable supply solutions from China to global markets.'
        ));

        $seoImage = trim($__env->yieldContent('meta_image', asset('assets/images/logo.jpg')));
        $canonicalUrl = trim($__env->yieldContent('canonical', url()->current()));
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta name="theme-color" content="#015ea4">
    <meta name="format-detection" content="telephone=no">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:site_name" content="{{ $siteName }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/logo.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.jpg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "{{ $siteName }}",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('assets/images/logo.jpg') }}",
            "email": "{{ $settings['company_email'] ?? '' }}",
            "telephone": "{{ $settings['company_phone'] ?? '' }}",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{ $settings['company_address'] ?? '' }}",
                "addressLocality": "{{ $settings['company_city'] ?? '' }}",
                "addressCountry": "{{ $settings['company_country'] ?? '' }}"
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-slate-900 selection:bg-[#015ea4] selection:text-white">
    <!-- <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-[#015ea4]/10 blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 h-[32rem] w-[32rem] rounded-full bg-[#711726]/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-80 w-80 rounded-full bg-slate-300/30 blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.035]" style="background-image: linear-gradient(#0f172a 1px, transparent 1px), linear-gradient(90deg, #0f172a 1px, transparent 1px); background-size: 42px 42px;"></div>
    </div> -->

    <div class="min-h-screen flex flex-col overflow-hidden">
        @include('front.partials.header')

        <main class="flex-1 relative">
            @if (session('success'))
                <div class="container-max pt-6 relative z-20" data-reveal>
                    <div class="rounded-2xl border border-[#015ea4]/20 bg-white/80 px-5 py-4 text-[#015ea4] shadow-lg shadow-slate-900/5 backdrop-blur-xl">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        @include('front.partials.footer')
        @stack('schema')
    </div>
    <div class="fixed bottom-5 right-5 z-50 flex flex-col items-center gap-2.5">
    
    <!-- WhatsApp -->
    <a
    href="https://wa.me/8615558357662"
    target="_blank"
    class="flex h-11 w-11 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl transition hover:-translate-y-1 hover:scale-105"
>
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="white">
    <path d="M20.52 3.48A11.91 11.91 0 0012.05 0C5.42 0 .04 5.38.04 12c0 2.12.55 4.19 1.6 6.02L0 24l6.16-1.61A11.94 11.94 0 0012.05 24c6.63 0 12.01-5.38 12.01-12 0-3.2-1.25-6.2-3.54-8.52zM12.05 21.82c-1.88 0-3.73-.5-5.35-1.45l-.38-.22-3.65.96.97-3.55-.25-.36A9.82 9.82 0 012.23 12c0-5.4 4.4-9.8 9.82-9.8s9.82 4.4 9.82 9.8-4.4 9.82-9.82 9.82zm5.4-7.36c-.3-.15-1.78-.88-2.06-.98-.27-.1-.47-.15-.66.15-.2.3-.76.98-.94 1.18-.17.2-.35.23-.65.08-.3-.15-1.27-.47-2.42-1.5-.9-.8-1.5-1.8-1.68-2.1-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.53.15-.18.2-.3.3-.5.1-.2.05-.38-.02-.53-.08-.15-.66-1.6-.9-2.2-.23-.57-.47-.5-.66-.5h-.56c-.2 0-.53.08-.8.38-.27.3-1.05 1.02-1.05 2.5 0 1.47 1.08 2.9 1.23 3.1.15.2 2.13 3.26 5.16 4.57.72.31 1.28.5 1.72.64.72.23 1.37.2 1.88.12.57-.08 1.78-.73 2.03-1.44.25-.7.25-1.3.18-1.44-.07-.13-.26-.2-.55-.35z"/>
</svg>
</a>

    <!-- Contact -->
    <a
        href="{{ route('contact') }}"
        class="flex h-11 w-11 items-center justify-center rounded-full bg-[#015ea4] text-white shadow-xl transition hover:-translate-y-1 hover:scale-105"
    >
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a8.5 8.5 0 0 1-8.5 8.5 9.6 9.6 0 0 1-3.5-.66L3 21l1.2-4.3A8.5 8.5 0 1 1 21 12Z"/>
        </svg>
    </a>

    <!-- Back to Top -->
    <button
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="flex h-11 w-11 items-center justify-center rounded-full shadow-xl transition hover:-translate-y-1 hover:scale-105"
    style="background:#BDBDBD2B"
>
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 11l6-6 6 6"/>
    </svg>
</button>

</div>
</body>
</html>