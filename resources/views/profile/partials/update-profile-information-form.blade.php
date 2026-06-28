<section>
    <header>
        <div class="section-kicker">Profile Information</div>

        <h2 class="mt-2 text-xl font-black text-slate-950">
            Account details
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Update your account name and email address.
        </p>
    </header>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 grid gap-5">
        @csrf
        @method('PATCH')

        <div>
            <label for="name" class="text-sm font-black text-slate-800">Name</label>
            <input id="name" name="name" type="text" class="field mt-2" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <x-input-error class="mt-2 text-sm text-[#711726]" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="text-sm font-black text-slate-800">Email</label>
            <input id="email" name="email" type="email" class="field mt-2" value="{{ old('email', $user->email) }}" required autocomplete="username">
            <x-input-error class="mt-2 text-sm text-[#711726]" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-2xl border border-[#711726]/15 bg-[#711726]/5 p-4 text-sm text-slate-700">
                    Your email address is unverified.

                    <button form="send-verification" class="font-black text-[#015ea4] hover:underline">
                        Re-send verification email
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-black text-emerald-600">
                            A new verification link has been sent.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600"
                >
                    Saved.
                </p>
            @endif
        </div>
    </form>
</section>