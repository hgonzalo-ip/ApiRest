<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'Productos';
    protected $primaryKey = 'IdProducto';

    public $timestamps = false;

    public function TipoProdcuto(){
        return $this->belongsTo(TipoProducto::class, 'IdTipoProducto', 'IdTipoProducto');        
    }
    public function Sucursal(){
        return $this->belongsTo(Sucursales::class, 'IdSucursal', 'IdSucursal');        
    }
    public function Proveedor(){
        return $this->belongsTo(Proveedores::class, 'IdProveedor', 'IdProveedor');        
    }
    public function DecEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');        
    }
    
}
