<?php

namespace App\Models;

use App\Enums\Tier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TierListEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'tier',
        'notes',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'tier' => Tier::class,
        ];
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
