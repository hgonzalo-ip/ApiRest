<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'Clientes';
    protected $primaryKey = 'IdCliente';

    public $timestamps = false;
    public function DescEstado(){
        return $this->belongsTo(Estados::class, 'Estado', 'IdEstado');
    }
}
