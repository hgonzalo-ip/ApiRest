<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    protected $table = 'Sucursales';
    protected $primaryKey = 'IdSucursal';

    public $timestamps = false;

    public function DescEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }
 
}
