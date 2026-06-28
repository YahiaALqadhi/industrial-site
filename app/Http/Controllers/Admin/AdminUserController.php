<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $role = $request->query('role');
        if (!empty($role)) {
            $query->where('role', $role);
        }

        $isActive = $request->query('is_active');
        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }

        $users = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $roles = [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_ADMIN,
            User::ROLE_SUPPORT,
        ];

        return view('admin.users.index', compact('users', 'search', 'role', 'isActive', 'roles'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        $roles = [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_ADMIN,
            User::ROLE_SUPPORT,
        ];

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'is_active' => (bool) ($data['is_active'] ?? false),
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users.edit', $user)->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_ADMIN,
            User::ROLE_SUPPORT,
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        $safetyError = $this->getLastSuperAdminSafetyError(
            targetUser: $user,
            newRole: $data['role'],
            newIsActive: (bool) ($data['is_active'] ?? false)
        );

        if ($safetyError !== null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['role' => $safetyError]);
        }

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'is_active' => (bool) ($data['is_active'] ?? false),
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $user->update($update);

        return redirect()->route('admin.users.edit', $user)->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($this->isLastSuperAdmin($user)) {
            return redirect()->route('admin.users.index')->withErrors([
                'delete' => 'You cannot delete the last remaining super admin.',
            ]);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    private function isLastSuperAdmin(User $user): bool
    {
        if (!$user->isSuperAdmin()) {
            return false;
        }

        $count = User::query()->where('role', User::ROLE_SUPER_ADMIN)->count();

        return $count <= 1;
    }

    private function getLastSuperAdminSafetyError(User $targetUser, string $newRole, bool $newIsActive): ?string
    {
        if (!$targetUser->isSuperAdmin()) {
            return null;
        }

        if (!$this->isLastSuperAdmin($targetUser)) {
            return null;
        }

        if ($newRole !== User::ROLE_SUPER_ADMIN) {
            return 'You cannot demote the last remaining super admin.';
        }

        if ($newIsActive === false) {
            return 'You cannot disable the last remaining super admin.';
        }

        return null;
    }
}
