<x-guest-layout>
    <div class="w-full max-w-md">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-2xl shadow-slate-900/10 md:p-10">
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl border border-slate-200 bg-white shadow-lg">
                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="Company Logo" class="h-12 w-12 object-contain">
                    </div>
                </a>

                <div class="mt-6 text-xs font-black uppercase tracking-[0.22em] text-[#015ea4]">
                    Admin Workspace
                </div>

                <h1 class="mt-3 text-3xl font-black tracking-tight text-slate-950">
                    Welcome back
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Sign in to manage inquiries, products, services, and website content.
                </p>

                @if(!empty($settings['company_name']))
                    <div class="mt-4 inline-flex rounded-full bg-[#015ea4]/10 px-4 py-2 text-xs font-black uppercase tracking-wide text-[#015ea4]">
                        {{ $settings['company_name'] }}
                    </div>
                @endif
            </div>

            <x-auth-session-status
                class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                :status="session('status')"
            />

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-sm font-black text-slate-800" />
                    <x-text-input
                        id="email"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3.5 shadow-sm transition focus:border-[#015EA4] focus:ring-[#015EA4]"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="admin@example.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <div class="flex items-center justify-between gap-4">
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-black text-slate-800" />

                        @if (Route::has('password.request'))
                            <a class="text-sm font-bold text-[#015ea4] transition hover:text-[#004D80]" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <x-text-input
                        id="password"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3.5 shadow-sm transition focus:border-[#015EA4] focus:ring-[#015EA4]"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <label for="remember_me" class="inline-flex cursor-pointer items-center gap-3">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="h-4 w-4 rounded border-slate-300 text-[#015EA4] shadow-sm focus:ring-[#015EA4]"
                        name="remember"
                    >
                    <span class="text-sm font-medium text-slate-600">Remember me</span>
                </label>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl bg-[#015ea4] px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-[#015ea4]/20 transition hover:-translate-y-0.5 hover:bg-[#004D80] hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-70"
                    :disabled="loading"
                >
                    <span x-show="!loading">Log in</span>
                    <span x-show="loading" style="display:none">Signing in...</span>
                </button>
            </form>

            <div class="mt-6 border-t border-slate-200 pt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm font-bold text-slate-500 transition hover:text-[#015ea4]">
                    ← Back to website
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>