@extends('admin.layout')

@section('title', 'Create User')
@section('page_title', 'Create User')
@section('page_subtitle', 'Add a new admin user')

@section('content')
<form method="POST" action="{{ route('admin.users.store') }}" class="grid gap-6 lg:grid-cols-12">
    @csrf

    <div class="lg:col-span-8">
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="section-kicker">User Details</div>
                <h2 class="mt-2 text-xl font-black text-slate-950">Create admin account</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Create an admin account and assign a dashboard role.
                </p>
            </div>

            <div class="grid gap-5 p-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-black text-slate-800">Name</label>
                    <input class="field mt-2" name="name" value="{{ old('name') }}" required placeholder="Full name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Email</label>
                    <input class="field mt-2" type="email" name="email" value="{{ old('email') }}" required placeholder="admin@example.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Role</label>
                    <select class="field mt-2" name="role" required>
                        @foreach ($roles as $r)
                            <option value="{{ $r }}" @selected(old('role', 'admin') === $r)>
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
                        @checked(old('is_active', true))
                    >
                    <label for="is_active" class="text-sm font-black text-slate-800">Active user</label>
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Password</label>
                    <input class="field mt-2" type="password" name="password" required placeholder="Create password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-[#711726]" />
                </div>

                <div>
                    <label class="text-sm font-black text-slate-800">Confirm password</label>
                    <input class="field mt-2" type="password" name="password_confirmation" required placeholder="Confirm password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-[#711726]" />
                </div>
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Back</a>
                <button class="btn btn-primary" type="submit">Create User</button>
            </div>
        </div>
    </div>

    <div class="lg:col-span-4">
        <div class="sticky top-24 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
            <div class="section-kicker">Access Notes</div>

            <div class="mt-5 grid gap-3 text-sm text-slate-600">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 font-semibold">
                    Super admin can manage users and system-level sections.
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 font-semibold">
                    Admin users can manage content based on your policies.
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 font-semibold">
                    Disabled users cannot access the dashboard.
                </div>
            </div>
        </div>
    </div>
</form>
@endsection