<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    protected $table = 'Citas';
    protected $primaryKey = 'IdCita';

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
