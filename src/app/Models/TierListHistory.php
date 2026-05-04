<?php

namespace App\Models;

use App\Enums\Tier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TierListHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'card_id',
        'old_tier',
        'new_tier',
        'changed_by',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_tier' => Tier::class,
            'new_tier' => Tier::class,
            'created_at' => 'datetime',
        ];
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
