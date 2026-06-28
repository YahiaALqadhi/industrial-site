<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.jpg') }}">

    <title>@yield('title', 'Admin') — {{ config('app.name', 'Industrial Site') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
<div
    x-data="{ sidebarOpen: false, sidebarCollapsed: false, userOpen: false }"
    class="min-h-screen"
>
    <div
        class="lg:hidden"
        x-show="sidebarOpen"
        x-transition.opacity
        style="display:none"
    >
        <div class="fixed inset-0 z-40 bg-slate-950/55 backdrop-blur-sm" @click="sidebarOpen = false"></div>
    </div>

    <aside
        class="fixed inset-y-0 left-0 z-50 flex flex-col overflow-hidden bg-[#061421] text-white shadow-2xl transition-all duration-300 ease-out"
        :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            sidebarCollapsed ? 'lg:w-20' : 'lg:w-72',
            'w-72 lg:translate-x-0'
        ]"
    >
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-[#015ea4]/25 blur-3xl"></div>
            <div class="absolute -bottom-28 -right-28 h-80 w-80 rounded-full bg-[#711726]/20 blur-3xl"></div>
        </div>

        <div
            class="relative h-20 shrink-0 flex items-center border-b border-white/10"
            :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-between px-4'"
        >
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex min-w-0 items-center gap-3"
                :class="sidebarCollapsed ? 'justify-center' : ''"
            >
                <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-white/15 bg-white shadow-lg">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" class="h-9 w-9 rounded-xl object-contain">
                </span>

                <div class="min-w-0 leading-tight" x-show="!sidebarCollapsed" x-transition.opacity.duration.150ms>
                    <div class="truncate text-sm font-black tracking-wide">Admin Panel</div>
                    <div class="mt-1 truncate text-xs text-white/60">NINGBO PASAFEITE</div>
                </div>
            </a>

            <button
                class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 transition hover:bg-white/10"
                @click="sidebarOpen = false"
                aria-label="Close sidebar"
                type="button"
            >
                <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6l-12 12" />
                </svg>
            </button>
        </div>

        <div
    class="relative flex-1 overflow-y-auto overscroll-contain admin-scrollbar"
    :class="sidebarCollapsed ? 'lg:px-0' : ''"
    data-lenis-prevent
>
    @include('admin.partials.sidebar')
</div>

        <div class="relative shrink-0 border-t border-white/10 p-4">
            <div class="flex items-center gap-3" :class="sidebarCollapsed ? 'justify-center' : ''">
                @if(auth()->user()->avatar)
                    <img
                        src="{{ asset('storage/' . auth()->user()->avatar) }}"
                        alt="Profile Photo"
                        class="h-11 w-11 shrink-0 rounded-2xl border border-white/15 object-cover"
                    >
                @else
                    <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#015EA4] font-black text-white shadow-lg shadow-[#015ea4]/20">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="min-w-0" x-show="!sidebarCollapsed" x-transition.opacity.duration.150ms>
                    <div class="text-xs text-white/45">Logged in as</div>
                    <div class="mt-1 truncate text-sm font-black">{{ auth()->user()->name }}</div>
                    <div class="mt-1 truncate text-xs text-white/55">{{ auth()->user()->email }}</div>
                </div>
            </div>
        </div>
    </aside>

    <div :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-72'" class="transition-all duration-300">
        <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl">
            <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6">
                <div class="flex min-w-0 items-center gap-3">
                    <button
                        class="lg:hidden inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:bg-slate-50"
                        @click="sidebarOpen = true"
                        aria-label="Open sidebar"
                        type="button"
                    >
                        <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <button
                        class="hidden lg:inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:bg-slate-50"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        aria-label="Toggle sidebar"
                        type="button"
                    >
                        <svg
                            class="h-5 w-5 text-slate-700 transition-transform duration-300"
                            :class="sidebarCollapsed ? 'rotate-180' : ''"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <div class="truncate text-base font-black text-slate-950">
                            @yield('page_title', 'Dashboard')
                        </div>
                        <div class="mt-0.5 truncate text-xs font-medium text-slate-500">
                            @yield('page_subtitle', 'Manage catalog, inquiries, and settings')
                        </div>
                    </div>
                </div>

                <div class="relative shrink-0">
                    <button
                        class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold shadow-sm transition hover:bg-slate-50"
                        @click="userOpen = !userOpen"
                        @keydown.escape.window="userOpen = false"
                        type="button"
                    >
                        <span class="hidden max-w-[140px] truncate sm:inline">{{ auth()->user()->name }}</span>

                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Photo" class="h-9 w-9 rounded-xl border border-slate-200 object-cover">
                        @else
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[#004D80] font-black text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        @endif

                        <svg class="h-4 w-4 text-slate-600 transition-transform" :class="userOpen ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                        </svg>
                    </button>

                    <div
                        x-show="userOpen"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-120"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        @click.outside="userOpen = false"
                        class="absolute right-0 mt-2 w-60 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/10"
                        style="display:none"
                    >
                        <div class="px-4 py-3">
                            <div class="truncate text-sm font-black text-slate-900">{{ auth()->user()->name }}</div>
                            <div class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</div>
                            <div class="mt-2 inline-flex rounded-full bg-[#015ea4]/10 px-2.5 py-1 text-xs font-black text-[#015ea4]">
                                Role: {{ auth()->user()->role }}
                            </div>
                        </div>

                        <div class="border-t border-slate-200"></div>

                        <a class="block px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-[#015ea4]" href="{{ route('profile.edit') }}">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full px-4 py-3 text-left text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-[#711726]" type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-6">
            @if (session('success'))
                <div class="mb-4 rounded-2xl border border-[#015ea4]/20 bg-white px-4 py-3 text-sm shadow-sm">
                    <div class="font-black text-[#015ea4]">Success</div>
                    <div class="mt-1 text-slate-700">{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-2xl border border-[#711726]/20 bg-white px-4 py-3 text-sm shadow-sm">
                    <div class="font-black text-[#711726]">Please fix the highlighted fields</div>
                    <ul class="mt-2 ml-5 list-disc text-slate-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>