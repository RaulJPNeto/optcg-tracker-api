<?php

namespace App\Queries;

use App\Models\CardSet;

class SetQuery
{
    public function handle(array $filters)
    {
        $query = CardSet::query();

        $query->when(
            $filters['search'] ?? null,
            fn ($q) => $q->where('name', 'like', "%{$filters['search']}%")
        );

        return $query;
    }
}
