<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isSupport();
    }

    public function view(User $user, Inquiry $inquiry): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isSupport();
    }

    public function updateStatus(User $user, Inquiry $inquiry): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isSupport();
    }

    public function reply(User $user, Inquiry $inquiry): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin() || $user->isSupport();
    }

    public function delete(User $user, Inquiry $inquiry): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }
}
