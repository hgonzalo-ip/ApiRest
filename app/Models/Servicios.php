<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'Servicios';
    protected $primaryKey = 'IdServicio';
    public $timestamps = false;

    public function Sucursal(){
        return $this->belongsTo(Sucursales::class, 'IdSucursal', 'IdSucursal');
    }
    public function DecEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }
}
