<section class="space-y-6">
    <header>
        <div class="section-kicker" style="color:#711726">Danger Zone</div>

        <h2 class="mt-2 text-xl font-black text-slate-950">
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Once your account is deleted, all data will be permanently removed. This action cannot be undone.
        </p>
    </header>

    <div class="rounded-2xl border p-5" style="background:rgba(113,23,38,.05); border-color:rgba(113,23,38,.15)">
        <button
            x-data
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
            style="background:rgba(113,23,38,.12); color:#711726"
        >
            Delete Account
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-black text-slate-950">
                Confirm account deletion
            </h2>

            <p class="text-sm text-slate-600">
                Please enter your password to confirm deletion. This action is irreversible.
            </p>

            <div>
                <label for="password" class="text-sm font-black text-slate-800">Password</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="field mt-2"
                    placeholder="Enter your password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-[#711726]" />
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="btn btn-outline"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                    style="background:#dc2626; color:#fff"
                >
                    Delete Permanently
                </button>
            </div>
        </form>
    </x-modal>
</section>