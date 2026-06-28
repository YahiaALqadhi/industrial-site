<x-guest-layout>
    <div class="w-full max-w-md">

        <div class="rounded-[2rem] border border-slate-200 bg-white/95 p-10 shadow-2xl backdrop-blur">

            <!-- Header -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <img
                            src="{{ asset('assets/images/logo.jpg') }}"
                            alt="Company Logo"
                            class="h-12 w-12 object-contain"
                        >
                    </div>
                </a>

                <h1 class="mt-6 text-3xl font-black text-slate-950">
                    Reset Password
                </h1>

                <p class="mt-3 text-sm leading-relaxed text-slate-500">
                    Enter your email and we’ll send you a secure reset link.
                </p>

                @if(!empty($settings['company_name']))
                    <div class="mt-2 text-sm font-bold text-[#015EA4]">
                        {{ $settings['company_name'] }}
                    </div>
                @endif
            </div>

            <!-- Status -->
            <x-auth-session-status
                class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                :status="session('status')"
            />

            <!-- Form -->
            <form method="POST"
                  action="{{ route('password.email') }}"
                  class="mt-8 space-y-6"
                  x-data="{ loading: false }"
                  @submit="loading = true">

                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email"
                                   :value="__('Email Address')"
                                   class="text-sm font-bold text-slate-800" />

                    <x-text-input
                        id="email"
                        class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3.5 shadow-sm focus:border-[#015EA4] focus:ring-[#015EA4]"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        placeholder="admin@example.com"
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl px-5 py-3.5 text-sm font-bold text-white shadow-lg transition disabled:opacity-70 disabled:cursor-not-allowed"
                    style="background: linear-gradient(135deg, #015EA4 0%, #004D80 100%);"
                    :disabled="loading"
                >
                    <span x-show="!loading">Send Reset Link</span>
                    <span x-show="loading" style="display:none">Sending...</span>
                </button>

                <!-- Back -->
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}"
                       class="text-sm font-semibold text-slate-500 transition hover:text-[#015EA4]">
                        ← Back to login
                    </a>
                </div>

            </form>

        </div>

    </div>
</x-guest-layout>