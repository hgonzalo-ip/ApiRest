<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'TipoUsuario';
    protected $primaryKey = 'IdTipoEmpleado';

    public $timestamp = false;
}
