<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Order extends Model
{
    protected $fillable = [
        'kupac_id',
        'status',
    ];

public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'porudzbina_id');
}

    
}

