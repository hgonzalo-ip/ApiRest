<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    protected $table = 'TipoProducto';
    protected $primaryKey = 'IdTipoProducto';

    public $timestamps = false;

    public function DecEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }
}
