<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCita extends Model
{
    protected $table = 'DetalleCita';
    protected $primariKey = 'IdDetalleCita';

    public $timestamps = false;

    public function Servicios(){
        return $this->hasMany(Servicios::class, 'IdServicio', 'IdServicio');
    }
    public function Citas(){
        return $this->belongsTo(Citas::class, 'IdCita', 'IdCita');
    }
}
