@extends('admin.layout')

@section('title', 'Admin Users')
@section('page_title', 'Admin Users')
@section('page_subtitle', 'Manage admin accounts and roles')

@section('content')
<div class="space-y-6">
    @if ($errors->has('delete'))
        <div class="rounded-2xl border border-[#711726]/20 bg-[#711726]/5 px-4 py-3 text-sm font-semibold text-[#711726]">
            {{ $errors->first('delete') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.users.index') }}"
          class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="section-kicker">User Filters</div>
                <h1 class="mt-3 text-2xl font-black text-slate-950">Admin users</h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                    Search accounts, filter by role/status, and manage admin access.
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary whitespace-nowrap">
                <span>+</span>
                <span>New User</span>
            </a>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-5">
                <label class="text-sm font-black text-slate-800">Search</label>
                <input class="field mt-2" name="q" value="{{ $search }}" placeholder="Search name or email">
            </div>

            <div class="lg:col-span-3">
                <label class="text-sm font-black text-slate-800">Role</label>
                <select class="field mt-2" name="role">
                    <option value="">All roles</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r }}" @selected((string) $role === (string) $r)>
                            {{ ucfirst(str_replace('_', ' ', $r)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2">
                <label class="text-sm font-black text-slate-800">Status</label>
                <select class="field mt-2" name="is_active">
                    <option value="">All statuses</option>
                    <option value="1" @selected((string) $isActive === '1')>Active</option>
                    <option value="0" @selected((string) $isActive === '0')>Disabled</option>
                </select>
            </div>

            <div class="flex gap-2 lg:col-span-2">
                <button class="btn btn-primary w-full" type="submit">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline w-full">Reset</a>
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
        <div class="border-b border-slate-200 px-6 py-5">
            <div class="text-lg font-black text-slate-950">Users list</div>
            <div class="mt-1 text-sm text-slate-500">Control dashboard users, roles, and access status.</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-black">User</th>
                        <th class="px-6 py-4 text-left font-black">Role</th>
                        <th class="px-6 py-4 text-left font-black">Status</th>
                        <th class="px-6 py-4 text-right font-black">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-950">{{ $user->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $user->email }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-[#015ea4]/10 px-3 py-1 text-xs font-black text-[#015ea4]">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @if ($user->is_active)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-500">
                                        Disabled
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="inline-flex rounded-xl bg-[#015ea4]/10 px-4 py-2 text-sm font-black text-[#015ea4] transition hover:bg-[#015ea4] hover:text-white">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="inline-flex rounded-xl bg-[#711726]/10 px-4 py-2 text-sm font-black text-[#711726] transition hover:bg-[#711726] hover:text-white" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="text-lg font-black text-slate-950">No users found</div>
                                    <p class="mt-2 text-sm text-slate-500">
                                        Add a new admin user or adjust the filters.
                                    </p>

                                    <a href="{{ route('admin.users.create') }}" class="mt-5 inline-flex btn btn-primary">
                                        New User
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection