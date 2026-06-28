<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings['company_name'] ?? config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/logo.jpg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white font-sans text-slate-900 antialiased">

<main class="relative min-h-screen overflow-hidden">

    <!-- Background clean -->
    <div class="absolute inset-0 bg-white"></div>

    <!-- Soft light gradients (احترافي بدون إزعاج) -->
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-40 -left-40 h-[30rem] w-[30rem] rounded-full bg-[#015ea4]/5 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-[30rem] w-[30rem] rounded-full bg-[#004D80]/5 blur-3xl"></div>
    </div>

    <div class="relative grid min-h-screen lg:grid-cols-12">

        <!-- Left Side (Brand Panel) -->
        <section class="hidden lg:flex lg:col-span-6 items-center px-16">
            <div class="max-w-xl">

                <div class="inline-flex items-center gap-2 rounded-full bg-[#015ea4]/10 px-4 py-2 text-xs font-black tracking-[0.22em] text-[#015ea4]">
                    ADMIN DASHBOARD
                </div>

                <h1 class="mt-6 text-5xl font-black leading-[1.05] tracking-[-0.04em] text-slate-950">
                    Manage your platform with clarity and control.
                </h1>

                <p class="mt-5 text-lg leading-relaxed text-slate-600">
                    A structured workspace for managing industrial products, customer inquiries, services, and operational content efficiently.
                </p>

                <!-- subtle divider -->
                <div class="mt-8 h-[1px] w-24 bg-slate-200"></div>

                <!-- extra hint -->
                <p class="mt-6 text-sm text-slate-400">
                    Secure • Organized • Scalable
                </p>

            </div>
        </section>

        <!-- Right Side (Login Card) -->
        <section class="flex min-h-screen items-center justify-center px-5 py-10 lg:col-span-6">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </section>

    </div>

</main>

</body>
</html>