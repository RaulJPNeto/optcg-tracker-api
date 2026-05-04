<?php

namespace App\Models;

use App\Enums\CardAttribute;
use App\Enums\CardColor;
use App\Enums\CardType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'set_id',
        'code',
        'name',
        'type',
        'color',
        'cost',
        'power',
        'counter',
        'attribute',
        'effect',
        'image_url',
        'announced_at',
        'released_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'type' => CardType::class,
            'color' => CardColor::class,
            'attribute' => CardAttribute::class,
            'announced_at' => 'date',
            'released_at' => 'date',
        ];
    }

    public function set(): BelongsTo
    {
        return $this->belongsTo(CardSet::class, 'set_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tierEntry(): HasOne
    {
        return $this->hasOne(TierListEntry::class);
    }
}
