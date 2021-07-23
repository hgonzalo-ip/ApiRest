<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = 'Empleados';
    protected $primaryKey = 'IdEmpleado';

    public $timestamps = false;

    public function DecUsuario(){
        return $this->belongsTo(User::class, 'IdUsuario', 'IdUsuario');
  
    }
    public function Sucursal(){
        return $this->belongsTo(Sucursales::class, 'IdSucursal', 'IdSucursal');
    }
    public function DescEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }
}
