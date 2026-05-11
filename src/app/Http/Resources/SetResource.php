<?php

namespace App\Http\Resources;

use App\Models\CardSet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CardSet */
class SetResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'release_date_jp' => $this->release_date_jp,
            'release_date_global' => $this->release_date_global,
            'total_cards' => $this->total_cards,
            'created_at' => $this->created_at,
        ];
    }
}
