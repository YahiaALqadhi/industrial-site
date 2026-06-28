<x-guest-layout>
    <div class="w-full max-w-md">
        <div class="rounded-[2rem] border border-slate-200 bg-white/95 p-10 shadow-2xl backdrop-blur">
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="Company Logo" class="h-12 w-12 object-contain">
                    </div>
                </a>

                <h1 class="mt-6 text-3xl font-black text-slate-950">
                    Create Admin Account
                </h1>

                <p class="mt-3 text-sm leading-relaxed text-slate-500">
                    Register a secure account to access the website dashboard.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-sm font-bold text-slate-800" />
                    <x-text-input
                        id="name"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3.5 shadow-sm focus:border-[#015EA4] focus:ring-[#015EA4]"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Full name"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-sm font-bold text-slate-800" />
                    <x-text-input
                        id="email"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3.5 shadow-sm focus:border-[#015EA4] focus:ring-[#015EA4]"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                        placeholder="admin@example.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-bold text-slate-800" />
                    <x-text-input
                        id="password"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3.5 shadow-sm focus:border-[#015EA4] focus:ring-[#015EA4]"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Create password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-bold text-slate-800" />
                    <x-text-input
                        id="password_confirmation"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3.5 shadow-sm focus:border-[#015EA4] focus:ring-[#015EA4]"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm password"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl bg-[#015ea4] px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-[#015ea4]/20 transition hover:-translate-y-0.5 hover:bg-[#004D80] hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-70"
                    :disabled="loading"
                >
                    <span x-show="!loading">Register</span>
                    <span x-show="loading" style="display:none">Creating account...</span>
                </button>

                <div class="border-t border-slate-200 pt-5 text-center">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 transition hover:text-[#015ea4]">
                        Already registered? Log in
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>