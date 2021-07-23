<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursales;
use Carbon\Carbon;
class SucursalesController extends Controller

{
    public function CrearSucursal(Request $request){
        $Sucursal = new Sucursales();
        $Sucursal->NombreSucursal = $request->NombreSucursal;
        $Sucursal->Direccion = $request->Direccion;
        $Sucursal->Telefono = $request->Telefono;
        $Sucursal->Estado = 1;
        if($Sucursal->save()){
            return response()->json($Sucursal, 200);
        }
    }
    public function ListarTodasSucur(){
        $Sucursales = Sucursales::where('Estado','=',1)->get();
        $SucursalesFormateado = array();
        $SucursalNuevo = [];
        foreach($Sucursales as $Listado){
            $SucursalesFormateado['IdSucursal'] = $Listado->IdSucursal;
            $SucursalesFormateado['NombreSucursal'] = $Listado->NombreSucursal;
            $SucursalesFormateado['Direccion'] = $Listado->Direccion;
            $SucursalesFormateado['Telefono'] = $Listado->Telefono;
            $SucursalesFormateado['EstadoNum'] = $Listado->Estado;
            $SucursalesFormateado['EstadoDescrip'] = $Listado->DescEstado->Descripcion;

            array_push($SucursalNuevo, $SucursalesFormateado);

        }
       
        return response()->json($SucursalNuevo,200);
    }    
    public function ListarTodasSucursalesEstado(Request $request){
        $Sucursales = Sucursales::where('Estado','=',$request->Estado)->get();
        $SucursalesFormateado = array();
        $SucursalNuevo = [];
        foreach($Sucursales as $Listado){
            $SucursalesFormateado['IdSucursal'] = $Listado->IdSucursal;
            $SucursalesFormateado['NombreSucursal'] = $Listado->NombreSucursal;
            $SucursalesFormateado['Direccion'] = $Listado->Direccion;
            $SucursalesFormateado['Telefono'] = $Listado->Telefono;
            $SucursalesFormateado['EstadoNum'] = $Listado->Estado;
            $SucursalesFormateado['EstadoDescrip'] = $Listado->DescEstado->Descripcion;

            array_push($SucursalNuevo, $SucursalesFormateado);

        }
       
        return response()->json($SucursalNuevo,200);
    }

    public function InfoEditSucursal(Request $request){
        $Sucursal = Sucursales::find($request->IdSucursal);
        return response()->json($Sucursal, 200);
    }
    public function EditarSucursal(Request $request){
        $Sucursal = Sucursales::find($request->IdSucursalEdit);
        $Sucursal->NombreSucursal = $request->NombreEdit;
        $Sucursal->Direccion = $request->DireccionEdit;
        $Sucursal->Telefono = $request->TelefonoEdit;
        if($Sucursal->save()){
            return response()->json($Sucursal, 200);
        }

    }
    public function LstHoraActual(){
        $Fecha = Carbon::now('America/Guatemala');
        $Fecha = $Fecha->format('Y-m-d');
        return response()->json($Fecha,200);
    }
    public function LstHoraActualTime(){
        $Hora = Carbon::now('America/Guatemala');
        $Hora = $Hora->format('h:i');
        return response()->json($Hora,200);
    }

    public function DesabilitarSucursal(Request $request){
        $Sucursal = Sucursales::find($request->IdSucursal);
        $Sucursal->Estado = 2;
        if($Sucursal->save()){
            return response()->json($Sucursal, 200);
        }
    }
    public function HabilitarSucursal(Request $request){
        $Sucursal = Sucursales::find($request->IdSucursal);
        $Sucursal->Estado = 1;
        if($Sucursal->save()){
            return response()->json($Sucursal, 200);
        }
    }    
}