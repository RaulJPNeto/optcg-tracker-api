<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Invitation\StoreInvitationRequest;
use App\Http\Resources\InvitationResource;
use App\Models\Invitation;
use App\Services\InvitationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class InvitationController
{
    use AuthorizesRequests;

    public function __construct(protected InvitationService $invitationService) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Invitation::class);

        $invitations = Invitation::with('invitedBy')
            ->latest()
            ->paginate(15);

        return response()->json(InvitationResource::collection($invitations));
    }

    public function store(StoreInvitationRequest $request): JsonResponse
    {
        $this->authorize('create', Invitation::class);

        $invitation = $this->invitationService->create(
            $request->validated(),
            $request->user()
        );

        return response()->json(new InvitationResource($invitation), 201);
    }

    public function show(string $token): JsonResponse
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        return response()->json([
            'email' => $invitation->email,
            'is_valid' => $invitation->isValid(),
            'expires_at' => $invitation->expires_at,
        ]);
    }
}
