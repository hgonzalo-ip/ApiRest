<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'DetalleCompra';
    protected $primaryKey = 'IdDetalleCompra';

    public $timestamps = false;

    public function Compra(){
        return $this->belongsTo(Compras::class, 'IdCompra', 'IdCompra');
    }
    public function Productos(){
        return $this->hasMany(Productos::class, 'IdProducto', 'IdProducto');
    }
}
