<?php

namespace App\Http\Resources;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Invitation */
class InvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'token' => $this->token,
            'is_valid' => $this->isValid(),
            'expires_at' => $this->expires_at,
            'used_at' => $this->used_at,
            'invited_by' => new UserResource($this->whenLoaded('invitedBy')),
            'created_at' => $this->created_at,
        ];
    }
}
