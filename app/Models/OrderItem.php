<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'porudzbina_id',
        'proizvod_id',
        'kolicina',
        'cena',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'proizvod_id');
    }

    public function order()
{
    return $this->belongsTo(Order::class, 'porudzbina_id');
}

}
