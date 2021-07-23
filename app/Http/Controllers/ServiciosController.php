<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicios;
use App\Models\DetalleCita;
class ServiciosController extends Controller
{
    // Listar Todos los servicios
    public function ListadoServicios(){
        $Servicios = Servicios::all();
        $ServcioFormatado = array();
        $ServicioNew = [];

        foreach($Servicios as $Listado){
            $ServcioFormatado['IdServicio'] = $Listado->IdServicio;
            $ServcioFormatado['IdSucursal'] = $Listado->IdSucursal;
            $ServcioFormatado['NombreSucursal'] = $Listado->Sucursal->NombreSucursal;
            $ServcioFormatado['NombreServicio'] = $Listado->NombreServicio;
            $ServcioFormatado['Descripcion'] = $Listado->Descripcion;
            $ServcioFormatado['PrecioVenta'] = $Listado->PrecioVentaServicio;
            $ServcioFormatado['Estado'] = $Listado->Estado;
            $ServcioFormatado['DecEstado'] = $Listado->DecEstado->Descripcion;
            
            array_push($ServicioNew, $ServcioFormatado);
        }
        return response()->json($ServicioNew, 200);
      
    }
    public function ListadoServiciosId(Request $request){
        $Servicios = Servicios::find($request->IdServicio);
      
      
        return response()->json($Servicios, 200);
      
    }
    public function ListadoServiciosIdEditarCita(Request $request){
        $DetalleCita = DetalleCita::where('IdCita','=',$request->IdCita)
                                    ->where('IdServicio','=',$request->IdServicio)->where('Estado','=',5)->get();
        if(count($DetalleCita) == 1){
            $Mensaje = 'Este Servicio ya esta en la cita ';
            
            return response()->json($Mensaje, 203);
        }else{
            $Servicios = Servicios::find($request->IdServicio);           
            return response()->json($Servicios, 200);
        }                                     
    }
    public function CrearServicio(Request $request){
        $Servicio = new Servicios();
        $Servicio->IdSucursal = $request->IdSucursal;
        $Servicio->NombreServicio = $request->NombreServicio;
        $Servicio->Descripcion = $request->DescripcionSv;
        $Servicio->PrecioVentaServicio = $request->PrecioVentaSv;
        $Servicio->Estado = 1;
        if($Servicio->save()){
            return response()->json($Servicio, 200);
        }
        
    }
    //Desabilitar
    public function DesabilitarServicio(Request $request){
        $Servicio = Servicios::find($request->IdServicio);
        $Servicio->Estado = 2;
        if($Servicio->save()){
            return response()->json($Servicio, 200);
        }
    }
    public function HabilitarServicio(Request $request){
        $Servicio = Servicios::find($request->IdServicio);
        $Servicio->Estado = 1;

        if($Servicio->save()){
            return response()->json($Servicio, 200);
        }
    }
    // Filtro 
    public function FiltroSucursales(Request $request){
       
        $Servicio = Servicios::where('IdSucursal','=',$request->FiltroIdSucursal)->get();
        $ServcioFormatado = array();
        $ServicioNew = [];

        foreach($Servicio as $Listado){
            $ServcioFormatado['IdServicio'] = $Listado->IdServicio;
            $ServcioFormatado['IdSucursal'] = $Listado->IdSucursal;
            $ServcioFormatado['NombreSucursal'] = $Listado->Sucursal->NombreSucursal;
            $ServcioFormatado['NombreServicio'] = $Listado->NombreServicio;
            $ServcioFormatado['Descripcion'] = $Listado->Descripcion;
            $ServcioFormatado['PrecioVenta'] = $Listado->PrecioVentaServicio;
            $ServcioFormatado['Estado'] = $Listado->Estado;
            $ServcioFormatado['DecEstado'] = $Listado->DecEstado->Descripcion;
            
            array_push($ServicioNew, $ServcioFormatado);
        }
        return response()->json($ServicioNew, 200);
    }
    public function FiltroEstados(Request $request){
        if($request->Estado != 0){
            $Servicio = Servicios::where('Estado','=',$request->Estado)->where('IdSucursal','=',$request->IdSucursal)->get();
        }else{
            $Servicio = Servicios::where('Estado','<=', 2)->where('IdSucursal','=', $request->IdSucursal)->get();
        }

        $ServcioFormatado = array();
        $ServicioNew = [];

        foreach($Servicio as $Listado){
            $ServcioFormatado['IdServicio'] = $Listado->IdServicio;
            $ServcioFormatado['IdSucursal'] = $Listado->IdSucursal;
            $ServcioFormatado['NombreSucursal'] = $Listado->Sucursal->NombreSucursal;
            $ServcioFormatado['NombreServicio'] = $Listado->NombreServicio;
            $ServcioFormatado['Descripcion'] = $Listado->Descripcion;
            $ServcioFormatado['PrecioVenta'] = $Listado->PrecioVentaServicio;
            $ServcioFormatado['Estado'] = $Listado->Estado;
            $ServcioFormatado['DecEstado'] = $Listado->DecEstado->Descripcion;
            
            array_push($ServicioNew, $ServcioFormatado);
        }
        return response()->json($ServicioNew, 200);
    }
    // Buscador General 
    public function BuscardorGeneralSv(Request $request){
        if($request->IdSucursal == '' || $request->IdSucursal == null){
            $Servcios = Servicios::where('NombreServicio','LIKE', "%{$request->Datos}%")->get();        
        }else{
            $Servcios = Servicios::where('NombreServicio','LIKE', "%{$request->Datos}%")
                                    ->where('IdSucursal', '=', $request->IdSucursal)->get();        
        }
        
        $ServcioFormatado = array();
        $ServicioNew = [];

        foreach($Servcios as $Listado){
            $ServcioFormatado['IdServicio'] = $Listado->IdServicio;
            $ServcioFormatado['IdSucursal'] = $Listado->IdSucursal;
            $ServcioFormatado['NombreSucursal'] = $Listado->Sucursal->NombreSucursal;
            $ServcioFormatado['NombreServicio'] = $Listado->NombreServicio;
            $ServcioFormatado['Descripcion'] = $Listado->Descripcion;
            $ServcioFormatado['PrecioVenta'] = $Listado->PrecioVentaServicio;
            $ServcioFormatado['Estado'] = $Listado->Estado;
            $ServcioFormatado['DecEstado'] = $Listado->DecEstado->Descripcion;
            
            array_push($ServicioNew, $ServcioFormatado);
        }
        return response()->json($ServicioNew, 200);
    }

    //Editar Servicio
        //Info Servicio Editar 
    
    public function InfoEditarServicio(Request $request){
        $Servicio = Servicios::find($request->Id);
        return response()->json($Servicio, 200);
    }
    public function EditarServicio(Request $request){
        $Servicio = Servicios::find($request->IdServicioEdit);
        $Servicio->IdSucursal = $request->SltSucursales;
        $Servicio->NombreServicio = $request->NombreSvEdit;
        $Servicio->PrecioVentaServicio = $request->PrecioVentaSvEdit;
        $Servicio->Descripcion = $request->DescripcionSvEdit;
        if($Servicio->save()){
            return response()->json($Servicio, 200);
        }
    }
}