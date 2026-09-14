<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;

class ComplaintPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSyndic()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Complaint $complaint): bool
    {
        return $complaint->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isResident();
    }

    public function reply(User $user, Complaint $complaint): bool
    {
        return $user->isSyndic() || $complaint->user_id === $user->id;
    }

    public function delete(User $user, Complaint $complaint): bool
    {
        return $user->isSyndic();
    }
}
