<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
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

    public function view(User $user, Payment $payment): bool
    {
        return $payment->user_id === $user->id || optional($payment->apartment)->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isSyndic();
    }

    public function update(User $user, Payment $payment): bool
    {
        return $user->isSyndic();
    }

    public function delete(User $user, Payment $payment): bool
    {
        return $user->isSyndic();
    }
}
