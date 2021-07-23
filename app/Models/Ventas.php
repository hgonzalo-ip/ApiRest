<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'Ventas';
    protected $primaryKey = 'IdVenta';

    public $timestamps = false;

    public function Clientes(){
        return $this->belongsTo(Clientes::class, 'IdCliente', 'IdCliente');
    }
    public function User(){
        return $this->belongsTo(User::class, 'IdUsuario', 'IdUsuario');
    }
    public function Sucursal(){
        return $this->belongsTo(Sucursales::class, 'IdSucursal', 'IdSucursal');
    }
    public function DecEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }
}
