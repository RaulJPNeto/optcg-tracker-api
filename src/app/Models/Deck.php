<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leader_card_id',
        'name',
        'description',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'leader_card_id');
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'deck_cards')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function totalCards(): int
    {
        return $this->cards->sum('pivot.quantity');
    }
}
