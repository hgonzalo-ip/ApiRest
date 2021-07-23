<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $table = 'Compras';
    protected $primaryKey = 'IdCompra';

   
    public $timestamps = false;

    public function DecSucursal(){
        return $this->belongsTo(Sucursales::class, 'IdSucursal', 'IdSucursal');
    }
    public function DecUser(){
        return $this->hasMany(User::class, 'IdUsuario','IdUsuario');
    }
    public function DecEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }    
    
}
