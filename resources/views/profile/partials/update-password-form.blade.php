<section>
    <header>
        <div class="section-kicker">Security</div>

        <h2 class="mt-2 text-xl font-black text-slate-950">
            Change password
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Use a strong password to protect your account.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 grid gap-5">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password" class="text-sm font-black text-slate-800">
                Current Password
            </label>

            <input
                id="current_password"
                name="current_password"
                type="password"
                class="field mt-2"
                autocomplete="current-password"
            />

            @error('current_password', 'updatePassword')
                <div class="mt-2 text-sm text-[#711726]">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password" class="text-sm font-black text-slate-800">
                New Password
            </label>

            <input
                id="password"
                name="password"
                type="password"
                class="field mt-2"
                autocomplete="new-password"
            />

            @error('password', 'updatePassword')
                <div class="mt-2 text-sm text-[#711726]">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="text-sm font-black text-slate-800">
                Confirm New Password
            </label>

            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="field mt-2"
                autocomplete="new-password"
            />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600"
                >
                    Password updated.
                </p>
            @endif
        </div>
    </form>
</section>