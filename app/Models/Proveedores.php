<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table = 'Proveedores';
    protected $primaryKey = 'IdProveedor';

    public $timestamps = false;


    public function DescEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }
}
