<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Set\IndexSetRequest;
use App\Http\Requests\Set\StoreSetRequest;
use App\Http\Requests\Set\UpdateSetRequest;
use App\Http\Resources\SetResource;
use App\Models\CardSet;
use App\Queries\SetQuery;
use App\Services\SetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SetController extends Controller
{
    public function __construct(
        protected SetService $setService,
        protected SetQuery $setQuery,
    ) {}

    public function index(IndexSetRequest $request): AnonymousResourceCollection
    {
        $sets = $this->setQuery
            ->handle($request->validated())
            ->latest()
            ->paginate(15);

        return SetResource::collection($sets);
    }

    public function show(CardSet $set): SetResource
    {
        return new SetResource($set);
    }

    public function store(StoreSetRequest $request): JsonResponse
    {
        $this->authorize('create', CardSet::class);

        $set = $this->setService->create($request->validated());

        return response()->json(
            new SetResource($set),
            201
        );
    }

    public function update(UpdateSetRequest $request, CardSet $set): SetResource
    {
        $this->authorize('update', $set);

        $set = $this->setService->update($set, $request->validated());

        return new SetResource($set);
    }

    public function destroy(CardSet $set): JsonResponse
    {
        $this->authorize('delete', $set);

        $this->setService->delete($set);

        return response()->json(null, 204);
    }
}
