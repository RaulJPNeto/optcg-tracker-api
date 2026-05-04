<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardSet extends Model
{
    use HasFactory;

    protected $table = 'sets';

    protected $fillable = [
        'code',
        'name',
        'release_date_jp',
        'release_date_global',
        'total_cards',
    ];

    protected function casts(): array
    {
        return [
            'release_date_jp' => 'date',
            'release_date_global' => 'date',
        ];
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'set_id');
    }
}
