<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable = ['fecha', 'observaciones'];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(CompraItem::class);
    }

    public function getTotalGeneralAttribute(): float
    {
        return $this->items->sum('precio_total');
    }
}
