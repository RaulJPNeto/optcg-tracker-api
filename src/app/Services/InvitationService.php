<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Str;

class InvitationService
{
    public function create(array $data, User $invitedBy): Invitation
    {
        return Invitation::create([
            'email' => $data['email'],
            'token' => Str::uuid(),
            'invited_by' => $invitedBy->id,
            'expires_at' => now()->addDays(7),
        ]);
    }
}
