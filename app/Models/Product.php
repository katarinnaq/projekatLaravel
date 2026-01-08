<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kategorija_id',
        'tip_vode',
        'naziv',
        'opis',
        'cena',
        'ambalaza',
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
            'kategorija_id' => 'integer',
            'cena' => 'decimal:2',
        ];
    }

    public function kategorija(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategorija_id');
    }
}
