<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'DetalleVenta';
    protected $primaryKey = 'IdDetalleVenta';

    public $timestamps = false;

    public function Productos(){
        return $this->hasMany(Productos::class, 'IdProducto', 'IdProducto');
    }
    public function Ventas(){
        return $this->belongsTo(Ventas::class, 'IdVenta', 'IdVenta');
    }
    
}
