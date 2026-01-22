<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'productos';

    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'imagen',
        'categoria_id'
    ];

    protected $casts = [
        'precio' => 'float',
        'stock' => 'integer',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
