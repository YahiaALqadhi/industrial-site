@extends('admin.layout')

@section('title', 'Edit User')
@section('page_title', 'Edit User')
@section('page_subtitle', 'Update role and access')

@section('content')
@php
    $superAdminsCount = \App\Models\User::query()->where('role', \App\Models\User::ROLE_SUPER_ADMIN)->count();
    $isLastSuperAdmin = $user->isSuperAdmin() && $superAdminsCount <= 1;
@endphp

<div class="grid gap-6 lg:grid-cols-12">
    <div class="space-y-6 lg:col-span-8">
        @if ($isLastSuperAdmin)
            <div class="rounded-2xl border border-[#015ea4]/20 bg-[#015ea4]/5 px-4 py-3 text-sm text-[#004D80]">
                This user is the <span class="font-black">last remaining super admin</span>. You cannot demote, disable, or delete this account.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="section-kicker">User Details</div>
                    <h2 class="mt-2 text-xl font-black text-slate-950">Update account</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Update account information, role, password, and access status.
                    </p>
                </div>

                <div class="grid gap-5 p-6 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-black text-slate-800">Name</label>
                        <input class="field mt-2" name="name" value="{{ old('name', $user->name) }}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div>
                        <label class="text-sm font-black text-slate-800">Email</label>
                        <input class="field mt-2" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div>
                        <label class="text-sm font-black text-slate-800">Role</label>
                        <select class="field mt-2" name="role" required @disabled($isLastSuperAdmin)>
                            @foreach ($roles as $r)
                                <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>
                                    {{ ucfirst(str_replace('_', ' ', $r)) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <input
                            id="is_active"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="h-5 w-5 rounded border-slate-300 text-[#015ea4] focus:ring-[#015ea4]"
                            @checked(old('is_active', $user->is_active))
                            @disabled($isLastSuperAdmin)
                        >
                        <label for="is_active" class="text-sm font-black text-slate-800">Active user</label>
                    </div>

                    <div>
                        <label class="text-sm font-black text-slate-800">New password</label>
                        <input class="field mt-2" type="password" name="password" placeholder="Leave empty to keep current">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-[#711726]" />
                    </div>

                    <div>
                        <label class="text-sm font-black text-slate-800">Confirm new password</label>
                        <input class="field mt-2" type="password" name="password_confirmation" placeholder="Confirm password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-[#711726]" />
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Back</a>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <div class="sticky top-24 space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="section-kicker">Account Summary</div>

                <div class="mt-5 grid gap-3 text-sm text-slate-600">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase tracking-wider text-slate-400">Name</div>
                        <div class="mt-1 font-black text-slate-950">{{ $user->name }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase tracking-wider text-slate-400">Role</div>
                        <div class="mt-1 font-black text-[#015ea4]">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase tracking-wider text-slate-400">Status</div>
                        <div class="mt-1 font-black {{ $user->is_active ? 'text-emerald-600' : 'text-slate-500' }}">
                            {{ $user->is_active ? 'Active' : 'Disabled' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-[#711726]/15 bg-white p-6 shadow-xl shadow-slate-900/5">
                <div class="text-xs font-black uppercase tracking-wider text-[#711726]">Danger zone</div>
                <p class="mt-3 text-sm leading-relaxed text-slate-600">
                    Delete this user account permanently. This action cannot be undone.
                </p>

                <form class="mt-5" method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
                    @csrf
                    @method('DELETE')

                    <button
                        class="inline-flex w-full items-center justify-center rounded-xl bg-[#711726]/10 px-5 py-3 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white disabled:cursor-not-allowed disabled:opacity-50"
                        type="submit"
                        @disabled($isLastSuperAdmin)
                    >
                        Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection