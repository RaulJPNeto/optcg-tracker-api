<?php

namespace App\Services;

use App\Models\CardSet;

class SetService
{
    public function create(array $data)
    {
        return CardSet::create($data);
    }

    public function update(CardSet $set, array $data)
    {
        $set->update($data);

        return $set->fresh();
    }

    public function delete(CardSet $set)
    {
        $set->delete();
    }
}
