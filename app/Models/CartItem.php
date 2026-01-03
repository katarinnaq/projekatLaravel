<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'korpa_id',
        'proizvod_id',
        'kolicina',
        'cena',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'korpa_id' => 'integer',
            'proizvod_id' => 'integer',
            'cena' => 'decimal:2',
        ];
    }

    public function korpa(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function proizvod(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
