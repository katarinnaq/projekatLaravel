<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'porudzbina_id',
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
            'porudzbina_id' => 'integer',
            'proizvod_id' => 'integer',
            'cena' => 'decimal:2',
        ];
    }

    public function porudzbina(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function proizvod(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
