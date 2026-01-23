<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'cliente'];
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
