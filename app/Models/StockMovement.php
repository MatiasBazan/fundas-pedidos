<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';

    public $timestamps = false;

    protected $fillable = [
        'stock_id',
        'tipo',
        'cantidad',
        'cantidad_anterior',
        'cantidad_nueva',
        'referencia_tipo',
        'referencia_id',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}