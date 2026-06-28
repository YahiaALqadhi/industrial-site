@extends('admin.layout')

@section('title', 'My Profile')
@section('page_title', 'My Profile')
@section('page_subtitle', 'Manage your account information and password')

@section('content')
<div class="grid gap-6 lg:grid-cols-12">
    <div class="lg:col-span-4">
        <div class="sticky top-24 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="h-16 w-16 rounded-2xl object-cover">
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#004D80] text-2xl font-black text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="min-w-0">
                        <div class="truncate text-lg font-black text-slate-950">{{ auth()->user()->name }}</div>
                        <div class="truncate text-sm text-slate-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 p-6">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase tracking-wider text-slate-400">Role</div>
                    <div class="mt-1 text-sm font-black text-[#015ea4]">{{ auth()->user()->role ?? 'Admin' }}</div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase tracking-wider text-slate-400">Status</div>
                    <div class="mt-2">
                        @if(auth()->user()->is_active ?? true)
                            <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">Active</span>
                        @else
                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-black text-red-600">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Profile Information</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Account details</h2>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid gap-5 p-6 md:grid-cols-2">
                @csrf
                @method('PATCH')

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Full Name</label>
                    <input class="field mt-2" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Email Address</label>
                    <input class="field mt-2" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Profile Photo</label>
                    <input class="field mt-2" type="file" name="avatar" accept="image/*">
                    <x-input-error :messages="$errors->get('avatar')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">Security</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Change password</h2>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="grid gap-5 p-6 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div class="md:col-span-2">
                    <label class="text-sm font-black text-slate-800">Current Password</label>
                    <input class="field mt-2" type="password" name="current_password" autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <div class="mt-2 text-sm text-[#711726]">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">New Password</label>
                    <input class="field mt-2" type="password" name="password" autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <div class="mt-2 text-sm text-[#711726]">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Confirm New Password</label>
                    <input class="field mt-2" type="password" name="password_confirmation" autocomplete="new-password">
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection